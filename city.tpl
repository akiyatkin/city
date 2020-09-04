{optcountry:}<option {config.country_id?(config.country_id=country_id?:selected)?(data.city.country_id=country_id?:selected)} data-country_id="{country_id}">{name}</option>
{CHOICE:}
	<h1>{City.lang(:Выберите город)}</h1>
	<p>
		<span class="a">{City.lang(:Определить автоматически)}</a>
	</p>
	{:selects}
	<script type="module" async>
		import { Crumb } from '/vendor/infrajs/controller/src/Crumb.js'
		import { Popup } from '/vendor/infrajs/popup/Popup.js'
		
		let input = document.getElementById('cityinput')
		let datalist = input.list
		let layer = Controller.ids[{id}]
		let div = document.getElementById('{div}')
		let a = div.getElementsByClassName('a')[0]
		a.addEventListener('click', () => {
			layer.config.resolve(false)
			Popup.close()
		})
		input.addEventListener('change', () => {
			let city_id = false;
			for (let j = 0; j < datalist.options.length; j++) {
				if (input.value == datalist.options[j].value) {
					city_id = datalist.options[j].dataset.city_id;
					break;
				}
			}
			if (city_id) {
				layer.config.resolve(city_id)
				Popup.close()
			}
		})
	</script>
{POPUP:}
	<h1>{City.lang(:Выберите город)}</h1>
	<p>
		<a href="?-env={Env.getName()}:city_id" class="a {Env.getName()??:font-weight-bold}">
			{City.lang(:Определить автоматически)}
		</a>
	</p>
	{:selects}
	<script type="module" async>
		import { Crumb } from '/vendor/infrajs/controller/src/Crumb.js'
		import { Popup } from '/vendor/infrajs/popup/Popup.js'
		
		let input = document.getElementById('cityinput')
		let datalist = input.list
		let div = document.getElementById('{div}')
		let a = div.getElementsByClassName('a')[0]
		a.addEventListener('click', () => Popup.close())
		input.addEventListener('change', () => {
			let city_id = false;
			for (let j = 0; j < datalist.options.length; j++) {
				if (input.value == datalist.options[j].value) {
					city_id = datalist.options[j].dataset.city_id;
					break;
				}
			}
			if (city_id) {
				Crumb.go('?-env=' + Env.getName() + ':city_id=' + city_id, false)
				Popup.close()
			}
		})
	</script>	
{opt:}
	<option data-city_id="{city_id}" value="{name}">{region}</option>
{btn:}
	<a href="?-env={Env.getName()}:city_id={.}" class="btn btn-{Env.get().city=.?:danger?:secondary}">{.}</a>
{selects:}
	<h2>{City.lang(:Страна)}</h2>
	<p>
		<select id="countryinput" class="form-control" type="text">
			{data.countries::optcountry}
		</select>
	</p>
	<h2>{City.lang(:Город)}</h2>
	<p>
		<form>
			<input placeholder="{City.lang(:Начните вводить...)}" id="cityinput" class="form-control" type="text" list="citieslist" autocomplete="off">
			<datalist id="citieslist">
				{data.cities::opt}
			</datalist>
		</form>
	</p>
	<script type="module" async>
		import { Crumb } from '/vendor/infrajs/controller/src/Crumb.js'
		import { Popup } from '/vendor/infrajs/popup/Popup.js'
		import { Env } from "/vendor/infrajs/env/Env.js"
		import { Load } from "/vendor/akiyatkin/load/Load.js"
		
		let layer = Controller.ids[{id}]
		let div = document.getElementById('{div}')
		// let a = div.getElementsByClassName('a')[0]
		// a.addEventListener('click', () => {
		// 	Popup.close()
		// })
		let input = document.getElementById('cityinput')
		let datalist = input.list
		let select = document.getElementById('countryinput')
		select.addEventListener('change', () => {
			let n = select.options.selectedIndex
			let country_id = select.options[n].dataset.country_id
			layer.config.country_id = country_id
			datalist.innerHTML = '';
			//DOM.emit('check')
		})
		
		let orightml = datalist.innerHTML
		let city_id = City.id()
		let work = false;
		let check = () => {
			
			let n = select.options.selectedIndex
			let country_id = select.options[n].dataset.country_id
			
			let value = input.value
			let src = '-city/api/search?country_id='+country_id+'&lang='+Lang.name()+'&val='+value;
			work = src;
			Load.fire('json', src).then(ans => {
				if (work != src) return
				let removes = []
				for (let opt of datalist.options) {
					let finded = false
					for (let city of ans.cities) {
						if (opt.dataset.city_id == city.city_id) {
							finded = true;
							break;
						}
					}

					if (!finded) removes.push(opt)
				}
				for (let opt of removes) opt.remove()

				let cities = []
				for (let city of ans.cities) {
					let finded = false
					for (let opt of datalist.options) {
						if (opt.dataset.city_id == city.city_id) {
							finded = true;
							break;
						}
					}
					if (!finded) cities.push(city)
				}
				for (let city of cities) {
					let option = document.createElement('option');
					option.innerText = city.region
					option.value = city.name
					option.dataset.city_id = city.city_id
					datalist.append(option)
				}
			})
		}
		check()
		input.addEventListener('keyup', check)
		input.addEventListener('click', check)
	</script>