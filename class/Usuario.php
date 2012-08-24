<?php
include_once "usuarioDAO.php";

class Usuario{

	public function GetId($login){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->GetIdDAO($login);
	}
	public function GetNome($login){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->GetNomeDAO($login);
	}
	public function GetGrupo($login){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->GetGrupoDAO($login);
	}
	
	public function GetUserByID($idUser){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->GetUserByIDDAO($idUser);
	}
	
	public function ValidaUsuario($login, $senha){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->ValidaUsuarioDAO($login, md5($senha));
	}
	
	public function ExcluirUsuario($id){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->ExcluirUsuarioDAO($id);
	}
	
	public function GetTodosUsuarios(){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->GetTodosUsuariosDAO();
	}
	
	public function ResetarSenha($id){
		$usuarioDAO = new UsuarioDAO();
		return $usuarioDAO->ResetarSenhaDAO($id);
	}
	
	public function CadastrarUsuario($nome, $login, $ramal, $email, $grupo){
		$usuarioDAO = new UsuarioDAO();
		$senhaPadrao = md5('1234');
		if(!$this->GetNome($login)):
			return $usuarioDAO->CadastrarUsuarioDAO($nome, $login, $ramal, $email, $grupo, $senhaPadrao);
		else:
			return 0;
		endif;
	}
	
	public function AlterarSenha($login, $novasenha){
		$usuarioDAO = new UsuarioDAO();
		$novasenha = md5($novasenha);
		return $usuarioDAO->AlterarSenhaDAO($login, $novasenha);
	}

}