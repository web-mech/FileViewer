//this searches for and opens documents.
define(['jquery','models/page','can'],function($,Page){
	return can.Control({
		view:'views/search.mustache',
		init:function(el,options){
			this.render();
		},
		"input keyup":function(el,ev){
			Page.get(el.val());
		},
		"li.link click":function(el,ev){
			Page.open(el.data('page'));
		},
		render:function(){
			this.element.html(can.view(this.view,{Page:Page}));
		}
	});
})