// Bootstrap multiselect dropdown
$(document).ready(function() {
// tvarkarastis_pridet.php - Grupė
    $('#grupeinputas').multiselect({
    	maxHeight: 300,
    	enableFiltering: true,
        filterBehavior: 'text',
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'form-control'
    });
// tvarkarastis_pridet.php - Auditorija
    $('#auditorijainputas').multiselect({
    	maxHeight: 250,
    	enableFiltering: true,
        filterBehavior: 'text',
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'form-control'
    });
// tvarkarastis_pridet.php - Dalykas
    $('.multiselect#dalykasinputas').multiselect({
        maxHeight: 250,
        enableFiltering: true,
        filterBehavior: 'text',
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'form-control'
    });
// tvarkarastis_pridet.php - Dėstytojas
    $('.multiselect#destytojasinputas').multiselect({
        maxHeight: 250,
        enableFiltering: true,
        filterBehavior: 'text',
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'form-control'
    });
// tvarkarastis_pridet.php - Pogrupis
/*    $('.multiselect#pogrupioinputas').multiselect({
        maxHeight: 250,
        enableFiltering: true,
        filterBehavior: 'text',
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'form-control'
    });/**/
// tvarkarastis_pridet.php - Pogrupis
/*    $('.multiselect#pasirenkamasisinputas').multiselect({
        maxHeight: 250,
        enableFiltering: true,
        filterBehavior: 'text',
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'form-control'
    });/**/
});

// Bootstrap multidate picker
$('#cia-yra-multidate .input-group.date').datepicker({
    format: "yyyy-mm-dd",
    language: "lt-LT",
    multidate: true,
    multidateSeparator: ", ",
    startDate: "2013-09-01",
    endDate: "2016-12-31"
});