<div class="citychoice">
	<div class="citybtn">
		{Config.get(:city).list::btn}
	</div>
</div>
{btn:}<span
	onclick="Crumb.get['-env']='{Env.name()}:city={.}'; Env.refresh(); Popup.close(); Controller.check(); " class="choice btn btn-{Env.get().city=.?:danger?:default}">{Lang.str(:city,.)}</span> 