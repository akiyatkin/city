import { Popup } from '/vendor/infrajs/popup/Popup.js'
import { Config } from '/vendor/infrajs/config/Config.js'
import { Load } from '/vendor/akiyatkin/load/Load.js'
import { Lang } from '/vendor/infrajs/lang/Lang.js'
let City = {
	lang: Lang.fn('city'),
	id: () => Env.get().city_id,
	get: async () => {
		let lang = City.lang();
		let city_id = City.id();
		let src = '-city/api/get?city_id='+city_id+'&lang='+lang;
		let city = await Load.fire('json',src);
		return city;
	},
	show: () => {
		if (!Config.get().city.list.length) {
			Popup.open(City.layersearch)
		} else {
			Popup.open(City.layer)
		}
	},
	layersearch: {
		"parsedtpl":"{City.lang()}{City.id()}",
		"json":"-city/list",
		"tplroot":"SEARCH",
		"tpl":"-city/city.tpl"
	},
	layer: {
		"jsontpl":"-city/api/?city_id={City.id()}&lang={City.lang()}",
		"tplroot":"root",
		"tpl":"-city/city.tpl"
	}
}
window.City = City
export { City }