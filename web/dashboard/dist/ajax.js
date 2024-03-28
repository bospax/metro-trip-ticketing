$(document).ready(function(){
    loadLogs();
    loadChartTime();
    loadChartKm();
    loadData();
    loadTotalRegistered();
    loadRvpd();
    loadTpd();
    loadDtel();
    loadhkmrun();
    loadltime();
});

function loadDtel() {
    var tabletype = "getdtel";

    $.ajax({
		url: 'web/dashboard/ajax/table_dtel.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            // var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
            $("#wrapper-table-dtel").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadhkmrun() {
    var tabletype = "hkmrun";

    $.ajax({
		url: 'web/dashboard/ajax/hkmrun.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            // var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
            $("#wrapper-table-hkmrun").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadltime() {
    var tabletype = "ltime";

    $.ajax({
		url: 'web/dashboard/ajax/ltime.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            // var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
            $("#wrapper-table-ltime").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadTpd() {
    var tabletype = "gettpd";

    $.ajax({
		url: 'web/dashboard/ajax/table_tpd.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            // var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
            $("#wrapper-table-tpd").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadRvpd() {
    var tabletype = "getrvpd";

    $.ajax({
		url: 'web/dashboard/ajax/table_rvpd.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            // var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
            $("#wrapper-table-rvpd").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadLogs() {
    var tabletype = "getlogs";

    $.ajax({
		url: 'web/dashboard/ajax/table_logs.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            // var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
            $("#wrapper-table-actlogs").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadTotalRegistered() {
    var tabletype = "gettotalregistered";

    $.ajax({
		url: 'web/dashboard/ajax/total_registered.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            var response = JSON.parse(response);
            // $("span#total-sms").text(response['sms']);
            // $("span#total-bounce").text(response['rate'] + '%');
            $("#dash-total-driver").text(response['totaldrivers']);
            $("#dash-total-vehicle").text(response['totalvehicles']);
            $("#dash-total-location").text(response['totallocations']);
            console.log(response);
            // $("#wrapper-table-actlogs").html(response);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadData() {
    var tabletype = "getsms";
    
	$.ajax({
		url: 'web/dashboard/ajax/sms.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {

            var response = JSON.parse(response);
            $("span#total-sms").text(response['sms']);
            $("span#total-bounce").text(response['rate'] + '%');
            // console.log(response[0]);
        },
        error : function() {
            alert("Something went wrong!");
        }
    });
}

function loadChartTime() {
    var tabletype = "gettrip";
    
	$.ajax({
		url: 'web/dashboard/ajax/time.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {
            var response = JSON.parse(response);
            // console.log(response['plate']);
            // console.log(response['time']);

            if (response['plate'] === undefined || response['plate'].length == 0) {
                $('.chart-label-time').text('NO DATA AVAILABLE');
            }

            // start of chart
            let myChart = document.getElementById('chart-time').getContext('2d');

            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 11;
            Chart.defaults.global.defaultFontColor = '#777';

            let massPopChart = new Chart(myChart, {
                type:'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels: response['plate'],
                    datasets:[{
                    label:'Travel Time',
                    data: response['time'],
                    //backgroundColor:'green',
                    backgroundColor:[
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderWidth:1,
                    borderColor:'#777',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                    display:true,
                    text:'Daily Travel Duration',
                    fontSize:16
                    },
                    legend:{
                    display:true,
                    position:'right',
                    labels:{
                        fontColor:'#000'
                    }
                    },
                    layout:{
                    padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                    }
                    },
                    tooltips:{
                    enabled:true
                    }
                }
            });
            // end of chart
        },
        error : function(){
            alert("Something went wrong!");
        }
    });
}

function loadChartKm() {
    var tabletype = "gettrip";
    
	$.ajax({
		url: 'web/dashboard/ajax/km.php',
		type: 'POST',
        data: {type : tabletype},
        
		success: function(response) {
            var response = JSON.parse(response);
            // console.log(response['plate']);
            // console.log(response['km_run']);

            if (response['plate'] === undefined || response['plate'].length == 0) {
                $('.chart-label-km').text('NO DATA AVAILABLE');
            }

            // start of chart
            let chartkm = document.getElementById('chart-km').getContext('2d');

            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 11;
            Chart.defaults.global.defaultFontColor = '#777';

            let massPopChart = new Chart(chartkm, {
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels: response['plate'],
                    datasets:[{
                    label:'Kilometer Run',
                    data: response['km_run'],
                    //backgroundColor:'green',
                    backgroundColor:[
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderWidth:1,
                    borderColor:'#777',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                    display:true,
                    text:'Daily Kilometer Run',
                    fontSize:16
                    },
                    legend:{
                    display:true,
                    position:'right',
                    labels:{
                        fontColor:'#000'
                    }
                    },
                    layout:{
                    padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                    }
                    },
                    tooltips:{
                    enabled:true
                    }
                }
            });
            // end of chart
        },
        error : function(){
            alert("Something went wrong!");
        }
    });
}