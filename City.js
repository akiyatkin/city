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
	choice: () => {
		Popup.open(City.layerchoice)
		return new Promise(resolve => {
			City.layerchoice.config.resolve = resolve
		})
	},
	layerchoice: {
		"jsontpl":"-city/api/countries?city_id={City.id()}&lang={City.lang()}",
		"config":{
			"country_id":false
		},
		"tplroottpl":"CHOICE",
		"tpl":"-city/city.tpl"
	},
	show: () => {
		Popup.open(City.layer)
	},
	layer: {
		"jsontpl":"-city/api/countries?city_id={City.id()}&lang={City.lang()}",
		"config":{
			"country_id":false
		},
		"tplroottpl":"POPUP",
		"tpl":"-city/city.tpl"
	}
}
window.City = City
export { City }