<?php
include_once "Usuario.php";

class ChamadoDAO{

	private $_conexao;
	private $_chamados;
	private $_respostas;
	
	private $_usuario;
	
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
		return $this->_conexao->query("INSERT INTO tb_resposta_chamado(id_chamado, id_usuario, mensagem, data) VALUES(".$idChamado.", ".$idUsuario.", '".nl2br($mensagem)."', CURDATE())");
		mysqli_close($this->_conexao);
	}
	
	public function AtenderChamadoDAO($idChamado){
		$this->usuario = new Usuario();
		mysqli_query($this->_conexao, "UPDATE tb_chamado SET id_atendente = ".$this->usuario->GetId()." WHERE id_chamado=".$idChamado);
	}
	
	public function GetTodosChamadosDAO($idUsuario="", $todosChamados=""){
		$sqlStr = "SELECT 
			chamado.id_chamado, 
			chamado.os, 
			chamado.titulo, 
			chamado.id_atendente, 
			chamado.id_usuario,
			resp.mensagem,
			usuario.nome,
			usuario.ramal,
			resp.data
		FROM 
			tb_chamado chamado
			inner join tb_resposta_chamado resp on resp.id_chamado = chamado.id_chamado
			inner join tb_usuario usuario on usuario.id_usuario = chamado.id_usuario
		WHERE 
			resp.id_resposta = (select min(id_resposta) from tb_resposta_chamado where id_chamado = chamado.id_chamado)";
		
		if($todosChamados==""){
			$sqlStr .= " AND finalizado = 0 ";
		}
		
		if($idUsuario){
			$sqlStr .= " AND chamado.id_usuario = ". $idUsuario ." ";
		}
		
		$sqlStr .= " ORDER BY chamado.os, resp.data DESC ";
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$this->_chamados[] = Array('id_chamado' => $r['id_chamado'], 'os' => $r['os'], 'titulo' => $r['titulo'], 'atendimento' => $r['id_atendente'], 'id_usuario' => $r['id_usuario'], 'usuario' => $r['nome'],'data' => $r['data'], 'mensagem' => $r['mensagem'], 'usuario_ramal' =>  $r['ramal']);
			}
		}else{
			$this->chamados ="";
		}
		return $this->_chamados;
	}
	
	public function GetRespostasDAO($idChamado){
		$sqlStr = "SELECT mensagem, data, id_usuario, id_resposta FROM tb_resposta_chamado WHERE id_chamado = ". $idChamado ." ORDER BY id_resposta DESC";
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$this->_respostas[] = Array('mensagem' => $r['mensagem'], 'data' => $r['data'], 'usuario' => $r['id_usuario'], 'id_resposta' => $r['id_resposta']);
			}
		}
		return $this->_respostas;
	}
	
	public function ApagarRespostaDAO($idResposta){
		mysqli_query($this->_conexao, "DELETE FROM tb_resposta_chamado WHERE id_resposta = " . $idResposta);
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
	
	
	
	public function GetSolicitanteDAO($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT id_usuario  FROM tb_chamado WHERE id_chamado = ". $idChamado);
		$this->usuario = new Usuario();
		if($result){
			while($r=$result->fetch_assoc()){
				return $this->usuario->getUserById($r['id_usuario']);
			}
		}
	}
	
	public function GetAtendenteDAO($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT id_atendente  FROM tb_chamado WHERE id_chamado = ". $idChamado);
		$this->usuario = new Usuario();
		if($result){
			while($r=$result->fetch_assoc()){
				return $this->usuario->getUserById($r['id_atendente']);
			}
		}
	}
	
}