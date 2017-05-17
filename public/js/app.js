/*Used function to confirm deletion of data types.  */
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete this record? THIS ACTION CANNOT BE UNDONE!");
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


