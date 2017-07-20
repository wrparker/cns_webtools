/*Small color changger for visibilty and status*/

$( document ).ready(function() {
    initializeDatePicker(); //initialize datepicker.... function in app.js
    $('.colorchanger').change(function() {
        var state =$(this).val();
        if(state == "0"){
            $(this).css('background-color', 'orangered');
        }
        else{
            $(this).css('background-color', 'greenyellow');
        }
    });



});
