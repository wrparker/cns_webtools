/*Used function to confirm deletion of data types.  */
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete this record?");
    if (x)
        return true;
    else
        return false;
}


/*Wrap this in a document ready for pages that need a datepicker.*/
    //Initialize datepicker calendar forms.
function initializeDatePicker(){
    $( ".datepick" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
}


/* Ready Functions*/
/*$(document).ready(function(){
    //Dont allow clicking after once pressed for form submissions.
    $('button[type=submit]').click(function() {
        $(this).attr('disabled', 'disabled');
        $(this).text("Submitting...");
        $(this).parents('form').submit()
    });
});*/


