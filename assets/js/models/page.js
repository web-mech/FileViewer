//This model requests data from the server for pages.
define(['can'],function(){
	var pageModel = can.Construct.extend({
		postUrl:'../page/request',
		getUrl:'../page/get/',
		init:function(){
			this.list = new can.List([]);
			this.current = can.compute(false);
		},
		open:function(data){
			$.ajax({
				url: this.postUrl,
				type:'POST',
				data:{
					id: data.id,
					name: data.name,
					type: data.type
				},
				dataType:'json',
				success:function(data){
					this.current(data);
				}.bind(this),
				error:function(){

				}
			});
		},
		get:function(name){
			$.ajax({
				url: this.getUrl+name,
				type:'GET',
				dataType:'json',
				success:function(data){
					this.list.replace(data);
				}.bind(this),
				error:function(){

				}
			});
		}
		
	});
	return new pageModel();
});