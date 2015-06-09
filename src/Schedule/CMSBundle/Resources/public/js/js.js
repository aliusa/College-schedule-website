$(function() {

    //highlight the current nav
    $("#schedule a:contains('Tvarkaraštis')").parent().addClass('active');
    $("#lecturer a:contains('Dėstytojai')").parent().addClass('active');
    $("#course a:contains('Paskaitos')").parent().addClass('active');
    $("#faction a:contains('Grupės')").parent().addClass('active');
    $("#classroom a:contains('Auditorijos')").parent().addClass('active');
    $("#lecturercourse a:contains('Dėst/Pask')").parent().addClass('active');
    
    
}); //jQuery is loaded