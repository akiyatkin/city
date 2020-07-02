{root:}
<div class="city pb-3">
	<h1>Выберите город</h1>
	<p>
		{Config.get().city.list::btn}
	</p>
	<p>
		<a href="?-env={Env.getName()}:city" class="a {Env.getName()??:font-weight-bold}">
			Определить автоматически
		</a>
	</p>
	<p>
		Ваш город: <b>{Env.get().city}</b>
	</p>
</div>
{SEARCH:}
<div class="city pb-3">
	<h1>Выберите город</h1>
	<p>
		<form>
			<input placeholder="Начните вводить..." id="cityinput" class="form-control" type="text" list="citieslist"
			autocomplete="off">
			<datalist id="citieslist">
				{data.list::opt}
			</datalist>
		</form>
	</p>
	<p>
		<a href="?-env={Env.getName()}:city" class="a {Env.getName()??:font-weight-bold}">
			Определить автоматически
		</a>
	</p>
	<p>
		Ваш город: <b>{Env.get().city}</b>
	</p>
	<script async type="module">
		import { Crumb } from '/vendor/infrajs/controller/src/Crumb.js'
		import { Popup } from '/vendor/infrajs/popup/Popup.js'
		import { Env } from "/vendor/infrajs/env/Env.js"
		
		let div = document.getElementById('{div}')
		let a = div.getElementsByClassName('a')[0]
		a.addEventListener('click', () => {
			Popup.close()
		})

		let input = document.getElementById('cityinput')
		input.addEventListener('change', () => {
			let optionFound = false,
			datalist = input.list
			for (let j = 0; j < datalist.options.length; j++) {
				if (input.value == datalist.options[j].value) {
					optionFound = true;
					break;
				}
			}
			if (optionFound) {
				Crumb.go('?-env=' + Env.getName() + ':city=' + input.value)
				Popup.close()
			}
		})
	</script>
</div>
{opt:}<option value="{2|1}">{0=:Респ?:respub?:row}</option>
{row:}{1} {0} {2}
{respub:}{0} {1} {2}
{btn:}
<a href="?-env={Env.getName()}:city={.}" class="btn btn-{Env.get().city=.?:danger?:secondary}">{Lang.str(:city,.)}</a>
{CITY:}<span class="a -city-str"
	onclick="domready( function () { City.show() });">{Lang.str(:city,Env.get().city)}</span>