<?php
include_once 'master.inc.php';

class ChamadoDAO{

	private $_conexao;
	private $_chamados;
	private $_respostas;
	
	private $_usuario;
	
	function __construct() {
		$this->_conexao = conectaComBanco();
	}

	public function CriarChamadoDAO($idUsuario, $titulo, $os, $categoria){
		$this->_conexao->query("INSERT INTO tb_chamado(id_usuario, os, categoria, titulo, finalizado) VALUES(".$idUsuario.", '".$os."', '".$categoria."', '".$titulo."', 0)");
		return $this->_conexao->insert_id;
		desconectaDoBanco($this->_conexao);
	}
	
	public function CriarRespostaDAO($idChamado, $idUsuario, $mensagem){
		return $this->_conexao->query("INSERT INTO tb_resposta_chamado(id_chamado, id_usuario, mensagem, data) VALUES(".$idChamado.", ".$idUsuario.", '".nl2br($mensagem)."', '".date("Y-m-d H:i:s")."')");
		desconectaDoBanco($this->_conexao);
	}
	
	public function AtenderChamadoDAO($idChamado){
		$this->usuario = new Usuario();
		mysqli_query($this->_conexao, "UPDATE tb_chamado SET id_atendente = ".$this->usuario->GetId()." WHERE id =".$idChamado);
		desconectaDoBanco($this->_conexao);
	}
	
	public function GetTodosChamadosDAO($idUsuario="", $todosChamados=""){
		$sqlStr = "SELECT 
			chamado.id, 
			chamado.os, 
			chamado.titulo, 
			chamado.id_atendente, 
			chamado.id_usuario,
			chamado.categoria,
			resp.mensagem,
			usuario.nome,
			usuario.ramal,
			date_format(resp.data, '%d/%m/%y - %H:%m') as data
		FROM 
			tb_chamado chamado
			inner join tb_resposta_chamado resp on resp.id_chamado = chamado.id
			inner join tb_usuario usuario on usuario.id = chamado.id_usuario
		WHERE 
			resp.id = (select min(id) from tb_resposta_chamado where id_chamado = chamado.id)";
		
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
				$this->_chamados[] = Array(
					'id_chamado' 	=> $r['id'], 
					'os' 			=> $r['os'], 
					'titulo' 		=> $r['titulo'], 
					'atendimento'	=> $r['id_atendente'], 
					'id_usuario' 	=> $r['id_usuario'], 
					'usuario' 		=> $r['nome'],
					'data'		 	=> $r['data'], 
					'mensagem' 		=> $r['mensagem'], 
					'usuario_ramal' => $r['ramal'],
					'categoria'		=> $r['categoria'],
				);
			}
		}else{
			$this->chamados ="";
		}
		return $this->_chamados;
		desconectaDoBanco($this->_conexao);
	}
	
	public function GetRespostasDAO($idChamado){
		$sqlStr = "SELECT mensagem, date_format(data, '%d/%m/%y - %H:%m') as data, id_usuario, id FROM tb_resposta_chamado WHERE id_chamado = ". $idChamado ." ORDER BY id DESC";
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$this->_respostas[] = Array('mensagem' => $r['mensagem'], 'data' => $r['data'], 'usuario' => $r['id_usuario'], 'id_resposta' => $r['id']);
			}
		}
		return $this->_respostas;
	}
	
	public function ApagarRespostaDAO($idResposta){
		mysqli_query($this->_conexao, "DELETE FROM tb_resposta_chamado WHERE id = " . $idResposta);
		desconectaDoBanco($this->_conexao);
	}
	
	
	public function FinalizarDAO($idChamado){
		mysqli_query($this->_conexao, "UPDATE tb_chamado SET finalizado = 1 WHERE id =".$idChamado);
		desconectaDoBanco($this->_conexao);
	}
	
	public function isFinalizadoDAO($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT finalizado  FROM tb_chamado WHERE id = ". $idChamado);
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['finalizado'];
			}
		}
		desconectaDoBanco($this->_conexao);
	}
	
	
	
	public function GetSolicitanteDAO($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT id_usuario  FROM tb_chamado WHERE id  = ". $idChamado);
		$this->usuario = new Usuario();
		if($result){
			while($r=$result->fetch_assoc()){
				return $this->usuario->getUserById($r['id_usuario']);
			}
		}
		desconectaDoBanco($this->_conexao);
	}
	
	public function GetAtendenteDAO($idChamado){
		$result = mysqli_query($this->_conexao, "SELECT id_atendente  FROM tb_chamado WHERE id = ". $idChamado);
		$this->usuario = new Usuario();
		if($result){
			while($r=$result->fetch_assoc()){
				return $this->usuario->getUserById($r['id_atendente']);
			}
		}
		desconectaDoBanco($this->_conexao);
	}
	
}