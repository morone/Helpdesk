{{CABECALHO}}
		<div class="main">
			<h2>Helpdesk</h2>
			<form method="post" action="?action=entrar">
				<fieldset>
					<label for="login">&nbsp;</label>
					<input type="text" name="login" id="login" size="100" placeholder="Login" class="field required" />
	
					<label for="senha">&nbsp;</label>
					<input type="password" name="senha" id="senha" size="100" placeholder="Senha" class="field required" />
				</fieldset>
				<div class="submit"><button type="submit" id="enviar">Entrar</button></div>
			</form>
			{{MENSAGEM}}
			<a rel="shadowbox;width=400;height=300" href="senha.php">Alterar Senha</a>
		</div>
{{RODAPE}}