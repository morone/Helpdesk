<?php

include_once "CategoriaDAO.php";

class Categoria{
	
	
	public function GetDescricao($id){
		$categoriaDAO = new CategoriaDAO();
		return $categoriaDAO->GetDescricaoDAO($id);
	}

	public function CadastrarCategoria($categoria){
		$categoriaDAO = new CategoriaDAO();
		$categoriaDAO->CadastrarCategoriaDAO($categoria);
	}
	
	public function RetornarCategorias(){
		$categoriaDAO = new CategoriaDAO();
		return $categoriaDAO->RetornarCategoriasDAO();
	}
	
	public function Deletar($id){
		$categoriaDAO = new CategoriaDAO();
		$categoriaDAO->DeletarDAO($id);
	}

}