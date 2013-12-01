//entry point to client side app.
requirejs.config({
	baseUrl:'./js/lib/',
	paths:{
		'jquery':'jquery/jquery.min',
		'can':'canjs/dist/can.jquery',
		'moment':'moment/moment',
		'models':'../models',
		'controllers':'../controllers',
		'views': '../../views'
	}
});

require(['controllers/main']);