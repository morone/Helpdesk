$(function(){	

	$("#enviarResposta").click(function(){
		$.get('actions/actions.php?action=setResposta&idChamado=' + $("#idChamado").val() + '&mensagem=' + $("#mensagem").val(), function(){
			LoadRespostas();
			$("#mensagem").val("");
		});
	});
	
	LoadRespostas();
	
	function LoadRespostas(){
		$("#respostas").load('actions/actions.php?action=getRespostas&idChamado=' + $("#idChamado").val());
	}

});