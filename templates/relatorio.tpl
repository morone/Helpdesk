{{CABECALHO}}
		<div class="main">
			<h2>Relat&oacute;rios</h2>	
			<input type="hidden" id="idChamado" value="{{ID_CHAMADO}}" />
			
		<h3>Tempo de atendimento</h3>
			
			<!-- Relatório de média geral -->
			<table cellpadding="0" cellspacing="0" id="relatorio">
				<caption>Geral</caption>
				<thead>
					<tr>
						<th class="descricao"></th>
						<th>Tempo m&eacute;dio</th>
					</tr>
				</thead>
				<tbody>
					{{MEDIA_GERAL}}
				</tbody>	
			</table>

			<!-- Relatório de média por categoria -->
			<table cellpadding="0" cellspacing="0" id="relatorio">
				<caption>Por Categoria</caption>
				<thead>
					<tr>
						<th class="descricao">Categoria</th>
						<th>Tempo m&eacute;dio</th>
					</tr>
				</thead>
				<tbody>
					{{MEDIA_POR_CATEGORIA}}
				</tbody>	
			</table>
			
			<br /><br />
			
			
		<h3>Helpdesks por Dia</h3>
		
		<!-- Relatório de média de abertura de Helpdesks por dia -->
			<table cellpadding="0" cellspacing="0" id="relatorio">
				<caption>Geral</caption>
				<thead>
					<tr>
						<th class="descricao">M&eacute;dia/Dia</th>
						<th>Por Semana</th>
						<th>Por M&ecirc;s</th>
						<th>Por Ano</th>
					</tr>
				</thead>
				<tbody>
					{{ABERTURA_GERAL}}
				</tbody>	
			</table>	
		<!-- Relatório de média de abertura de Helpdesks por dia por categoria-->
			<table cellpadding="0" cellspacing="0" id="relatorio">
				<caption>Por Categoria</caption>
				<thead>
					<tr>
						<th class="descricao">Categoria</th>
						<th>Por Semana</th>
						<th>Por M&ecirc;s</th>
						<th>Por Ano</th>
					</tr>
				</thead>
				<tbody>
					{{ABERTURA_CATEGORIA}}
				</tbody>	
			</table>
			
			<br /><br />
			
			
			<h3>Helpdesks Abertos por Hora</h3>
			
			
			<!-- Gráfico de média de abertura de Helpdesks por hora do dia-->	
			<h3>Geral</h3>
			<div id="placeholder-porHoraGeral" style="width:600px;height:300px;"></div>
			
			<!-- Gráfico de média de abertura de Helpdesks por hora do dia-->	
			<!-- <br/>	<h3>Categoria</h3>
			<div id="placeholder-porHoraCategoria" style="width:600px;height:300px;"></div> -->
			
		</div>
		
		
{{RODAPE}}