$(document).ready(function(){
    setInterval(() => {
        loadData();
    }, 1000);
});

function loadData() {
    var tabletype = "table_fleet";
    
	$.ajax({
		url: '../web/fleet/routes/router.php',
		type: 'POST',
        data: {type : tabletype},
        
		success:function(response){
            $("#wrapper-table-fleet").html(response);
            // console.log(response);
        },
        error : function(){
            alert("Something went wrong!");
        }
	});
}
  
  







