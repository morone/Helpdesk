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
		
		$stmt = $this->_conexao->prepare("INSERT INTO tb_chamado(id_usuario, os, categoria, titulo, finalizado) VALUES(?,?,?,?, 0)");
		$stmt->bind_param('isis', $idUsuario, $os, $categoria, $titulo); 
		$stmt->execute();
		return $this->_conexao->insert_id;
		desconectaDoBanco($this->_conexao);
	}
	
	public function CriarRespostaDAO($idChamado, $idUsuario, $mensagem){
		$stmt = $this->_conexao->prepare("INSERT INTO tb_resposta_chamado(id_chamado, id_usuario, mensagem, data) VALUES(?, ?, ?, ?)");
		$mensagem = nl2br($mensagem);
		$data = date("Y-m-d H:i:s");
		$stmt->bind_param('iiss', $idChamado, $idUsuario, $mensagem, $data); 
		return $stmt->execute();
		desconectaDoBanco($this->_conexao);
	}
	
	public function AtenderChamadoDAO($idChamado){
		$this->usuario = new Usuario();
		mysqli_query($this->_conexao, "UPDATE tb_chamado SET id_atendente = ".$this->usuario->GetId($_SESSION['login'])." WHERE id =".$idChamado);
		desconectaDoBanco($this->_conexao);
	}
	
	public function GetTodosChamadosDAO($filtros="", $idUsuario="", $finalizado=""){
		$sqlStr = "SELECT 
				chamado.id, 
				chamado.os, 
				chamado.titulo, 
				chamado.id_atendente, 
				chamado.id_usuario,
				chamado.categoria,
				chamado.finalizado,
				resp.mensagem,
				resp.data,
				usuario.nome nome_usuario,
				usuario.ramal,
				atendente.nome as nome_atendente,
				date_format(ultimaResposta.data, '%d/%m/%y - %H:%i') as ultima_resp_data,
				date_format(resp.data, '%d/%m/%y - %H:%i') as data_abertura,
				case when chamado.finalizado = 1
					then chamado.tempo_total end as totalGasto
			FROM 
				tb_chamado chamado
				inner join tb_resposta_chamado resp on resp.id_chamado = chamado.id
				inner join tb_usuario usuario on usuario.id = chamado.id_usuario
				left join tb_usuario atendente on atendente.id = chamado.id_atendente
				inner join tb_resposta_chamado ultimaResposta on ultimaResposta.id_chamado = chamado.id
			WHERE 
				resp.id = (select min(id) from tb_resposta_chamado where id_chamado = chamado.id) AND
				ultimaResposta.id = (select max(id) from tb_resposta_chamado where id_chamado = chamado.id)";
		
		if($finalizado!=""):
			$sqlStr .= " AND finalizado = " . $finalizado;
		endif;
		
		if($idUsuario):
			$sqlStr .= " AND chamado.id_usuario = ". $idUsuario ." ";
		endif;
		
		
		#TODO - Modificar chamada dos parâmetros para evitar SQL INJECTION.
		if($filtros!=""):
			$sqlStr .= (isset($filtros['numeroChamado'])		?' and chamado.id = '.$filtros['numeroChamado'].' ':'');
			$sqlStr .= (isset($filtros['usuario'])				?' and usuario.nome LIKE "%'.$filtros['usuario'].'%" ':'');
			$sqlStr .= (isset($filtros['categoria'])			?' and chamado.categoria = '.$filtros['categoria'].' ':'');
			$sqlStr .= (isset($filtros['os'])					?' and chamado.os = '.$filtros['os'].' ':'');
			
			if(isset($filtros['status'])):
				switch ($filtros['status']):
					case 'naoAtendido':
						$sqlStr .= ' and chamado.finalizado = 0 and id_atendente = 0 ';
					break;
					case 'emAtendimento':
						$sqlStr .= ' and chamado.finalizado = 0 and id_atendente <> 0 ';
					break;
					case 'finalizado':
						$sqlStr .= ' and chamado.finalizado = 1 ';
					break;
				endswitch;
			endif;
			
			$sqlStr .= (isset($filtros['texto'])				?' and (chamado.titulo LIKE "%'.$filtros['texto'].'%" or  resp.mensagem LIKE "%'.$filtros['texto'].'%") ':'');
			$sqlStr .= (isset($filtros['dataAberturaDe'])		?' and date_format(resp.data,\'%d/%m/%y\') >= "'.$filtros['dataAberturaDe'].'" ':'');
			$sqlStr .= (isset($filtros['dataAberturaAte'])		?' and date_format(resp.data,\'%d/%m/%y\') <= "'.$filtros['dataAberturaAte'].'" ':'');
			$sqlStr .= (isset($filtros['dataFechamentoDe'])		?' and date_format(ultimaResposta.data,\'%d/%m/%y\') >= "'.$filtros['dataFechamentoDe'].'" and chamado.finalizado = 1 ':'');
			$sqlStr .= (isset($filtros['dataFechamentoAte'])	?' and date_format(ultimaResposta.data,\'%d/%m/%y\') <= "'.$filtros['dataFechamentoAte'].'" and chamado.finalizado = 1 ':'');
		endif;
		
		
		$sqlStr .= " ORDER BY chamado.categoria, data_abertura DESC ";

		//echo $sqlStr;
		
		$result = mysqli_query($this->_conexao, $sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				$this->_chamados[] = Array(
					'id_chamado' 	=> $r['id'], 
					'os' 			=> $r['os'], 
					'titulo' 		=> $r['titulo'], 
					'atendimento'	=> $r['id_atendente'], 
					'id_usuario' 	=> $r['id_usuario'], 
					'usuario' 		=> $r['nome_usuario'],
					'atendente'		=> $r['nome_atendente'],
					'data_abertura'	=> $r['data_abertura'], 
					'mensagem' 		=> $r['mensagem'], 
					'usuario_ramal' => $r['ramal'],
					'categoria'		=> $r['categoria'],
					'finalizado'	=> $r['finalizado'],
					'ultima_resp'	=> $r['ultima_resp_data'],
					'totalGasto'	=> $r['totalGasto'],
				);
			}
		}else{
			$this->chamados ="";
		}
		return $this->_chamados;
		desconectaDoBanco($this->_conexao);
	}
	
	public function GetRespostasDAO($idChamado){
		$sqlStr = "SELECT mensagem, date_format(data, '%d/%m/%y - %H:%i') as data, id_usuario, id FROM tb_resposta_chamado WHERE id_chamado = ". $idChamado ." ORDER BY id DESC";
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
	
	
	public function FinalizarDAO($idChamado, $timeDiff){
		
		$sqlStr = "UPDATE 
						tb_chamado 
					SET 
						tempo_total = ".$timeDiff.",
						finalizado = 1
					WHERE 
						id = " . $idChamado;
		
		mysqli_query($this->_conexao, $sqlStr);
		desconectaDoBanco($this->_conexao);
	}
	
	
	public function GetTimeDiffDAO($idChamado){
		$sqlStr = "SELECT TIMESTAMPDIFF(MINUTE, min(data), max(data)) as timeDiff FROM tb_resposta_chamado WHERE id_chamado = ".$idChamado;
		$result = mysqli_query($this->_conexao,$sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				return $r['timeDiff'];
			}
		}
		
		desconectaDoBanco($this->_conexao);
	}
	
	public function GetDataInicioFinalizacaoDAO($idChamado){
		$sqlStr = "SELECT date_format(min(data), '%Y/%m/%d') as inicio, date_format(max(data), '%Y/%m/%d') as final FROM tb_resposta_chamado WHERE id_chamado = ".$idChamado;
		$result = mysqli_query($this->_conexao,$sqlStr);
		if($result){
			while($r=$result->fetch_assoc()){
				return Array($r['inicio'], $r['final']);
			}
		}
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