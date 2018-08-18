window.City = {
	lang: function (str, lang) {
		if (typeof(str) == 'undefined') return Lang.name('cart');
		return Lang.str('city', str, lang);
	},
	get: function(lang){
		if (!lang) lang = Lang.name();
		
		if (Env.get().city) return City.lang(Env.get().city, lang); //В окружении есть явно указанный город	
		var data = Load.loadJSON('-city/true/'+lang);
		if (!data.city) data.city = City.lang(data.conflist[0], lang);//Автоопределение не сработало
		return data.city;
	},
	show: function() {
		Event.one('Controller.onshow', function () {
			Popup.open(City.layer);
		});
	},
	layer: {
		"divs":{
			"citydescr":{
				"data":true,
				"tpl":"~city.tpl"
			},
			"citychoicesel":{
				"tpl":"-city/choice.tpl",
				"data":true
			}
		},
		"tplroot":"root",
		"tpl":"-city/city.tpl"
	}
}
