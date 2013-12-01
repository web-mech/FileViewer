//displays the file name above the document.
define(['jquery','models/page','can'],function($,Page){
	return can.Control({
		view:'views/meta.mustache',
		init:function(el,options){
			this.render();
		},
		render:function(){
			this.element.html(can.view(this.view,{Page:Page}));
		}
	});
})