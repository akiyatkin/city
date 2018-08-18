Event.handler('Controller.onshow', function () {
	var city = City.get();
	if (Env.get().city == city) return;	
	$('.-city-str').html(city);
});