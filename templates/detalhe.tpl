{{CABECALHO}}
		<div class="main">
			<h2>Detalhes do Helpdesk - <strong>{{NUMERO_HELPDESK}}</strong></h2>	
			<input type="hidden" id="idChamado" value="{{ID_CHAMADO}}" />
			
			{{FINALIZAR}}
			
			<div id="respostas">
				{{RESPOSTAS}}
			</div>
			
		</div>
		
		<div class="secondary">
									
			{{CAIXA_RESPOSTA}}
			{{MENSAGEM}}
			<p class="error" id="erro">Erro ao abrir o helpdesk, entre em contato com TI!</p>
		</div>
		
{{RODAPE}}