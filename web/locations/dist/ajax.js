function swalLoader() {
    Swal.fire({
        text: 'Please Wait ...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
    })
    Swal.showLoading();
}

$("#btn-import-loc").click(function() {

    var file_data = $('#input-import-loc').prop('files')[0];
    var import_type = $('select[name="importtype"]').val();

    var form_data = new FormData();

    form_data.append('file', file_data);
    form_data.append('importtype', import_type);

    // alert(form_data);    
    
    swalLoader();

    $.ajax({
        url: '../web/locations/ajax/import_loc.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
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
                Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                })
            }
        }
     });
});

$(document).on('click','#btn-add-loc',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var term_code = $('#input-loc-termcode').val();
    var code = $('#input-loc-code').val();
    var name = $('#input-loc-name').val();
    var id = $('#input-loc-id').val();
   
    $.ajax({
        url: '../web/locations/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'term_code' : term_code,
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
            // console.log(response);
        }
     });
   
    return false;
});

$(document).on('click','#btn-edit-loc',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var term_code = $(this).parent().siblings('.tcode').text();
    var code = $(this).parent().siblings('.lcode').text();
    var name = $(this).parent().siblings('.lname').text();

    $('#input-loc-id').val(id);
    $('#input-loc-termcode').val(term_code);
    $('#input-loc-code').val(code);
    $('#input-loc-name').val(name);
    $('#btn-add-loc').attr('data-type', 'edit');
    $('.card-title-loc').text('Update Tag')

    return false;
});

$(document).on('click','#btn-clear-loc',function(e) {
    e.preventDefault();

    $('#input-loc-id').val('');
    $('#input-loc-code')[0].selectedIndex = 0;
    $('#input-loc-termcode')[0].selectedIndex = 0;
    $('#input-loc-name').val('');
    $('#btn-add-loc').attr('data-type', 'add');
    $('.card-title-loc').text('Tag New Location')

    return false;
});

$(document).on('click','#btn-del-loc',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var type = 'delete';
    var term_code = $('#input-loc-termcode').val();
    var code = $('#input-loc-code').val();
    var name = $('#input-loc-name').val();

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
                url: '../web/locations/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'term_code' : term_code,
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

$(document).on('click','#btn-add-masterloc',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var mastercode = $('#input-masterloc-code').val();
    var mastername = $('#input-masterloc-name').val();
    var id = $('#input-masterloc-id').val();

    $.ajax({
        url: '../web/locations/ajax/router_masterloc.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'mastercode' : mastercode,
            'mastername' : mastername,
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

$(document).on('click','#btn-edit-masterloc',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var mastercode = $(this).parent().siblings('.mastercode').text();
    var mastername = $(this).parent().siblings('.mastername').text();

    $('#input-masterloc-id').val(id);
    $('#input-masterloc-code').val(mastercode);
    $('#input-masterloc-name').val(mastername);
    $('#btn-add-masterloc').attr('data-type', 'edit');
    $('.card-title-masterloc').text('Update Location');

    // alert('edited');

    return false;
});

$(document).on('click','#btn-clear-masterloc',function(e) {
    e.preventDefault();

    $('#input-masterloc-id').val('');
    $('#input-masterloc-code').val('');
    $('#input-masterloc-name').val('');
    $('#btn-add-masterloc').attr('data-type', 'add');
    $('.card-title-masterloc').text('Add New Location');

    return false;
});

$(document).on('click','#btn-del-masterloc',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var type = 'delete';
    var mastercode = $('#input-masterloc-code').val();
    var mastername = $('#input-masterloc-name').val();

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
                url: '../web/locations/ajax/router_masterloc.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'mastercode' : mastercode,
                    'mastername' : mastername,
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

$(document).on('change','#input-loc-code',function(e) {
    e.preventDefault();

    var type = 'changeloc';
    var term_code = $('#input-loc-termcode').val();
    var code = $('#input-loc-code').val();
    var name = $('#input-loc-name').val();
    var id = $('#input-loc-id').val();

    $.ajax({
        url: '../web/locations/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'term_code' : term_code,
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
                $('#input-loc-name').val(plname);
            
            } else {
                $('#input-loc-name').val('');
            }

            // console.log(response);
        }
    });

    // alert('changed');
   
    return false;
});