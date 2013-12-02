<?php
/**
  * Main gateway to the application. 
  *
  * This detects the url path and loads the appropriate controller or throws and error if an invalid path is given.
  *
  * @author  Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
interface FrontControllerInterface
{
    public function setController($controller);
    public function setAction($action);
    public function setParams(array $params);
    public function run();
}

/**
 * Front controller, responsible for routing, delegating paths to actions.
 */
class FrontController implements FrontControllerInterface {
    protected $config;
    protected $action;
    protected $controller;
    protected $params = array();
    
    public function __construct($config, array $options = array()){
        $this->config = $config;

        $this->rootPath = $config->basePath;

        if (empty($options)) {
           $this->controller = $config->defaultController; //default controller set in the config file to run.
           $this->action = $config->defaultAction; //default action set in the config file to run.
           $this->parseUri();
        }

        return $this;
    }

    /**
     * Main function of the FrontController, This determines what actions to take based on the url path.
     */
    private function parseUri(){
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        $path = preg_replace('/index.php/', "", $path);
         
        if (strpos($path, $this->rootPath) === 0) {
            $path = substr($path, strlen($this->rootPath));
        }

        $path = trim($path,"/");
        
        @list($controller, $action, $params) = explode("/", $path, 3);
        
        if (!empty($controller)) {
            $this->setController($controller);
        }else{
            $this->setController($this->config->defaultController);
        }
        
        if (!empty($action)) {
            $this->setAction($action);
        }else{
            $this->setAction($this->config->defaultAction);
        }

        if (!empty($params)) {
            $this->setParams(explode("/", $params));
        }
    }

    public function setController($controller){
        $controller = ucfirst(strtolower($controller)) . "Controller";

        if (!class_exists($controller)) {
            throw new InvalidArgumentException("The action controller '$controller' has not been defined.");
        }

        $this->controller = $controller;

        return $this;
    }

    public function setAction($action){
        $reflector = new ReflectionClass($this->controller);

        if (!$reflector->hasMethod($action)) {
            throw new InvalidArgumentException("The controller action '$action' has been not defined.");
        }

        $this->action = $action;

        return $this;
    }

    public function setParams(array $params){
        $this->params = $params;

        return $this;
    }

    public function run(){
        call_user_func(array(new $this->controller, $this->action), $this->params);
    }
}