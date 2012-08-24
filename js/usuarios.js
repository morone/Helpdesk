$(function(){
	var id;
	
	$(".deletar").click(function(){
		id = $(this).attr("id");
		$.prompt('Tem certeza que deseja excluir este usu&aacute;rio? ',{ prefix:'cleanblue', buttons: { Ok: true, Cancel: false }, callback: excluirUser});
	});
	
	function excluirUser(e,v,m,f){
		if(v==true)window.location="usuarios.php?action=deletar&id=" + id;
	}
	
	$(".resetar").click(function(){
		id = $(this).attr("id");
		$.prompt('Tem certeza que deseja resetar a senha deste usu&aacute;rio para "1234"? ',{ prefix:'cleanblue', buttons: { Ok: true, Cancel: false }, callback: resetarSenha});
	});
	
	function resetarSenha(e,v,m,f){
		if(v==true)window.location="usuarios.php?action=resetar&id=" + id;
	}
	
});