// $(document).ready(function() {
//     loadData();
// });

$("#btn-import-driver").click(function() {

    var file_data = $('#input-import-driver').prop('files')[0];   
    var form_data = new FormData();      

    form_data.append('file', file_data);

    // console.log(form_data);          

    $.ajax({
        url: '../web/drivers/ajax/import_driver.php', // point to server-side PHP script 
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

$(document).on('click','#btn-add-driver',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var dname = $('#input-driver-name').val();
    var dempid = $('#input-driver-empid').val();
    var dnum = $('#input-driver-number').val();
    var id = $('#input-driver-id').val();
    var lcode = $('#input-driver-lcode').val();
    var lname = $('#input-driver-lname').val();
    var term = $('#input-driver-term').val();
    var deptcode = $('#input-driver-deptcode').val();
    var deptname = $('#input-driver-deptname').val();
   
    $.ajax({
        url: '../web/drivers/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'dname' : dname,
            'dempid' : dempid,
            'dnum' : dnum,
            'id' : id,
            'lcode' : lcode,
            'lname' : lname,
            'term' : term,
            'deptcode' : deptcode,
            'deptname' : deptname
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

$(document).on('click','#btn-edit-driver',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var dname = $(this).parent().siblings('.dname').text();
    var dempid = $(this).parent().siblings('.dempid').text();
    var dnum = $(this).parent().siblings('.dnum').text();
    var lcode = $(this).parent().siblings('.lcode').text();
    var lname = $(this).parent().siblings('.lname').text();
    var term = $(this).parent().siblings('.term').text();
    var deptcode = $(this).parent().siblings('.deptcode').text();
    var deptname = $(this).parent().siblings('.deptname').text();

    $('#input-driver-id').val(id);
    $('#input-driver-name').val(dname);
    $('#input-driver-empid').val(dempid);
    $('#input-driver-number').val(dnum);
    $('#input-driver-lcode').val(lcode);
    $('#input-driver-lname').val(lname);
    $('#input-driver-term').val(term);
    $('#input-driver-deptcode').val(deptcode);
    $('#input-driver-deptname').val(deptname);
    $('#btn-add-driver').attr('data-type', 'edit');
    $('.card-title-driver').text('Update Driver')

    return false;
});

$(document).on('click','#btn-clear-driver',function(e) {
    e.preventDefault();

    $('#input-driver-id').val('');
    $('#input-driver-name').val('');
    $('#input-driver-empid').val('');
    $('#input-driver-number').val('');
    $('#input-driver-lcode').val('');
    $('#input-driver-lname').val('');
    $('#input-driver-term')[0].selectedIndex = 0;
    $('#input-driver-deptcode').val('');
    $('#input-driver-deptname').val('');
    $('#btn-add-driver').attr('data-type', 'add');
    $('.card-title-driver').text('Add New Driver')

    return false;
});

$(document).on('click','#btn-del-driver',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var type = 'delete';
    var dname = $('#input-driver-name').val();
    var dempid = $('#input-driver-empid').val();
    var dnum = $('#input-driver-number').val();
    var lcode = $('#input-driver-lcode').val();
    var lname = $('#input-driver-lname').val();
    var term = $('#input-driver-term').val();
    var deptcode = $('#input-driver-deptcode').val();
    var deptname = $('#input-driver-deptname').val();

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
                url: '../web/drivers/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'dname' : dname,
                    'dempid' : dempid,
                    'dnum' : dnum,
                    'id' : id,
                    'lcode' : lcode,
                    'lname' : lname,
                    'term' : term,
                    'deptcode' : deptcode,
                    'deptname' : deptname
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

                        // console.log(response);
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

function loadData() {
    var type = 'read';

    $.ajax({
        url: '../web/drivers/ajax/table_drivers.php', // point to server-side PHP script 
        data: {
            'type' : type
        },                         
        type: 'post',
        success: function( response, textStatus, jQxhr ) {
            $('#table-drivers').html(response);
            // console.log(response);
        },
        error: function( jqXhr, textStatus, errorThrown ) {
            console.log( errorThrown );
        }
    });
}

$(document).on('change','select[name="input-driver-term"]',function(e) {
    e.preventDefault();

    var id = $('#input-vehicle-id').val();
    var type = 'changeloc';
    var dname = $('#input-driver-name').val();
    var dempid = $('#input-driver-empid').val();
    var dnum = $('#input-driver-number').val();
    var id = $('#input-driver-id').val();
    var lcode = $('#input-driver-lcode').val();
    var lname = $('#input-driver-lname').val();
    var term = $('#input-driver-term').val();
    var deptcode = $('#input-driver-deptcode').val();
    var deptname = $('#input-driver-deptname').val();

    $.ajax({
        url: '../web/drivers/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'dname' : dname,
            'dempid' : dempid,
            'dnum' : dnum,
            'id' : id,
            'lcode' : lcode,
            'lname' : lname,
            'term' : term,
            'deptcode' : deptcode,
            'deptname' : deptname
        },
        type: 'post',
        success: function(response){
            
            var response = JSON.parse(response);

            // console.log(response);

            if (response['type'] == 'success') {
                // console.log(response['pdname']);
                tname = response['tname'];
                $('input[name="input-driver-deptname"]').val(tname);
            
            } else {
                $('input[name="input-driver-deptname"]').val('');
            }
        }
    });
   
    return false;
});
