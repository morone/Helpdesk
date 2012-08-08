<?php
include_once "usuarioDAO.php";

class Usuario{
	
	private $usuarioDAO;
	
	function __construct(){
		$this->usuarioDAO = new UsuarioDAO();
	}
	
	
	public function GetId(){
		return $this->usuarioDAO->id;
	}
	public function GetNome(){
		return $this->usuarioDAO->nome;
	}
	
	public function GetUserByID($idUser){
		return $this->usuarioDAO->GetUserByIDDAO($idUser);
	}
	

}