$(function () {
				
	var ponto = new Array();
	
	$.get('actions/actions.php?action=getPontosGeral', function(data){
		var horas = data.split("#");
		for(var i in horas){
			ponto[i] = horas[i].split("@");
		}

	    $.plot($("#placeholder-porHoraGeral"), [ 
	                               { 
		                               data: ponto,
		                               lines: {show: true, fill: true, },
		                               points: {show: true}
	                               } 

				],
				
			    {xaxis: {ticks:  [[0, "07-08"], [1, "08-09"], [2, "09-10"], [3, "10-11"], 
								   [4, "11-12"], [5, "12-13"], [6, "13-14"], [7, "14-15"], 
								   [8, "15-16"], [9, "16-17"], [10, "17-18"], [11, "18-19"], [12, "19-20"]],}}
	    );
		
    })

});