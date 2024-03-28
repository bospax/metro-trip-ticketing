$("#btn-import-vehicle").click(function() {

    var file_data = $('#input-import-vehicle').prop('files')[0];   
    var form_data = new FormData();      

    form_data.append('file', file_data);

    // alert(form_data);          

    $.ajax({
        url: '../web/vehicles/ajax/import_vehicle.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
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
                Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                })
            }
            // console.log(response);
        }
     });
});

$(document).on('click','#btn-add-vehicle',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var term_code = $('#input-vehicle-termcode').val();
    var plate = $('#input-vehicle-plate').val();
    var code = $('#input-vehicle-code').val();
    var name = $('#input-vehicle-name').val();
    var id = $('#input-vehicle-id').val();
   
    $.ajax({
        url: '../web/vehicles/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'term_code' : term_code,
            'plate' : plate,
            'code' : code,
            'name' : name,
            'id' : id,
        },                         
        type: 'post',
        success: function(response){

            // console.log(response);

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
   
    return false;
});

$(document).on('click','#btn-edit-vehicle',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var plate = $(this).parent().siblings('.plate').text();
    var term_code = $(this).parent().siblings('.term-code').text();
    var code = $(this).parent().siblings('.loc-code').text();
    var name = $(this).parent().siblings('.loc-name').text();

    $('#input-vehicle-id').val(id);
    $('#input-vehicle-termcode').val(term_code);
    $('#input-vehicle-plate').val(plate);
    $('#input-vehicle-code').val(code);
    $('#input-vehicle-name').val(name);
    $('#btn-add-vehicle').attr('data-type', 'edit');
    $('.card-title-vehicle').text('Update Vehicle')

    return false;
});

$(document).on('click','#btn-clear-vehicle',function(e) {
    e.preventDefault();

    $('#input-vehicle-id').val('');
    $('#input-vehicle-termcode')[0].selectedIndex = 0;
    $('#input-vehicle-plate').val('');
    $('#input-vehicle-name').val('');
    $('#input-vehicle-code')[0].selectedIndex = 0;
    $('#btn-add-vehicle').attr('data-type', 'add');
    $('.card-title-vehicle').text('Add New Vehicle');

    return false;
});

$(document).on('click','#btn-del-vehicle',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var type = 'delete';
    var term_code = $('#input-vehicle-termcode').val();
    var plate = $('#input-vehicle-plate').val();
    var code = $('#input-vehicle-code').val();
    var name = $('#input-vehicle-name').val();

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
                url: '../web/vehicles/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'term_code' : term_code,
                    'plate' : plate,
                    'code' : code,
                    'name' : name,
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

$(document).on('change','select[name="input-vehicle-code"]',function(e) {
    e.preventDefault();

    var id = $('#input-vehicle-id').val();
    var type = 'changeloc';
    var term_code = $('#input-vehicle-termcode').val();
    var plate = $('#input-vehicle-plate').val();
    var code = $('#input-vehicle-code').val();
    var name = $('#input-vehicle-name').val();

    $.ajax({
        url: '../web/vehicles/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'term_code' : term_code,
            'plate' : plate,
            'code' : code,
            'name' : name,
            'id' : id,
        },
        type: 'post',
        success: function(response){
            
            var response = JSON.parse(response);

            if (response['type'] == 'success') {
                // console.log(response['pdname']);
                plname = response['plname'];
                $('input[name="input-vehicle-name"]').val(plname);
            
            } else {
                $('input[name="input-vehicle-name"]').val('');
            }
        }
    });
   
    return false;
});

