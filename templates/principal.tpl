{{CABECALHO}}
		<div class="main">
			<h2>Abertura de Helpdesk</h2>

			<form id="contactForm" action="?action=abrir" method="post">	
		
				<fieldset>
					
					<legend>Por favor, preencha todos os campos</legend>
					<div>
					<label for="categoria">Categoria</label>
						<select name="categoria" id="categoria" class="select">
							{{CATEGORIA}}
						</select>
					</div>
					<div>
						<label for="os">Contrato</label>
						<select name="os" id="os" class="select">
							<option>(vazio)</option>
							<option value="5048">5048 - COMPERJ</option>
							<option value="5000">5000 - RNEST</option>
						</select>
					</div>	
					<div>
						<label for="titulo">T&iacute;tulo *</label> 
						<input type="text" name="titulo" id="titulo" size="100" class="field required" />
					</div>	
					<div>
						<label for="mensagem">Mensagem</label>
						<textarea name="mensagem" id="mensagem" cols="30" rows="10" class="area"></textarea>
					</div>
				</fieldset>
				<div class="submit"><button type="submit" id="enviar">Enviar</button></div>						
			
			{{MENSAGEM}}
			
			</form>			
		</div>
		<div class="secondary">
			<h2>Helpdesks Abertos</h2>
			{{HELPDESK_ABERTO}}
		</div>
		
{{RODAPE}}