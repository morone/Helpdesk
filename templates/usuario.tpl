{{CABECALHO}}
		<div class="main">
			<h2>Cadastro de Usu&aacute;rios</h2>
			
			<form id="contactForm" action="?action=cadastrar" method="post">	
		
				<fieldset>
					
					<legend>Por favor, preencha todos os campos</legend>
					
					<div>
						<label for="nome">Nome</label>
						<input type="text" name="nome" id="nome" size="100" class="field required" />
					</div>
					<div>
						<label for="login">Login</label>
						<input type="text" name="login" id="login" size="100" class="field required" />
					</div>
					<div>
						<label for="ramal">Ramal</label>
						<input type="text" name="ramal" id="ramal" size="100" class="field required" />
					</div>
					<div>
						<label for="email">E-Mail</label>
						<input type="text" name="email" id="email" size="100" class="field required" value="@kty.com.br"/>
					</div>
					<div>
						<label for="grupo">Grupo</label>
						<select name="grupo" id="grupo" class="select">
							<option value="USUARIO">USUARIO</option>
							<option value="TI">TI</option>
							<option value="ADMIN">ADMIN</option>
						</select>
					</div>
				</fieldset>
				<div class="submit"><button type="submit" id="enviar">Cadastrar</button></div>						
			
			{{MENSAGEM}}
			
			</form>			
			
			<br/>
			<br/>
			
			<h2>Usu&aacute;rios</h2>
			<div id="usuarios">
				<table cellpadding="0" cellspacing="0">
					<caption>Helpdesks abertos</caption>
						<thead>
							<tr>
								<th class="center">ID</th>
								<th>Login</th>
								<th>Nome</th>
								<th class="center">Ramal</th>
								<th>Email</th>
								<th class="center">Grupo</th>
								<th>Ferramentas</th>
							</tr>
						</thead>
					<tbody>
					{{USERS}}
					</tbody>
				</table>
			</div>
			
		</div>
		
{{RODAPE}}