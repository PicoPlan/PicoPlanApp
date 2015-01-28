function addEvent(type,id){
	var urlEvent = '/dev/app_dev.php/oki/form/'+type+'/'+id;
	$.get(urlEvent,function(data,status){
		if(status == 'success') {
			$(".DynamicAddEvent").html(data);
		}
	});
}