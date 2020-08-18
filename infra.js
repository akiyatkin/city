// import { CDN } from '/vendor/akiyatkin/load/CDN.js'
import { DOM } from '/vendor/akiyatkin/load/DOM.js'
// import { Env } from "/vendor/infrajs/env/Env.js"
//import { City } from "/vendor/akiyatkin/city/City.js"



let cls = cls => document.getElementsByClassName(cls)
let ws = new WeakSet() 
DOM.done('load', () => {
	for (let el of cls('showCity')) {
		if (ws.has(el)) continue
		ws.add(el)
		el.addEventListener('click', async event => {
			event.preventDefault();
			let { City } = await import('/vendor/akiyatkin/city/City.js')
			City.show()
		})
	}
})
// DOM.hand('load', async () => {
// 	let city = City.get()
// 	if (Env.get().city.ru == city.ru) return;
// 	await CDN.fire('load','jquery')
// 	$('.-city-str').html(city.ru)
// });