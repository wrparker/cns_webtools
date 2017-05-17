$(document).ready(function(){
  $('.interactiveSearch').submit(false);
});

$("#homeSearch").on('input', function(){
    var searchText = $(this).val();
        $(".appButton").each(function(){
        var appNames = $(this).children().text();
        if(appNames.toLowerCase().indexOf(searchText.toLowerCase()) >= 0){
            $(this).parent().show();
        }
        else{
            $(this).parent().hide();
        }

    });
});