{{CABECALHO}}
		<div class="main">
			<h2>Consulta</h2>
			<br/>
			
			<form id="searchForm" action="?action=buscar" method="post">	
				<div id="filtros">	
				
					<input type="text" id="numeroChamado" name="numeroChamado"  placeholder="Num" value="{{NUMERO_CHAMADO}}" class="field"/>

					<input type="text" id="usuario" name="usuario" placeholder="Usu&aacute;rio" value="{{USUARIO_FILTRO}}" class="field"/>
					
					<select name="categoria" id="categoria" name="categoria" class="select">
						{{CATEGORIA}}
					</select>
					
					<select name="os" id="os" name="os" class="select">
						{{OS_SELECT}}
					</select>
					<select name="status" id="status" class="select">
						{{STATUS}}
					</select>

					<input type="text" id="texto" name="texto"  value="{{TEXTO}}" palceholder="Texto" class="field"/>

				</div>
				
				<div id="filtros">
					<input type="text" id="dataAberturaDe" name="dataAberturaDe" value="{{DATA_ABERTURA_DE}}" placeholder="Abertura de" class="field data"/>
					
					<input type="text" id="dataAberturaAte" name="dataAberturaAte" value="{{DATA_ABERTURA_ATE}}" placeholder="Abertura at&eacute;" class="field data"/>
					
					<input type="text" id="dataFechamentoDe" name="dataFechamentoDe" value="{{DATA_FECHAMENTO_DE}}" placeholder="Finalizado de" class="field data"/>
					
					<input type="text" id="dataFechamentoAte" name="dataFechamentoAte" value="{{DATA_FECHAMENTO_ATE}}" placeholder="Finalizado at&eacute;" class="field data"/>
					
					<button type="submit" id="buscar">Buscar</button>
					
					<div style="width:20px; float:right; margin-right:20px;">
					{{LIMPAR_FILTRO}}
					</div>
				</div>
			</form>
			
			
			<br/>
			<div id="helpdesk">
				<table cellpadding="0" cellspacing="0" id="consulta"><caption>Helpdesks</caption><thead><tr><th>Num</th><th class="data">Aberto</th><th class="data">Finalizado</th>
				<th>Total</th><th class="nome">Usu&aacute;rio</th><th>Categoria</th><th>OS</th><th>T&iacute;tulo</th><th>Status</th><th class="nome">Atendente</th></tr></thead><tbody>
				{{HELPDESKS}}
					</tbody>
				</table>
			</div>
			
		</div>
		
{{RODAPE}}