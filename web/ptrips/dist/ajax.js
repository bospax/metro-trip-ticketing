function clearFields() {
    $('#btn-add-ptrips').attr('data-type', 'add');
    $('.card-title-ptrips').text('Add New Trip');
    $('input[name="input-ptrips-id"]').val('');
    $('input[name="datepicker_ptrips"]').val('');
    $('input[name="timepicker_trips"]').val('');
    $('select[name="ptripsdid"]')[0].selectedIndex = 0;
    $('input[name="input-ptrips-dname"]').val('');
    $('select[name="ptripsvehic"]')[0].selectedIndex = 0;
    $('select[name="ptripsorig"]')[0].selectedIndex = 0;
    $('select[name="ptripsdest"]')[0].selectedIndex = 0;
    $('textarea[name="input-ptrips-compa"]').val('');
}

function loadData() {
    var type = 'read';

    $.ajax({
        url: '../web/ptrips/ajax/table_ptrip.php', // point to server-side PHP script 
        data: {
            'type' : type
        },                     
        type: 'post',
        success: function( response, textStatus, jQxhr ) {
            $('#table-ptrips-wrapper').html(response);
            // console.log(response);
        },
        error: function( jqXhr, textStatus, errorThrown ) {
            console.log(errorThrown);
        }
    });
}

$(document).ready(function() {
    loadData();
});

