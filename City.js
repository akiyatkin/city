import { Popup } from '/vendor/infrajs/popup/Popup.js'
let City = {
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
		if (!Config.get('city').list.length) {
			Popup.open(City.layersearch)
		} else {
			Popup.open(City.layer)
		}
	},
	layersearch: {
		"parsedtpl":"{Env.getName()}",
		"json":"-city/list",
		"tplroot":"SEARCH",
		"tpl":"-city/city.tpl"
	},
	layer: {
		"parsedtpl":"{Env.getName()}",
		"data":true,
		"tplroot":"root",
		"tpl":"-city/city.tpl"
	}
}
window.City = City
export { City }