<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of link
 *
 * @author Edson Lima
 */
class link {

    
    private $file;
    private $link;
    private $url;
    private $path;
    private $tags;
    private $dados;
    
    /** @var seo **/
    private $seo;
    
    function __construct() {
        //Obetem a url amigavel do site.
        $this->url = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
        //obtem o arquivo passado pela url. se nao tiver nenhum seta o index.
        $this->url = ($this->url ? $this->url : 'index');
        //Divide a url em array para seta o arquivo e o nome do arquivo.
        $this->url = explode('/', $this->url);
        $this->file = (isset($this->url[0]) ? $this->url[0] : 'index');
        $this->link = (isset($this->url[1]) ? $this->url[1] : null);      
        //Instancia o objeto ja no incio da classe, assim evita instaciar varias vezes
        $this->seo = new seo($this->file, $this->link);
    }

    //Obtem as tags do SEO
    public function getTags() {
        $this->tags = $this->seo->getTags();
        echo $this->tags;
    }

    //Obetem os dados ou seja os resultados.
    public function getDados() {
        $this->dados = $this->seo->getDados();
        return $this->dados;
    }

    //Obtem o arquivo e o nome.
    public function getLocal() {
        return $this->url;
    }

    //Obtem o caminho do arquivo.
    public function getPath() {
        $this->setPath();
        return $this->path;
    }

    //Verifica se o arquivo existe e faz a inclusão.
    private function setPath() {
        if (file_exists(REQUIRE_PATH . DIRECTORY_SEPARATOR . $this->file . '.php')):
            //Inclue o arquivo direto da view.
            $this->path = REQUIRE_PATH . DIRECTORY_SEPARATOR . $this->file . '.php';
        elseif (file_exists(REQUIRE_PATH . DIRECTORY_SEPARATOR . $this->file .DIRECTORY_SEPARATOR. $this->link . '.php')):
            //Inclue o arquivo de uma pasta detro da view.
            $this->path = REQUIRE_PATH . DIRECTORY_SEPARATOR . $this->file .DIRECTORY_SEPARATOR. $this->link . '.php';
        else:
            $this->path = REQUIRE_PATH .DIRECTORY_SEPARATOR .'404.php';
        endif;
    }

}
