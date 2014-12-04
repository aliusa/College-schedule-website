$(document).ready(function(){
	//gets data from `groups` table
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

	//gets data from `staff` table
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

	//gets data from `courses_names` table
	//ir atvaizduoja `course_title` input formos pasirinkytyje
	$.ajax({
		url: "core/func/searchCourse.php",
		data: {id: 1},
		dataType: "json",
		success: function(response){
			var data = $(response).map(function(){
				//return columns of table
				return {value: this.course_title, id: this.course_id};
			}).get();

			//autofills input form with selected id
			$('#course').autocomplete({
				source: data,
				minLength: 0,
				select: function(event,ui){
					$('input#hiddenCourse').val(ui.item.id);
				}
			});
		}
	});/**/


});