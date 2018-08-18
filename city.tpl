{root:}
	<div class="city">
		<style scoped>
			.city .bold {
				font-weight:bold;
			}
		</style>
		
		<div id="citydescr"></div>
		<div id="citychoicesel"></div>
	</div>
{CITY:}<span class="a -city-str" onclick="domready( function () { City.show() });">{Lang.str(:city,Env.get().city)}</span>