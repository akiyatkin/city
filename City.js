window.City = {
	set: function (city) {
		var old = City.get();
		//if (old == city) return;
		Session.set('user.city', city);
		Controller.Global.check('user');
		Event.tik('City.onset');
		Event.fire('City.onset');
		return true;
	},
	get: function () {
		var city = Session.get('user.city','Тольятти');
		if (city != 'Тольятти' && city != 'Самара') city='Тольятти';
		return city;
	},
	show: function() {
		Event.one('Controller.onshow', function () {
			Popup.open(City.layer);
			infrajs.popup_memorize('City.show()');
		});
	},
	layer: {
		"global":"user",
		"autosavename":"user",
		"tplroot":"root",
		"divs":{
			"citydescr":{
				"tpl":"~city.tpl"
			},
			"citychoicesel":{
				"tpl":"-city/choice.tpl",
				"data":true
			}
		},
		"tpl":"-city/city.tpl"
	}
}
Event.fire('City.onset');
//Event.handler('layer.onhide', function (layer) {
//	//Controller.Global.check(layer.global);
//}, '', City.layer);
