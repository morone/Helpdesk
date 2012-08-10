$(function(){	

	$("#cadastrarCategoria").click(function(){
		if($("#categoria").val()!=""){
			$.get('actions/actions.php?action=setCategorias&categoria=' + $("#categoria").val(), function(){
				LoadCategorias();
				$("#categoria").val("");
			});
		}
	});
	
	LoadCategorias();
	
	function LoadCategorias(){
		$("#categorias").load('actions/actions.php?action=getCategorias');
	}

});

