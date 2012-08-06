<?php

class UsuarioDAO{

	private $_conexao;
	public $id;
	public $nome;

	function __construct() {
		$this->_conexao = @new mysqli('localhost', 'root', '', 'helpdesk_comos');

		if (!$this->_conexao) {
			die('Não foi possível conectar: ' . mysql_error());
		}
		
		$result = mysqli_query($this->_conexao, "SELECT id_usuario, nome FROM tb_usuario WHERE hostname = '". gethostname() . "'");
		if($result){
			while($r=$result->fetch_assoc()){
				$this->id = $r['id_usuario'];
				$this->nome = $r['nome'];
			}
		}
		
	}
	
	
	public function GetUserByIdDAO($idUser){
		$result = mysqli_query($this->_conexao, "SELECT nome FROM tb_usuario WHERE id_usuario = '". $idUser . "'");
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['nome'];
			}
		}
	}

}