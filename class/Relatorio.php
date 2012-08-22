<?php

include_once "RelatorioDAO.php";


class Relatorio{
	
	private $_dias;
	
	function __construct(){
		$relatorioDAO = new RelatorioDAO();
		$this->_dias = $relatorioDAO->GetTotalDiasHouveramHelpdeskDAO();
	}
	
	public function GetMediaAtendimentoPorCategoria(){
		$relatorioDAO = new RelatorioDAO();
		$media = $relatorioDAO->GetMediaAtendimentoPorCategoriaDAO();
		for($i=0;$i<sizeof($media);$i++):
			$media[$i]['media'] = $this->CalcularTempo($media[$i]['media']);
		endfor;
		return $media;
	}
	
	public function GetMediaAtendimentoGeral(){
		$relatorioDAO = new RelatorioDAO();
		$media = $relatorioDAO->GetMediaAtendimentoGeralDAO();
		for($i=0;$i<sizeof($media);$i++):
			$media[$i]['media'] = $this->CalcularTempo($media[$i]['media']);
		endfor;
		return $media;
	}
	
	public function GetMediaAberturaPorDiaGeral($periodo){
		$relatorioDAO = new RelatorioDAO();
		$data = new Data();
		
		$totalChamados = $relatorioDAO->GetMediaAberturaPorDiaGeralDAO();

		
		switch($periodo):
			case 'ANO':
				return sprintf("%2.2f", $totalChamados / $data->getDiasUteis(date("Y")-1 . date("-m-d"), date("Y-m-d"), GetFeriados()));
				break;
			case 'MES':
				return sprintf("%2.2f", $totalChamados / $data->getDiasUteis($data->subtrairDias(date("d-m-Y"), 0, 1), date("Y-m-d"), GetFeriados()));
				break;
			case 'SEMANA':
				return sprintf("%2.2f", $totalChamados / $data->getDiasUteis($data->subtrairDias(date("d-m-Y"), 7), date("Y-m-d"), GetFeriados()));
				break;
		endswitch;
	}
	
	public function GetMediaAberturaPorDiaPorCategoria($categoria, $periodo){
		$relatorioDAO = new RelatorioDAO();
		$data = new Data();

		$feriados = array("2008-12-25","2008-12-26","2009-01-01");
		
		$totalChamados = $relatorioDAO->GetMediaAberturaPorDiaPorCategoriaDAO($categoria);
		
		switch($periodo):
			case 'ANO':
				return sprintf("%2.2f", $totalChamados / $data->getDiasUteis(date("Y")-1 . date("-m-d"), date("Y-m-d"), $feriados));
				break;
			case 'MES':
				return sprintf("%2.2f", $totalChamados / $data->getDiasUteis($data->subtrairDias(date("d-m-Y"), 0, 1), date("Y-m-d"), $feriados));
				break;
			case 'SEMANA':
				return sprintf("%2.2f", $totalChamados / $data->getDiasUteis($data->subtrairDias(date("d-m-Y"), 7), date("Y-m-d"), $feriados));
				break;
		endswitch;
		
		
	}
	
	public function GetMediaAberturaPorHoraGeral($hora){
		$relatorioDAO = new RelatorioDAO();
		return $relatorioDAO->GetMediaAberturaPorHoraGeralDAO(($hora<10?'0'.$hora:$hora))/$this->_dias;
	}
	
	public function GetMediaAberturaPorHoraCategoria($hora, $categoria){
		$relatorioDAO = new RelatorioDAO();
		return $relatorioDAO->GetMediaAberturaPorHoraCategoriaDAO($hora, $categoria)/$this->_dias;
	}
	
	public function GetTotalDiasHouveramHelpdesk(){
		$relatorioDAO = new RelatorioDAO();
		return $relatorioDAO->GetTotalDiasHouveramHelpdeskDAO();
	}
	
	
	private function CalcularTempo($minutos){
		$dias = floor($minutos/(60*24));
		$horas = floor($minutos%(60*24)/60);
		$minutos = floor(($minutos%(60*24)%60));
		
		if($dias>0)	$resposta .= $dias . "d";
		if($horas>0)$resposta .= $horas . "h";
		$resposta .= $minutos . "m";
		
		return $resposta;	
	}
	
	

}