$(document).on('click','#btn-add-ptrips',function(e) {
    e.preventDefault();

    var type        = $(this).data('type');
    var id          = $('input[name="input-ptrips-id"]').val();
    var term_code   = $('input[name="input-ptrips-termcode"]').val();
    var dateptrips  = $('input[name="datepicker_ptrips"]').val();
    var ptriptime   = $('input[name="timepicker_trips"]').val();
    var ptripsdid   = $('select[name="ptripsdid"]').val();
    var ptripdname  = $('input[name="input-ptrips-dname"]').val();
    var ptripsvehic = $('select[name="ptripsvehic"]').val();
    var ptripsorig  = $('select[name="ptripsorig"]').val();
    var ptripsdest  = $('select[name="ptripsdest"]').val();
    var ptripcompa  = $('textarea[name="input-ptrips-compa"]').val();
   
    $.ajax({
        url: '../web/ptrips/ajax/router.php', // point to server-side PHP script 
        data: {
            'type'        : type,
            'id'          : id,
            'term_code'   : term_code,
            'dateptrips'  : dateptrips,
            'ptriptime'   : ptriptime,
            'ptripsdid'   : ptripsdid,
            'ptripdname'  : ptripdname,
            'ptripsvehic' : ptripsvehic,
            'ptripsorig'  : ptripsorig,
            'ptripsdest'  : ptripsdest,
            'ptripcompa'  : ptripcompa
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
   
    return false;
});

$(document).on('change','select[name="ptripsdid"]',function(e) {
    e.preventDefault();

    var id          = $('input[name="input-ptrips-id"]').val();
    var term_code   = $('input[name="input-ptrips-termcode"]').val();
    var ptripsdid   = $('select[name="ptripsdid"]').val();
    var dateptrips  = $('input[name="datepicker_ptrips"]').val();
    var ptriptime   = $('input[name="timepicker_trips"]').val();
    var ptripdname  = $('input[name="input-ptrips-dname"]').val();
    var ptripsvehic = $('select[name="ptripsvehic"]').val();
    var ptripsorig  = $('select[name="ptripsorig"]').val();
    var ptripsdest  = $('select[name="ptripsdest"]').val();
    var ptripcompa  = $('textarea[name="input-ptrips-compa"]').val();
    var type        = 'changedid';

    $.ajax({
        url: '../web/ptrips/ajax/router.php', // point to server-side PHP script 
        data: {
            'type'        : type,
            'id'          : id,
            'term_code'   : term_code,
            'dateptrips'  : dateptrips,
            'ptriptime'   : ptriptime,
            'ptripsdid'   : ptripsdid,
            'ptripdname'  : ptripdname,
            'ptripsvehic' : ptripsvehic,
            'ptripsorig'  : ptripsorig,
            'ptripsdest'  : ptripsdest,
            'ptripcompa'  : ptripcompa
        },
        type: 'post',
        success: function(response) {

            var response = JSON.parse(response);

            if (response['type'] == 'success') {
                // console.log(response['pdname']);
                pdname = response['pdname'];
                $('input[name="input-ptrips-dname"]').val(pdname);
            
            } else {
                $('input[name="input-ptrips-dname"]').val('');
            }
        }
     });
   
    return false;
});

$(document).on('click','#btn-clear-ptrips',function(e) {
    e.preventDefault();

    clearFields();
   
    return false;
});

$(document).on('click','#btn-edit-ptrip',function(e) {
    e.preventDefault();

    var id          = $(this).data('id');
    var dateptrips  = $(this).parent().siblings('.dateptrips').text();
    var ptriptime   = $(this).parent().siblings('.ptriptime').text();
    var ptripsdid   = $(this).parent().siblings('.ptripsdid').text();
    var ptripdname  = $(this).parent().siblings('.ptripdname').text();
    var ptripsvehic = $(this).parent().siblings('.ptripsvehic').text();
    var ptripsorig  = $(this).parent().siblings('.ptripsorig').text();
    var ptripsdest  = $(this).parent().siblings('.ptripsdest').text();
    var ptripcompa  = $(this).parent().siblings('.ptripcompa').text();

    $('input[name="input-ptrips-id"]').val(id);
    $('input[name="datepicker_ptrips"]').val(dateptrips);
    $('input[name="timepicker_trips"]').val(ptriptime);
    $('select[name="ptripsdid"]').val(ptripsdid);
    $('input[name="input-ptrips-dname"]').val(ptripdname);
    $('select[name="ptripsvehic"]').val(ptripsvehic);
    $('select[name="ptripsorig"]').val(ptripsorig);
    $('select[name="ptripsdest"]').val(ptripsdest);
    $('textarea[name="input-ptrips-compa"]').val(ptripcompa);
    $('#btn-add-ptrips').attr('data-type', 'edit');
    $('.card-title-ptrips').text('Update Trip');
   
    // console.log(id);

    return false;
});

$(document).on('click','#btn-del-ptrip',function(e) {
    e.preventDefault();

    var type        = 'delete';
    var id          = $(this).data('id');
    var term_code   = $('input[name="input-ptrips-termcode"]').val();
    var dateptrips  = $('input[name="datepicker_ptrips"]').val();
    var ptriptime   = $('input[name="timepicker_trips"]').val();
    var ptripsdid   = $('select[name="ptripsdid"]').val();
    var ptripdname  = $('input[name="input-ptrips-dname"]').val();
    var ptripsvehic = $('select[name="ptripsvehic"]').val();
    var ptripsorig  = $('select[name="ptripsorig"]').val();
    var ptripsdest  = $('select[name="ptripsdest"]').val();
    var ptripcompa  = $('textarea[name="input-ptrips-compa"]').val();

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
                url: '../web/ptrips/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type'        : type,
                    'id'          : id,
                    'term_code'   : term_code,
                    'dateptrips'  : dateptrips,
                    'ptriptime'   : ptriptime,
                    'ptripsdid'   : ptripsdid,
                    'ptripdname'  : ptripdname,
                    'ptripsvehic' : ptripsvehic,
                    'ptripsorig'  : ptripsorig,
                    'ptripsdest'  : ptripsdest,
                    'ptripcompa'  : ptripcompa
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

$(document).on('click','#generate',function(e) {
    e.preventDefault();

    var type = 'generate';
    var prange = $('input[name="daterange_ptrip"]').val();
    var termcode = $('select[name="genptriptermcode"]').val();
   
    $.ajax({
        url: '../web/ptrips/generate.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'prange' : prange,
            'termcode' : termcode
        },
        type: 'post',
        success: function(response) {

            // var response = JSON.parse(response);
            // console.log(response);
            $('#gen-ptrips-container').html(response);
        }
     });

    // alert(termcode);

    return false;
});

$("#btn-import-ptrips").click(function() {

    var file_data = $('#input-import-ptrips').prop('files')[0];   
    var form_data = new FormData();      

    form_data.append('file', file_data);

    // console.log(form_data);          

    $.ajax({
        url: '../web/ptrips/ajax/import_ptrips.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(response) {

            var response = JSON.parse(response);

            if (response['type'] == 'success') {

                Swal.fire({
                    icon: 'success',
                    text: response['msg'],
                }).then(function(){
                    window.location.reload();
                });

            } else if (response['type'] == 'invalid') {

                Swal.fire({
                    title: response['msg'],
                    icon: 'info',
                    html: '<div style="color: #e84343">'+response['err']+'</div>'
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