    $( document ).ready(function() {
        changeForm($('#ldap_enabled').is(':checked'));

        $('#ldap_enabled').change(function() {
            changeForm($('#ldap_enabled').is(':checked'));
        })
    });

    function changeForm(ldap_enabled){
        if(ldap_enabled){
            switchOff($('#name'), true);
            switchOff($('#email'), true);
            switchOff($('#password'), true);
            switchOff($('#password-confirm'), true);
        }
        else{
            switchOff($('#name'), false);
            switchOff($('#email'), false);
            switchOff($('#password'), false);
            switchOff($('#password-confirm'), false);
        }
    }

    function switchOff(object, boolean){
        if(boolean == true){
            object.attr("required", false);
            object.attr("disabled", true);
            object.attr("visibility", "none");
            object.parent().parent().hide();
        }
        else{
            object.attr("disabled", false);
            object.attr("required", true);
            object.attr("visibility", "inherit");
            object.parent().parent().show();
        }
    }
