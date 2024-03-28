$(document).on('click','#btn-signup-submit',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var username = $('#input-signup-username').val();
    var password = $('#input-signup-password').val();
    var confirm = $('#input-signup-confirm').val();
    var role = $('#input-user-type').val();
    var term_code = $('#input-user-terminal').val();
    var pkey = $('#input-signup-pkey').val();
    var aname = $('#input-signup-aname').val();
   
    if (term_code == 'null' || role == 'null') {

        Swal.fire({
            icon: 'error',
            text: 'All fields are required',
        })

    } else {
        $.ajax({
            url: '../../web/authenticate/ajax/router.php', // point to server-side PHP script 
            data: {
                'type' : type,
                'username' : username,
                'password' : password,
                'confirm' : confirm,
                'role' : role,
                'term_code' : term_code,
                'pkey' :pkey,
                'aname' : aname
            },                         
            type: 'post',
            success: function(response){
    
                var response = JSON.parse(response);
                
                if (response['type'] == 'success') {
                    Swal.fire({
                        icon: 'success',
                        text: response['msg'],
                    }).then(function(){
                        window.location.reload();
                    });
                } else {
                    var errors = response['msg'].toString();
    
                    Swal.fire({
                        icon: 'error',
                        text: errors,
                    })
                }
            }
        });
    }
   
    return false;
});

$(document).on('click','#btn-login-submit',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var username = $('#input-login-username').val();
    var password = $('#input-login-password').val();
   
    $.ajax({
        url: '../../web/authenticate/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'username' : username,
            'password' : password,
        },                         
        type: 'post',
        success: function(response){

            var response = JSON.parse(response);
            
            if (response['type'] == 'success') {
                
                window.location.href = "../../index.php";

            } else {
                var errors = response['msg'].toString();

                Swal.fire({
                    icon: 'error',
                    text: errors,
                })
            }
        }
     });
   
    return false;
});