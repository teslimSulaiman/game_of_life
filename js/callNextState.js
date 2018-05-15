
$(document).ready(function(){
	for(var i =0; i< 99 ; i++ ){
	
 		callScriptToGetNextState();
	}

});
function callScriptToGetNextState(){

	var iterationNumber = $('#iterationNumber').text();
	 $.ajax({url: "nextState.php", success: function(result){
        $("#board").html(result);
       
    }});  
}

	      
