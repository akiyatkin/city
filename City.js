import { Config } from '/vendor/infrajs/config/Config.js'
import { Load } from '/vendor/akiyatkin/load/Load.js'
import { Lang } from '/vendor/infrajs/lang/Lang.js'
import { Layer } from '/vendor/infrajs/controller/src/Layer.js'
import { Env } from '/vendor/infrajs/env/Env.js'

const City = {
	lang: Lang.fn('city'),
	id: () => Env.get().city_id,
	get: async () => {
		let lang = City.lang();
		let city_id = City.id();
		let src = '-city/api/get?city_id='+city_id+'&lang='+lang;
		let city = await Load.fire('json',src);
		return city;
	},
	choice: async () => {
		const { Popup } = await import('/vendor/infrajs/popup/Popup.js')
		Popup.open(City.layerchoice)
		return new Promise((resolve) => {
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
	show: async () => {
		const { Popup } = await import('/vendor/infrajs/popup/Popup.js')
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
Layer.syne('hide', layer => {
	if (layer !== City.layerchoice) return
	City.layerchoice.config.resolve(null)
})

export { City }