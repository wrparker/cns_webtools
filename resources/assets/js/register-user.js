    $( document ).ready(function() {
        $('#ldap_enabled').change(function() {
            if(this.checked){
                $('#name').removeAttr("required");
                $('#name').attr("disabled", true);
                $('#email').removeAttr("required");
                $('#email').attr("disabled", true);
                $('#password').removeAttr("required");
                $('#password').attr("disabled", true);
                $('#password-confirm').removeAttr("required");
                $('#password-confirm').attr("disabled", true);
            }
        })

    });
