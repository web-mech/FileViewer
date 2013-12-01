//This initializes everything client-side.
define(['jquery','controllers/search','controllers/document','controllers/meta'],function($,Search,Document,Meta){
	new Search('#page-controls');
	new Document('#document');
	new Meta('#file-info');
});