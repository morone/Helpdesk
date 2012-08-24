$(function(){	
	$('#categoria').change(function() {	
		$.prompt('Tem certeza que deseja alterar a categoria deste Helpdesk? ',{ prefix:'cleanblue', buttons: { Ok: true, Cancel: false },callback: trocarCat });
	});	
	function trocarCat(e,v,m,f){
		if(v==true)window.location="atender.php?action=alterarCat&categoria=" + $('#categoria').val() + "&id=" + $('#id').val();
	}
});