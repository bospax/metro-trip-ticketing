function clearFields() {
    $('#btn-add-consump').attr('data-type', 'add');
    $('.card-title-consump').text('Add New Consumption');
    $('input[name="input-consump-id"]').val('');
    $('input[name="datepicker_consump"]').val('');
    $('input[name="input-consump-qty"]').val('');
    $('input[name="input-consump-cost"]').val('');
    $('select[name="consumpvehic"]')[0].selectedIndex = 0;
}

$(document).on('click','#btn-clear-consump',function(e) {
    e.preventDefault();

    clearFields();
   
    return false;
});

$(document).on('click','#btn-add-consump',function(e) {
    e.preventDefault();

    var type = $(this).data('type');
    var id = $('input[name="input-consump-id"]').val();
    var term = $('input[name="input-consump-term"]').val();
    var datef  = $('input[name="datepicker_consump"]').val();
    var plate  = $('select[name="consumpvehic"]').val();
    var qty = $('input[name="input-consump-qty"]').val();
    var cost = $('input[name="input-consump-cost"]').val();

    $.ajax({
        url: '../web/consump/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'datef' : datef,
            'plate' : plate,
            'qty' : qty,
            'cost' : cost,
            'id' : id,
            'term' : term
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

    // console.log(term);
   
    return false;
});

$(document).on('click','#btn-edit-consump',function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var datef  = $(this).parent().siblings('.datef').text();
    var plate  = $(this).parent().siblings('.plate').text();
    var qty  = $(this).parent().siblings('.cqty').text();
    var cost  = $(this).parent().siblings('.cost').text();

    $('input[name="input-consump-id"]').val(id);
    $('input[name="datepicker_consump"]').val(datef);
    $('select[name="consumpvehic"]').val(plate);
    $('input[name="input-consump-qty"]').val(qty);
    $('input[name="input-consump-cost"]').val(cost);

    $('#btn-add-consump').attr('data-type', 'edit');
    $('.card-title-consump').text('Update Consumption');

    return false;
});

$(document).on('click','#btn-del-consump',function(e) {
    e.preventDefault();

    var type = 'delete';
    var id = $(this).data('id');
    var datef  = $('input[name="datepicker_consump"]').val();
    var plate  = $('select[name="consumpvehic"]').val();
    var qty = $('input[name="input-consump-qty"]').val();
    var cost = $('input[name="input-consump-cost"]').val();
    var term = $('input[name="input-consump-term"]').val();

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
                url: '../web/consump/ajax/router.php', // point to server-side PHP script 
                data: {
                    'type' : type,
                    'datef' : datef,
                    'plate' : plate,
                    'qty' : qty,
                    'cost' : cost,
                    'id' : id,
                    'term' : term
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
    var crange = $('input[name="daterange_consump"]').val();
    var cplate = $('select[name="genconsumpvehic"]').val();
   
    $.ajax({
        url: '../web/consump/generate.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'crange' : crange,
            'cplate' : cplate
        },
        type: 'post',
        success: function(response) {

            // var response = JSON.parse(response);
            // console.log(response);
            $('#gen-consump-container').html(response);
        }
    });
   
    return false;
});

$(document).on('click','#btn-import-consump',function(e) {
    var file_data = $('#input-import-consump').prop('files')[0];   
    var form_data = new FormData();      

    form_data.append('file', file_data);

    console.log(form_data);          

    $.ajax({
        url: '../web/consump/ajax/import_consump.php', // point to server-side PHP script 
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

$('input[name="input-consump-cost"]').keyup(function(event) {

    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;
  
    // format number
    $(this).val(function(index, value) {
      return value
      .replace(/\D/g, "")
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      ;
    });
});