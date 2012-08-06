<?php

class ChamadoDAO{

	private $_conexao;
	private $_chamados;
	private $_respostas;
	
	function __construct() {
		$this->_conexao = @new mysqli('localhost', 'root', '', 'helpdesk_comos');

		if (!$this->_conexao) {
			die('Não foi possível conectar: ' . mysql_error());
		}
	}

	public function CriarChamadoDAO($idUsuario, $titulo, $os){
		$this->_conexao->query("INSERT INTO tb_chamado(id_usuario, os, titulo, finalizado) VALUES(".$idUsuario.", '".$os."', '".$titulo."', 0)");
		return $this->_conexao->insert_id;
		mysqli_close($this->_conexao);
	}
	
	public function CriarRespostaDAO($idChamado, $idUsuario, $mensagem){
		$ultimaOrdem = $this->GetUltimaOrdem($idChamado);
		return $this->_conexao->query("INSERT INTO tb_resposta_chamado(id_chamado, ordem, id_usuario, mensagem, data) VALUES(".$idChamado.", ". ($ultimaOrdem!=""?$ultimaOrdem+1:0) .", ".$idUsuario.", '".$mensagem."', CURDATE())");
		mysqli_close($this->_conexao);
	}
	
	public function GetTodosChamadosDAO($idUsuario=""){
		$sqlStr = "SELECT id_chamado, os, titulo FROM tb_chamado WHERE finalizado = 0 ";
		
		if($idUsuario){
			$sqlStr .= " AND id_usuario = ". $idUsuario ." ";
		}
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$this->_chamados[$r['id_chamado']] = Array($r['id_chamado'], $r['os'], $r['titulo']);
			}
		}else{
			$this->chamados ="";
		}
		return $this->_chamados;
	}
	
	public function GetRespostasDAO($idChamado){
		$sqlStr = "SELECT mensagem, data, id_usuario FROM tb_resposta_chamado WHERE id_chamado = ". $idChamado ." ORDER BY ordem DESC";
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$this->_respostas[] = Array('mensagem' => $r['mensagem'], 'data' => $r['data'], 'usuario' => $r['id_usuario']);
			}
		}
		return $this->_respostas;
	}
	
	private function GetUltimaOrdem($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT MAX(ordem) as ordem FROM tb_resposta_chamado WHERE id_chamado = ". $idChamado);
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['ordem'];
			}
		}
	}
	
	public function FinalizarDAO($idChamado){
		mysqli_query($this->_conexao, "UPDATE tb_chamado SET finalizado = 1 WHERE id_chamado=".$idChamado);
	}
	
	public function isFinalizadoDAO($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT finalizado  FROM tb_chamado WHERE id_chamado = ". $idChamado);
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['finalizado'];
			}
		}
	}
}