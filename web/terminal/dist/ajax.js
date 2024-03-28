$(document).on('click','#btn-add-terminal',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var id = $('#input-terminal-id').val();
    var term_code = $('#input-terminal-code').val();
    var term_name = $('#input-terminal-name').val();

    // alert('added');
   
    $.ajax({
        url: '../web/terminal/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'term_code' : term_code,
            'term_name' : term_name,
            'id' : id,
        },                         
        type: 'post',
        success: function(response){

            var response = JSON.parse(response);

            // console.log(response);
            
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
   
    return false;
});

$(document).on('click','#btn-edit-terminal',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var term_code = $(this).parent().siblings('.term-code').text();
    var term_name = $(this).parent().siblings('.term-name').text();

    $('#input-terminal-id').val(id);
    $('#input-terminal-code').val(term_code);
    $('#input-terminal-name').val(term_name);
    $('#btn-add-terminal').attr('data-type', 'edit');
    $('.card-title-terminal').text('Update Terminal');

    // alert('edited' + id);

    return false;
});

$(document).on('click','#btn-clear-terminal',function(e) {
    e.preventDefault();

    $('#input-terminal-id').val('');
    $('#input-terminal-code').val('');
    $('#input-terminal-name').val('');
    $('#btn-add-terminal').attr('data-type', 'add');
    $('.card-title-terminal').text('Add New Terminal');

    return false;
});

$(document).on('click','#btn-del-terminal',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var type = 'delete';
    var term_code = $('#input-terminal-code').val();
    var term_name = $('#input-terminal-name').val();

    // alert('deleted' + id);

    Swal.fire({

        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '../web/terminal/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'term_code' : term_code,
                    'term_name' : term_name,
                    'id' : id,
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
    })

    return false;
});

