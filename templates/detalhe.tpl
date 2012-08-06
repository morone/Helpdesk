{{CABECALHO}}
		<div class="main">
			<h2>Detalhes do Helpdesk <strong>{{NUMERO_HELPDESK}}</strong></h2>	
			<input type="hidden" id="idChamado" value="{{ID_CHAMADO}}" />
			
			{{FINALIZAR}}
			
			
			<div id="respostas">
				{{RESPOSTAS}}
			</div>
			
		</div>
		
		<div class="secondary">
				<fieldset>
					
					<legend>Responda o Helpdesk</legend>
						
					<div>
						<label for="mensagem">Mensagem</label>
						<textarea name="mensagem" id="mensagem" cols="30" rows="10" class="resposta"></textarea>
					</div>
				</fieldset>
				<div class="submit"><button type="submit" id="enviarResposta">Enviar</button></div>						
			
			{{MENSAGEM}}
			<p class="error" id="erro">Erro ao abrir o helpdesk, entre em contato com TI!</p>
		</div>
		
{{RODAPE}}