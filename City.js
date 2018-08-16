window.City = {
	show: function() {
		Event.one('Controller.onshow', function () {
			Popup.open(City.layer);
		});
	},
	layer: {
		"divs":{
			"citydescr":{
				"data":true,
				"tpl":"~city.tpl"
			},
			"citychoicesel":{
				"tpl":"-city/choice.tpl",
				"data":true
			}
		},
		"tplroot":"root",
		"tpl":"-city/city.tpl"
	}
}
