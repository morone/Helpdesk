$(function(){	

	$("#enviarResposta").click(function(){
		if($("#mensagem").val()!=""){
			$.get('actions/actions.php?action=setResposta&idChamado=' + $("#idChamado").val() + '&mensagem=' + nl2br($("#mensagem").val()), function(){
				LoadRespostas();
				$("#mensagem").val("");
			});
		}
	});
	
	LoadRespostas();
	
	function LoadRespostas(){
		$("#respostas").load('actions/actions.php?action=getRespostas&idChamado=' + $("#idChamado").val());
	}
	
	
	function nl2br (str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}
});

