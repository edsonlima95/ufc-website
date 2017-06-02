<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of view
 *
 * @author Edson Lima
 */
class view {

    private $links;
    private $dados;
    private $template;
    private $valores;

    //Carrega o template.
    public function Load($template) {
        
        $this->template = (string) $template;
        $this->template = file_get_contents($this->template);
        return $this->template;
    }

    //Exibe os resultados.
    public function show(array $dados, $view) {
        $this->setKeys($dados);
        $this->setValores();
        $this->showViews($view);
    }

    //Inclui arquivos inc
    public function Request($file, array $dados) {
        extract($dados);
        require "{$file}.inc.php";
    }

    /* Coloca uma # no inicio e no fim de  cada indice, primeiro transforma em string
      com implode e depois retorna com explode para array com os links montados. */

    private function setKeys($dados) {
        $this->dados = $dados;
        $this->dados['home'] = URL;//Recebe a home com valor.
        $this->links = explode("&", "#" . implode('#&#', array_keys($this->dados)) . "#");
        $this->links[] = "#home#";//Seta o link home para ser substituido;
    }

    //Obtem apenas os valores dos resultados.
    private function setValores() {
        $this->valores = array_values($this->dados);
    }

    private function showViews($view) {
        $this->template = $view;
        //substitui tudo que tiver ## na view pelos valores.
        echo str_replace($this->links, $this->valores, $this->template);
    }

}
