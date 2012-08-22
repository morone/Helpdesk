<?php

include_once 'master.inc.php';

class UsuarioDAO{

	private $_conexao;
	public $id;
	public $nome;

	
	function __construct(){
		$this->_conexao = conectaComBanco();
	}
	
	
	#DEPRECATED##########################
	public function GetUserByIDDAO($idUser){
		$result = mysqli_query($this->_conexao, "SELECT nome FROM tb_usuario WHERE id = '". $idUser . "'");
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['nome'];
			}
		}
	}
	####################################
	
	
	public function GetIdDAO($login){
		$result = mysqli_query($this->_conexao, "SELECT id FROM tb_usuario WHERE login = '". $login . "'");
		
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['id'];
			}
		}
	}
	
	public function GetGrupoDAO($login){
		$result = mysqli_query($this->_conexao, "SELECT grupo FROM tb_usuario WHERE login = '". $login . "'");
		
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['grupo'];
			}
		}
	}
	
	public function GetNomeDAO($login){
		$result = mysqli_query($this->_conexao, "SELECT nome FROM tb_usuario WHERE login = '". $login . "'");
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['nome'];
			}
		}
	}
	
	public function ValidaUsuarioDAO($login, $senha){
		$this->_conexao = conectaComBanco();
		$sqlStr = "SELECT login FROM tb_usuario WHERE login = ? and senha = ?";
		$stmt = $this->_conexao->prepare($sqlStr);
		$stmt->bind_param('ss', $login, $senha); 
		$stmt->bind_result($ias);
		$stmt->execute();
		
		while($stmt->fetch()){
			return $ias;
		}

		desconectaDoBanco($this->_conexao);
		
	}
	
	
	public function GetTodosUsuariosDAO(){
		
		$sqlStr = "SELECT id, login, nome, grupo, ramal, email FROM tb_usuario ORDER BY id";
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$users[] =  Array('id'=>$r['id'], 'login'=> $r['login'], 'nome'=>$r['nome'], 'grupo'=>$r['grupo'], 'ramal'=> $r['ramal'], 'email' => $r['email'],);
			}
		}
		
		return $users;
	
	}
	
	public function CadastrarUsuarioDAO($nome, $login, $ramal, $email, $grupo, $senha){
		
		$stmt = $this->_conexao->prepare("INSERT INTO tb_usuario(nome, login, ramal, email, grupo, senha) VALUES(?,?,?,?,?,?)");
		$stmt->bind_param('ssssss', $nome, $login, $ramal, $email, $grupo, $senha); 
		$stmt->execute();
		return $this->_conexao->insert_id;
		desconectaDoBanco($this->_conexao);
	}
	

}