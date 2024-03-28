// $(document).ready(function(){
//     setInterval(() => {
//         loadData();
//     }, 1000);
// });

// function loadData() {
//     var tabletype = "table_trip";
    
// 	$.ajax({
// 		url: '../web/trips/routes/router.php',
// 		type: 'POST',
//         data: {type : tabletype},
        
// 		success:function(response){
//             $("#wrapper-table-trips").html(response);
//             // console.log(response);
//         },
//         error : function(){
//             alert("Something went wrong!");
//         }
// 	});
// }

// $(".btn-show-manhour").click(function() {
//     var driver_id = $(this).data('id');
//     var driver_table = $('#mytabledriver-' + driver_id);

//     driver_table.toggle('fast');

// });

$(document).on('click','#generate-er',function(e) {
    e.preventDefault();

    var type = 'generate';
    var daterange_er = $('input[name="daterange_er"]').val();
    var termcode = $('select[name="genertermcode"]').val();

    $.ajax({
        url: '../web/reports/reports_er.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'daterange_er' : daterange_er,
            'termcode' : termcode
        },                         
        type: 'post',

        beforeSend: function( xhr ) {
            // $('.cust-loader-document').show();
            var loader = '<img src="../template/assets/images/loader_custom.png" class="cust-loader-document" class="light-logo" width="40" height="40"/>';
            $("#wrapper-table-bounce").html(loader);
        },

        success: function(response){

            // var response = JSON.parse(response);
            
            $('#wrapper-table-bounce').html(response);
            // console.log(daterange);
            // console.log(response);
        }
     });

    // alert(termcode);

    return false;
});

$(document).on('click','#generate-mp',function(e) {
    e.preventDefault();

    var type = 'generate';
    var daterange = $('input[name="daterange_mp"]').val();
    var termcode = $('select[name="genmptermcode"]').val();

   
    $.ajax({
        url: '../web/reports/reports_mp.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'daterange' : daterange,
            'termcode' : termcode
        },                         
        type: 'post',
        success: function(response){

            // var response = JSON.parse(response);
            
            $('#manhour-container').html(response);
            // console.log(daterange);
            // console.log(response);
        }
     });

    return false;
});

$(document).on('click','#export',function(e) {
    e.preventDefault();

    var type = 'export';
    var daterange = $('input[name="daterange_trip"]').val();

    $.ajax({
        url: '../web/reports/export_trip.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'daterange' : daterange,
        },                         
        type: 'post',
        success: function(response){

            // var response = JSON.parse(response);

            // console.log(daterange);
            // console.log(response);
            window.open('../web/reports/export_trip.php?daterange='+daterange, '_blank');
        }
    });
   
    return false;
});

$(document).on('click','#export-mp',function(e) {
    e.preventDefault();

    var type = 'export_mp';
    var daterange_mp = $('input[name="daterange_mp"]').val();
    var termcode = $('select[name="genmptermcode"]').val();

    $.ajax({
        url: '../web/reports/export_mp.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'daterange_mp' : daterange_mp,
            'termcode' : termcode
        },                         
        type: 'post',
        success: function(response) {

            // var response = JSON.parse(response);

            // console.log(daterange);
            // console.log(response);
            window.open('../web/reports/export_mp.php?daterange_mp='+daterange_mp+'&termcode='+termcode, '_blank');
        }
    });
   
    return false;
});

$(document).on('click','#export-er',function(e) {
    e.preventDefault();

    var type = 'export';
    var daterange_er = $('input[name="daterange_er"]').val();

    $.ajax({
        url: '../web/reports/export_er.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'daterange_er' : daterange_er,
        },                         
        type: 'post',
        success: function(response){

            // var response = JSON.parse(response);

            // console.log(daterange);
            // console.log(response);
            window.open('../web/reports/export_er.php?daterange_er='+daterange_er, '_blank');
        }
    });
   
    return false;
});

$(document).on('click','#export-idl',function(e) {
    e.preventDefault();

    var type = 'export';
    var daterange_idl = $('input[name="daterange_idl"]').val();
    var termcode = $('select[name="genidltermcode"]').val();

    $.ajax({
        url: '../web/reports/export_idl.php', // point to server-side PHP script 
        data: {
            'type' : type,
            'daterange_idl' : daterange_idl,
            'termcode' : termcode
        },                         
        type: 'post',
        success: function(response){

            // var response = JSON.parse(response);

            // console.log(daterange);
            // console.log(response);
            window.open('../web/reports/export_idl.php?daterange_idl='+daterange_idl+'&termcode='+termcode, '_blank');
        }
    });
   
    return false;
});

$(document).on('click','#generate',function(e) {
    e.preventDefault();
    
    var daterange_trip = $('input[name="daterange_trip"]').val();
    var termcode = $('select[name="gentriptermcode"]').val();

    $.ajax({
        url: '../web/reports/reports_trip.php', // point to server-side PHP script 
        data: {
            'daterange_trip' : daterange_trip,
            'termcode' : termcode
        },                         
        type: 'post',

        beforeSend: function( xhr ) {
            // $('.cust-loader-document').show();
            var loader = '<img src="../template/assets/images/loader_custom.png" class="cust-loader-document" class="light-logo" width="40" height="40"/>';
            $("#wrapper-table-trips").html(loader);
        },

        success: function(response) {

            // var response = JSON.parse(response);
            
            $('#wrapper-table-trips').html(response);
            // console.log(daterange);
            // console.log(response);
        }
     });

    // alert(termcode);

    return false;
});

$(document).on('click','#generate-idl',function(e) {
    e.preventDefault();
    
    var daterange_idl = $('input[name="daterange_idl"]').val();
    var termcode = $('select[name="genidltermcode"]').val();

    $.ajax({
        url: '../web/reports/reports_idl.php', // point to server-side PHP script 
        data: {
            'daterange_idl' : daterange_idl,
            'termcode' : termcode
        },                         
        type: 'post',
        success: function(response) {

            // var response = JSON.parse(response);
            
            $('#idle-container').html(response);
            // console.log(daterange);
            // console.log(response);
        }
     });

    // alert(termcode);

    return false;
});

$(document).on('click','#generate-att',function(e) {
    e.preventDefault();
    
    var daterange_att = $('input[name="daterange_att"]').val();
    var empid = $('select[name="empname"]').val();

    // console.log(daterange_att);
    // console.log(empname);

    $.ajax({
        url: '../web/reports/reports_att.php', // point to server-side PHP script 
        data: {
            'daterange_att' : daterange_att,
            'empid' : empid
        },                         
        type: 'post',
        success: function(response) {

            // var response = JSON.parse(response);
            
            $('#wrapper-table-att').html(response);
            // console.log(response);
        }
    });

    return false;
});
  
  





