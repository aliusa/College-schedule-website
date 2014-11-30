$(document).ready(function(){
	//gauna duomenis iš `groups` lentelės duomenų bazėje
	//ir atvaizduoja `group_short` input formos pasirinkytyje
	$.ajax({
		url: "core/func/searchGroup.php",
		data: {id: 1},
		dataType: "json",
		success: function(response){
			var data = $(response).map(function(){
				//return columns of table
				return {value: this.group_short, id: this.group_id};
			}).get();

			//autofills input form with selected id
			$('#group').autocomplete({
				source: data,
				minLength: 0,
				select: function(event,ui){
					$('input#hiddenGroup').val(ui.item.id);
				}
			});
		}
	});/**/

	//gauna duomenis iš `staff` lentelės duomenų bazėje
	//ir atvaizduoja `staff_displayName` input formos pasirinkytyje
	$.ajax({
		url: "core/func/searchStaff.php",
		data: {id: 1},
		dataType: "json",
		success: function(response){
			var data = $(response).map(function(){
				//return columns of table
				return {value: this.staff_displayName, id: this.staff_id};
			}).get();

			//autofills input form with selected id
			$('#staff').autocomplete({
				source: data,
				minLength: 0,
				select: function(event,ui){
					$('input#hiddenStaff').val(ui.item.id);
				}
			});
		}
	});/**/

	window.addEvent('load', function() {
		new DatePicker('.demo_vista', { pickerClass: 'datepicker_vista' });
		new DatePicker('.demo_dashboard', { pickerClass: 'datepicker_dashboard' });
		new DatePicker('.demo_jqui', { pickerClass: 'datepicker_jqui', positionOffset: { x: 0, y: 5 } });
		new DatePicker('.demo', { positionOffset: { x: 0, y: 5 }});
	});
});