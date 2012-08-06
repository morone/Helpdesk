<?php
class Template
{
	private $_pagina;
	private $_excecoes = array('css', 'js');

	public function __construct($arquivo)
	{
		if (file_exists($arquivo)):
			$this->_pagina = implode("", file($arquivo));
		else:
			die("O arquivo ($arquivo) não foi encontrado!");
		endif;
	}

  	public function trocarTags($tags = array())
  	{
	  	if (sizeof($tags) > 0):
      		foreach ($tags as $tag => $valor):
      			if (is_array($valor)):
      				$valor = $valor[0];
      				if (!$valor[1]):
      					$isFile = ($valor != '.' && $valor != '..' && file_exists($valor));
      					$valor = ($isFile ? $this->_tratarArquivo($valor) : $valor);
      				endif;
      			else:
      				$isFile = ($valor != '.' && $valor != '..' && file_exists($valor));
        			$valor = ($isFile ? $this->_tratarArquivo($valor) : $valor);
        		endif;

        		$this->_pagina = str_replace('{{' . $tag . '}}', $valor, $this->_pagina);
			endforeach;
    	else:
      		die('Não há tags a serem trocadas.');
      	endif;
  	}

	private function _tratarArquivo($arquivo)
  	{
  		if (!in_array(preg_replace('/.+\.(.+)$/i', '$1', $arquivo), $this->_excecoes)):
			ob_start();
	    	include($arquivo);
	    	$buffer = ob_get_contents();
	    	ob_end_clean();
	    	$retorno = $buffer;
	    else:
	    	$retorno = $arquivo;
	    endif;
	    return $retorno;
  	}

  	private function _removerTagsNaoUtilizadas()
  	{
  		$this->_pagina = preg_replace('/{{.*?}}/', '', $this->_pagina);
  	}

  	public function mostrar()
  	{
  		$this->_removerTagsNaoUtilizadas();
		echo $this->_pagina;
  	}
}