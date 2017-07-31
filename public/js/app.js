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

$( document ).ready(function() {
    $(".rowSelection").change(function(){
        if(this.checked){
            $(this).closest('tr').css('background-color', '#FA8072');
        }
        else{
            $(this).closest('tr').css('background-color', 'inherit');
        }

    })

});