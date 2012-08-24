<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
	<head>
		<link rel="stylesheet" href="css/easy.css" media="screen" />
		<link rel="stylesheet" href="css/easyprint.css" media="print" />
		<link rel="stylesheet" href="css/styles.css" media="screen" />
		<link rel="stylesheet" href="css/senha.css" media="screen" />
	</head>
	<body>
		<form method="post" action="?action=alterar">
			<fieldset>
				<label for="login">&nbsp;</label>
				<input type="text" name="login" id="login" size="100" placeholder="Login" class="field required" />

				<label for="senhaAtual">&nbsp;</label>
				<input type="password" name="senhaAtual" id="senhaAtual" size="100" placeholder="Senha Atual" class="field required" />
				
				<label for="senhaNova1">&nbsp;</label>
				<input type="password" name="senhaNova1" id="senhaNova1" size="100" placeholder="Nova Senha" class="field required" />
				
				<label for="senhaNova2">&nbsp;</label>
				<input type="password" name="senhaNova2" id="senhaNova2" size="100" placeholder="Repita Nova Senha" class="field required" />
				
			</fieldset>
			<div class="submit"><button type="submit" id="enviar">Alterar Senha</button></div>
			{{MENSAGEM}}
		</form>
	</body>
</html>