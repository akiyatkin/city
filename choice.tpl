<div class="citychoice">
	<div class="citybtn">
		{Config.get(:city).list::btn}
		<span
	onclick="Crumb.get['-env']='{Env.name()}:city='; Env.refresh(); Popup.close(); Controller.check(); " class="choice btn btn-{Env.get().city?:secondary?:danger active}">Определить автоматически</span> 
	</div>
</div>
{btn:}<span
	onclick="Crumb.get['-env']='{Env.name()}:city={.}'; Env.refresh(); Popup.close(); Controller.check(); " class="choice btn btn-{Env.get().city=.?:danger active?:secondary}">{Lang.str(:city,.)}</span> 