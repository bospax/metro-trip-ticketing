$(document).ready(function() {
    loadTripToday();
    loadSmsToday();
});

function loadTripToday() {
    var action = 'read';

    $.ajax({
        url: '../web/trips/ajax/trips_table.php', // point to server-side PHP script 
        data: {
            'action' : action
        },                         
        type: 'post',

        beforeSend: function( xhr ) {
            // $('.cust-loader-document').show();
            var loader = '<img src="../template/assets/images/loader_custom.png" class="cust-loader-document" class="light-logo" width="40" height="40"/>';
            $("#wrapper-table-trips").html(loader);
        },

        success: function(response){
            $("#wrapper-table-trips").html(response);
        }
     });
}

function loadSmsToday() {
    var action = 'read';

    $.ajax({
        url: '../web/trips/ajax/sms_table.php', // point to server-side PHP script 
        data: {
            'action' : action
        },                         
        type: 'post',

        beforeSend: function( xhr ) {
            // $('.cust-loader-document').show();
            var loader = '<img src="../template/assets/images/loader_custom.png" class="cust-loader-document" class="light-logo" width="40" height="40"/>';
            $("#wrapper-table-sms").html(loader);
        },

        success: function(response){
            $("#wrapper-table-sms").html(response);
        }
    });
}

$(document).on('click','#btn-trip-remark',function(e) {
    var id = $(this).data('id');
    var type = 'getremark';

    $('#input-trip-id').val(id);

    $.ajax({
        url: '../web/trips/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'id' : id,
        },                         
        type: 'post',
        success: function(response){
            var response = JSON.parse(response);
            $('#input-trip-remark').val(response[0]);
            // console.log(response);
        }
     });
});

$(document).on('click','#btn-modal-remark',function(e) {
    e.preventDefault();

    var id = $('#input-trip-id').val();
    var remark = $('#input-trip-remark').val();
    var type = 'updateremark';
   
    $.ajax({
        url: '../web/trips/ajax/router.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'id' : id,
            'remark' : remark
        },                         
        type: 'post',
        success: function(response){
            // console.log(response);
            window.location.reload();
        }
     });

    return false;
});

$(document).on('change','#filtertrip',function(e) {
    var action = 'filter_trip';
    var filter = $(this).val();

    $.ajax({
        url: '../web/trips/ajax/trips_table.php', // point to server-side PHP script 
        data: {
            'action' : action,
            'filter': filter
        },                         
        type: 'post',

        beforeSend: function( xhr ) {
            // $('.cust-loader-document').show();
            var loader = '<img src="../template/assets/images/loader_custom.png" class="cust-loader-document" class="light-logo" width="40" height="40"/>';
            $("#wrapper-table-trips").html(loader);
        },

        success: function(response){
            $("#wrapper-table-trips").html(response);
        }
     });
});

$(document).on('change','#filtersms',function(e) {
    var action = 'filter_sms';
    var filter = $(this).val();

    $.ajax({
        url: '../web/trips/ajax/sms_table.php', // point to server-side PHP script 
        data: {
            'action' : action,
            'filter': filter
        },                         
        type: 'post',

        beforeSend: function( xhr ) {
            // $('.cust-loader-document').show();
            var loader = '<img src="../template/assets/images/loader_custom.png" class="cust-loader-document" class="light-logo" width="40" height="40"/>';
            $("#wrapper-table-sms").html(loader);
        },

        success: function(response){
            $("#wrapper-table-sms").html(response);
        }
     });
});




  
  





