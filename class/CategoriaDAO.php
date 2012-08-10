<?php

include_once 'master.inc.php';

class CategoriaDAO{
	
	private $_conexao;
	
	public function GetDescricaoDAO($id){
		$this->_conexao = ConectaComBanco();
		$sqlStr = "SELECT descricao FROM tb_categoria WHERE id = " . $id;
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['descricao'];
			}
		}
		desconectaDoBanco($this->_conexao);
		return $categorias;
	}
	
	public function CadastrarCategoriaDAO($categoria){
		$this->_conexao = ConectaComBanco();
		echo "INSERT INTO tb_categoria(descricao) VALUES('".$categoria."')";
		return $this->_conexao->query("INSERT INTO tb_categoria(descricao) VALUES('".$categoria."')");
		desconectaDoBanco($this->_conexao);
	}
	
	public function RetornarCategoriasDAO(){
		$this->_conexao = ConectaComBanco();
		$sqlStr = "SELECT id, descricao, totalChamados(id, 0) as total_abertos, totalChamados(id, 1) as total_fechados FROM tb_categoria";
		
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$categorias[] = Array('id_categoria' => $r['id'], 'descricao' => $r['descricao'], 'total' => $r['total_abertos']+ $r['total_fechados']);
			}
		}
		desconectaDoBanco($this->_conexao);
		return $categorias;
	}
	
	public function DeletarDAO($id){
		$this->_conexao = ConectaComBanco();
		mysqli_query($this->_conexao, "DELETE FROM tb_categoria WHERE id = " . $id);
		desconectaDoBanco($this->_conexao);
	}

}