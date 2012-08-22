<?php

include_once 'master.inc.php';

class RelatorioDAO{
	
	private $_conexao;
	
	
	public function GetMediaAtendimentoPorCategoriaDAO(){
		$this->_conexao = conectaComBanco();
		
		$sqlStr = "SELECT
					categoria.descricao,
					avg(chamado.tempo_total) as media
				FROM
					tb_chamado chamado
					inner join tb_categoria categoria on categoria.id = chamado.categoria
				WHERE
					finalizado = 1
				GROUP BY
					(categoria)
				LIMIT 100";
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$TotalCategoria[] = Array('descricao' => $r['descricao'], 'media' => $r['media']);
			}
		}
		desconectaDoBanco($this->_conexao);
		return $TotalCategoria;
	}
	
	public function GetMediaAtendimentoGeralDAO(){
		$this->_conexao = conectaComBanco();
		$sqlStr = "SELECT 
					avg(tempo_total) as media
				FROM
					tb_chamado
				WHERE
					finalizado = 1
				LIMIT 100";
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$TotalCategoria[] = Array('descricao' => $r['descricao'], 'media' => $r['media']);
			}
		}
		desconectaDoBanco($this->_conexao);
		return $TotalCategoria;
	}
	
	public function GetMediaAberturaPorDiaGeralDAO(){
		$this->_conexao = conectaComBanco();
		
		
		$sqlStr = "select count(id) as total from tb_chamado";
		
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$totalGeral = $r['total'];
			}
		}
		desconectaDoBanco($this->_conexao);
		return $totalGeral;
	}
	
	public function GetMediaAberturaPorDiaPorCategoriaDAO($categoria){
		
		$this->_conexao = conectaComBanco();

		$sqlStr = "select count(id) as total from tb_chamado where categoria = " . $categoria;
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$TotalCategoria = $r['total'];
			}
		}
		desconectaDoBanco($this->_conexao);
		return $TotalCategoria;
	}
	
	public function GetMediaAberturaPorHoraGeralDAO($hora){
		$this->_conexao = conectaComBanco();

		$sqlStr = "select
						count(chamado.id) as total
					from 
						tb_chamado chamado
						left join tb_resposta_chamado resposta on resposta.id_chamado = chamado.id
					where
						resposta.id = (select min(id) from tb_resposta_chamado where id_chamado = chamado.id) and
						time(resposta.data) > '".$hora.":00:00' and
						time(resposta.data) < '".$hora.":59:59'
					limit 100";
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$totalHora = $r['total'];
			}
		}
		desconectaDoBanco($this->_conexao);
		return $totalHora;	
	}
	
	public function GetMediaAberturaPorHoraCategoriaDAO($hora, $categoria){
		$this->_conexao = conectaComBanco();

		$sqlStr = "select
						count(chamado.id) as total
					from 
						tb_chamado chamado
						left join tb_resposta_chamado resposta on resposta.id_chamado = chamado.id
					where
						resposta.id = (select min(id) from tb_resposta_chamado where id_chamado = chamado.id) and
						time(resposta.data) > '".$hora.":00:00' and
						time(resposta.data) < '".$hora.":59:59' and
						chamado.categoria = ".$categoria."
					limit 100";
		
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$totalHora = $r['total'];
			}
		}
		desconectaDoBanco($this->_conexao);
		return $totalHora;	
	}
	
	public function GetTotalDiasHouveramHelpdeskDAO(){
		$this->_conexao = conectaComBanco();
		

		$sqlStr = "select count(data) dias from (
						select distinct
							date(resposta.data) as data
						from 
							tb_chamado chamado
							left join tb_resposta_chamado resposta on resposta.id_chamado = chamado.id
						where
							resposta.id = (select min(id) from tb_resposta_chamado where id_chamado = chamado.id)
						limit 100
					) tb_chamado";

		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$totalHora = $r['dias'];
			}
		}
		desconectaDoBanco($this->_conexao);
		return $totalHora;	
	}
	
	
	
}