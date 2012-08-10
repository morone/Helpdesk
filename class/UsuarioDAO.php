<?php

include_once 'master.inc.php';

class UsuarioDAO{

	private $_conexao;
	public $id;
	public $nome;

	function __construct() {
		$this->_conexao = conectaComBanco();
		
		$result = mysqli_query($this->_conexao, "SELECT id, nome FROM tb_usuario WHERE hostname = '". gethostname() . "'");
		if($result){
			while($r=$result->fetch_assoc()){
				$this->id 	= $r['id'];
				$this->nome = $r['nome'];
			}
		}
		
	}
	
	
	public function GetUserByIDDAO($idUser){
		$result = mysqli_query($this->_conexao, "SELECT nome FROM tb_usuario WHERE id = '". $idUser . "'");
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['nome'];
			}
		}
	}

}