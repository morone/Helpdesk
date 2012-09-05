<?php
/*****
 * Desenvolvido por: Bruno da Silva Assis
 ****/
class Data
{
	private static function _explodirData($data, $formatoEntrada='BR', $formatoSaida='BR', $separador='-')
	{
		$data = explode($separador, $data);
		$dia = ($formatoEntrada = 'BR' ? $data[0] : $data[1]);
		$mes = ($formatoEntrada = 'BR' ? $data[1] : $data[0]);
		$ano = $data[2];

		$retorno[] = ($formatoSaida == 'BR' ? $dia : $mes);
		$retorno[] = ($formatoSaida == 'BR' ? $mes : $dia);
		$retorno[] = $ano;

		return $retorno;
	}


	public static function retornaIso($data, $formatoEntrada='BR', $separador='/')
	{
		$data = self::_explodirData($data, $formatoEntrada, 'BR', $separador);
		return $data[2] . $data[1] . $data[0];
	}

	public static function adicionarDias($data, $dias=0, $meses=0, $anos=0, $formatoEntrada='BR', $formatoSaida='BR', $separador='-')
	{
		$data = self::_explodirData($data, $formatoEntrada, $formatoSaida, $separador);

		$dia = ($formatoEntrada == 'BR' ? $data[0] : $data[1]);
		$mes = ($formatoEntrada == 'BR' ? $data[1] : $data[0]);
		$ano = $data[2];

		return date(($formatoEntrada == 'BR' ? 'd' . $separador . 'm' : 'm' . $separador . 'd') . $separador . 'Y', mktime(0, 0, 0, $mes + $meses, $dia + $dias, $ano + $anos));
	}
	
	public static function subtrairDias($data, $dias=0, $meses=0, $anos=0, $formatoEntrada='BR', $formatoSaida='BR', $separador='-')
	{
		$data = self::_explodirData($data, $formatoEntrada, $formatoSaida, $separador);

		$dia = ($formatoEntrada == 'BR' ? $data[0] : $data[1]);
		$mes = ($formatoEntrada == 'BR' ? $data[1] : $data[0]);
		$ano = $data[2];

		return date('Y' . $separador . 'm' . $separador . 'd', mktime(0, 0, 0, $mes - $meses, $dia - $dias, $ano - $anos));
	}

	public static function date_diff($data1, $data2='', $formatoEntrada='BR', $formatoSaida='BR', $separador='/')
	{
		if ($data1 != '') {
			$data1 = self::_explodirData($data1, $formatoEntrada, $formatoSaida, $separador);

			$dia1 = ($formatoEntrada == 'BR' ? $data1[0] : $data1[1]);
			$mes1 = ($formatoEntrada == 'BR' ? $data1[1] : $data1[0]);
			$ano1 = $data1[2];
			$data1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);

			if ($data2 == '') {
				$data2 = time();
			} else {
				$data2 = self::_explodirData($data2, $formatoEntrada, $formatoSaida, $separador);

				$dia2 = ($formatoEntrada == 'BR' ? $data2[0] : $data2[1]);
				$mes2 = ($formatoEntrada == 'BR' ? $data2[1] : $data2[0]);
				$ano2 = $data2[2];

				$data2 = mktime(0, 0, 0, $mes2, $dia2, $ano2);
			}

			$dateDiff = $data1 - $data2;
			$dias    = floor($dateDiff/(60*60*24));
			$horas   = floor(($dateDiff-($dias*60*60*24))/(60*60));
			$minutos = floor(($dateDiff-($dias*60*60*24)-($horas*60*60))/60);

			$retorno[] = $dias;
			$retorno[] = $horas;
			$retorno[] = $minutos;

			return $retorno;
		}
	}

	public static function retornaDataValida($data)
	{
		if ($data != '') {
			$dataSeparada = preg_split('/\//', $data);
			if ((int) $dataSeparada[0] < 1)		$dataSeparada[0] = '1';
			if ((int) $dataSeparada[0] > 31)	$dataSeparada[0] = '30';
			if (strlen($dataSeparada[0]) < 2) 	$dataSeparada[0] = '0' . $dataSeparada[0];
			if (strlen($dataSeparada[0]) > 2)	$dataSeparada[0] = substr($dataSeparada[0], 0, 2);

			if ((int) $dataSeparada[1] < 1)		$dataSeparada[1] = '1';
			if ((int) $dataSeparada[1] > 12)	$dataSeparada[1] = '12';
			if (strlen($dataSeparada[1]) < 2) 	$dataSeparada[1] = '0' . $dataSeparada[1];
			if (strlen($dataSeparada[1]) > 2)	$dataSeparada[1] = substr($dataSeparada[1], 0, 2);

			if (strlen($dataSeparada[2]) < 4) 	$dataSeparada[2] = '20' . $dataSeparada[2];
			if (strlen($dataSeparada[2]) > 4) 	$dataSeparada[2] = substr($dataSeparada[2], 0, 4);

			$data = $dataSeparada[0] . '/' . $dataSeparada[1] . '/' . $dataSeparada[2];
		}
		return $data;
	}
	
	public static function validaData($data)
	{
		if ($data != '') {
			$dataSeparada = explode('/', $data);
			return checkdate($dataSeparada[1], $dataSeparada[0], $dataSeparada[2]);
		} else {
			return $data;
		}
	}
	
	
//The function returns the no. of business days between two dates and it skips the holidays
	function getDiasUteis($startDate,$endDate,$holidays){
	    // do strtotime calculations just once
	    $endDate = strtotime($endDate);
	    $startDate = strtotime($startDate);
	
	
	    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
	    //We add one to inlude both dates in the interval.
	    $days = ($endDate - $startDate) / 86400 + 1;
	
	    $no_full_weeks = floor($days / 7);
	    $no_remaining_days = fmod($days, 7);
	
	    //It will return 1 if it's Monday,.. ,7 for Sunday
	    $the_first_day_of_week = date("N", $startDate);
	    $the_last_day_of_week = date("N", $endDate);
	
	    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
	    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
	    if ($the_first_day_of_week <= $the_last_day_of_week) {
	        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
	        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
	    }
	    else {
	        // (edit by Tokes to fix an edge case where the start day was a Sunday
	        // and the end day was NOT a Saturday)
	
	        // the day of the week for start is later than the day of the week for end
	        if ($the_first_day_of_week == 7) {
	            // if the start date is a Sunday, then we definitely subtract 1 day
	            $no_remaining_days--;
	
	            if ($the_last_day_of_week == 6) {
	                // if the end date is a Saturday, then we subtract another day
	                $no_remaining_days--;
	            }
	        }
	        else {
	            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
	            // so we skip an entire weekend and subtract 2 days
	            $no_remaining_days -= 2;
	        }
	    }
	
	    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
	//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
	   $workingDays = $no_full_weeks * 5;
	    if ($no_remaining_days > 0 )
	    {
	      $workingDays += $no_remaining_days;
	    }
	
	    //We subtract the holidays
	    foreach($holidays as $holiday){
	        $time_stamp=strtotime($holiday);
	        //If the holiday doesn't fall in weekend
	        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
	            $workingDays--;
	    }
	
	    return $workingDays;
	}
	
	
	
}