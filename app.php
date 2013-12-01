<?php 

include "config.php";

include "./lib/Autoload.php";

include "./lib/FrontController.php";

$config = new Config();

new AutoLoader($config);

$FrontController = new FrontController($config);

$FrontController->run();
