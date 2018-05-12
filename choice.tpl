<div class="citychoice">
	<div class="citybtn" style="display:none">
		<button type="button" data-city="Тольятти" class="choice btn btn-default">Тольятти</button>
		<button type="button" data-city="Самара" class="choice btn btn-default">Самара</button>
	</div>
	<script>
		domready( function () {
			Once.exec('layer{id}', function () {
				Event.one('Controller.oncheck', function () {
					var check = function (layer) {
						var div = $('#' + layer.div).find('.citychoice');
						var city = City.get();
						div.find('.choice').addClass('btn-default').removeClass('btn-danger').removeClass('active'); 
						div.find('.choice[data-city=' + city + ']').addClass('btn-danger').addClass('active').removeClass('btn-default');
					}
					var layer = Controller.ids[{id}];
					
					Event.handler('Layer.onshow', function (layer) {
						var div = $('#' + layer.div).find('.citychoice');
						div.find('button').click( function () {
							var city = $(this).data('city');
							City.set(city);
							check(layer);
							Popup.close();
						});
					}, '', layer);
					Event.handler('City.onset', function () {
						check(layer);
					});
				});
			});
			Event.one('Controller.onshow', function () {
				var layer = Controller.ids[{id}];
				var div = $('#' + layer.div).find('.citychoice');
				div.find('.citybtn').fadeIn('slow');
			});

		});
	</script>
</div>