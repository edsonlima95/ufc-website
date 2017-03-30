<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of paginacao
 *
 * @author edson
 */
class paginacao {

    //Pagina atual.
    private $page;
    //Limite de resultados por pagina.
    private $limit;
    private $offset;
    //Tabela do banco
    private $tabela;
    //Condicões
    private $termos;
    //Places
    private $parseString;
    //Determina a quantidade de linhas.
    private $rows;
    //Link da pagina
    private $link;
    //Primeira pagina
    private $first;
    private $last;
    //Maximo de link por pagina
    private $maxlinks;
    //renderiza a paginacão.
    private $paginator;

    function __construct($link, $first = null, $last = null, $maxlinks = null) {
        $this->link = (string) $link;
        $this->first = ((string) $first ? $first : '<<');
        $this->last = ((string) $last ? $last : '>>');
        $this->maxlinks = ((int) $maxlinks ? $maxlinks : 5);
    }

    //Pega a pagina atual ou seja o valor, e a quantidade de resultados por pagina.
    public function pagina($atual, $limit) {
        $this->page = ((int) $atual ? $atual : 1);
        $this->limit = $limit;
        $this->offset = ($this->page * $this->limit) - $this->limit;
    }

    public function paginacao($tabela, $termos = null, $parseString = null) {
        $this->tabela = $tabela;
        $this->termos = $termos;
        $this->parseString = $parseString;
        $this->sintax();
    }

    public function paginator() {
        return $this->paginator;
    }

    public function retornaPagina() {
        if ($this->page > 1):
            $numPaginas = ($this->page - 1);
            header("Location: {$this->link}{$numPaginas}");
        endif;
    }

    function getPage() {
        return $this->page;
    }

    function getLimit() {
        return $this->limit;
    }

    function getOffset() {
        return $this->offset;
    }

    function getRows() {
        return $this->rows;
    }

    private function sintax() {
        $readPaginas = new read();
        $readPaginas->ExeRead($this->tabela, $this->termos, $this->parseString);
        $this->rows = $readPaginas->getRowCount();
        if ($this->rows > $this->limit):
            //Definindo as paginas.
            $paginas = ceil($this->rows / $this->limit);
            $maxlinks = $this->maxlinks;
            //HTML
            $this->paginator = '<ul class="pagination" style="margin-left: 20px; float: left; clear: both">'; //Abri a paginacao
            $this->paginator .= "<li><a title=\"{$this->first}\" href=\"{$this->link}1\">{$this->first}</a></li>"; //PRIMEIRA PAG
            for ($ipag = $this->page - $maxlinks; $ipag <= $this->page - 1; $ipag ++):
                if ($ipag >= 1)://So exibe os numero positivos.
                    $this->paginator .= "<li><a title=\"Pagina {$ipag}\" href=\"{$this->link}{$ipag}\">{$ipag}</a></li>";
                endif;
            endfor;
            $this->paginator .= "<li class=\"active\"><span>{$this->page}</span></li>"; //PAGINA ATUAL. 
            for ($dpag = $this->page + 1; $dpag <= $this->page + $maxlinks; $dpag ++):
                if ($dpag <= $paginas):
                    $this->paginator .= "<li><a title=\"Pagina {$dpag}\" href=\"{$this->link}{$dpag}\">{$dpag}</a></li>";
                endif;
            endfor;
            $this->paginator .= "<li><a title=\"{$this->last}\" href=\"{$this->link}{$paginas}\">{$this->last}</a></li>"; //ULTIMA PAG.
            $this->paginator .= '</ul>'; //Fecha a paginaçao
        endif;
    }

}
