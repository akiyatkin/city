Event.handler('Controller.onshow', async () => {
	let Load = (await import('/vendor/akiyatkin/load/Load.js')).default
	let CDN = await Load.on('import-default', '/vendor/akiyatkin/load/CDN.js')
	await CDN.load('jquery')
	var city = City.get();
	if (Env.get().city == city) return;	
	$('.-city-str').html(city);
});