$(document).ready(function(){
	//gauna duomenis iš `groups` lentelės duomenų bazėje
	//ir atvaizduoja `group_short` input formos pasirinkytyje
	$.ajax({
		url: "core/func/searchGroup.php",
		data: {id: 1},
		dataType: "json",
		success: function(response){
			var data = $(response).map(function(){
				return {value: this.group_short, id: this.group_id};
			}).get();

			$('#name').autocomplete({
				source: data,
				minLength: 0,
				select: function(event,ui){
					$('input#id').val(ui.item.id);
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
				return {value: this.staff_displayName, id: this.staff_id};
			}).get();

			$('#staff').autocomplete({
				source: data,
				minLength: 0,
				select: function(event,ui){
					$('input#id').val(ui.item.id);
				}
			});
		}
	});/**/
});