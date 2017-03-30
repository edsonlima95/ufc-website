<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Quando não existir a sessao, seta as visitas na tabela site_visitas, e depois cria uma sessao, com a sessao criada,
 * atualiza apenas as visitas na pagina, a quantidade de visita so conta se nao tiver a sessao pois
 * cada sessao e uma visita, e o usuario apenas se nao existir um cookie. 
 *
 * @author edson
 */
class session {

    private $data;
    private $cache;
    private $browser;
    private $trafico;

    //ao chamar a classe ela incial todos os metodos.
    function __construct($cache = null) {
        //incia a sessao ao instanciar a classe.
        session_start();
        //Executa o metodo qe verifica a sessao.
        $this->verificaSessao($cache);
    }

    //Sera executado ao instanciar a classe atraves do construtor.
    private function verificaSessao($cache = null) {
        $this->data = date('Y-m-d');
        $this->cache = ((int) $cache ? $cache : 20);

        if (empty($_SESSION['usuarioonline'])):
            //seta o trafico se não existir a sessao.
            $this->setTrafico();
            //Seta a sessao.
            $this->setSessao();
            //browser.
            $this->verificaBrowser();
            //Seto no banco a sessao.
            $this->setSessaoTabela();
            //Atualiza as visitas do browser.
            $this->atualizaBrowser();
        else:
            //Atualiza as visitas da pagina apenas.
            $this->atualizaTrafico();
            //Atualiza a sessao, apenas o fim data, e a url.
            $this->atualizaSessao();
            //browser.
            $this->verificaBrowser();
            //inseri o fim da sessao e a url no banco
            $this->setAtualizacaoSessao();
        endif;
        //apenas nesse metodo a data e null, pois nao vou usar o valor dela aqui.
        $this->data = null;
    }

    //Seta a sessao, caso nao exista.
    private function setSessao() {
        $_SESSION['usuarioonline'] = [
            "sessao_online" => session_id(), //ip da sessao.
            "inicio_sessao" => date('Y-m-d H:i:s'), //Data de inicio
            "fim_sessao" => date('Y-m-d H:i:s', strtotime("+{$this->cache}minutes")), //soma os 20 minutos do cache, com a hora que inicia.
            "ip_online" => filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT), //ip da maquina.
            "url_online" => filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT), //url de acesso
            "agente_online" => filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_DEFAULT), //browser
        ];
    }

    //Atualiza a sessao, apenas dois campos.
    private function atualizaSessao() {
        $_SESSION['usuarioonline']['fim_sessao'] = date('Y-m-d H:i:s', strtotime("+{$this->cache}minutes"));
        $_SESSION['usuarioonline']['url_online'] = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
    }

    //verifica se á dados na tabela site_visita pela data.
    private function verificaTrafico() {
        $readTrafico = new read();
        $readTrafico->ExeRead('site_visitas', "WHERE data_visitas = :data_visitas", "data_visitas={$this->data}");
        //Se existir dados retorna o primeiro resultado.
        if ($readTrafico->getResultado()):
            $this->trafico = $readTrafico->getResultado()[0];
        endif;
    }

    //inseri o primeiro trafico na tabela se não existir ainda.
    private function setTrafico() {
        $this->verificaTrafico(); //verifica primeiro, se existir dados na tabela.
        if (!$this->trafico)://se nao retornou resultados, seta os valores da primeira visita.
            $arrTrafico = [
                "data_visitas" => $this->data,
                "visitas_usuarios" => 1,
                "quan_visitas" => 1,
                "visitas_paginas" => 1,
            ];
            //inseri na tabela.
            $createTrafico = new create();
            $createTrafico->ExeCreate('site_visitas', $arrTrafico);
        else:
            //Se nao existir um usuario.
            if (!$this->verificaCookie()):
                //atualiza, o usuario, visitas, paginas. pq nao tem o usuario ou ele expirou.
                $arrTrafico = ["visitas_usuarios" => $this->trafico['visitas_usuarios'] + 1,
                    "quan_visitas" => $this->trafico['quan_visitas'] + 1,
                    "visitas_paginas" => $this->trafico['visitas_paginas'] + 1,
                ];
            else:
                //Atualiza apenas a visita, paginas. pq exisite o usuario.
                $arrTrafico = ["quan_visitas" => $this->trafico['quan_visitas'] + 1,
                    "visitas_paginas" => $this->trafico['visitas_paginas'] + 1
                ];
            endif;
            //Atualiza na tabela.
            $update = new update();
            $update->ExeUpdate('site_visitas', $arrTrafico, "WHERE data_visitas = :data_visitas", "data_visitas={$this->data}");
        endif;
    }

    //Atualiza o trafico, apenas a visitas na pagina.
    private function atualizaTrafico() {
        $this->verificaTrafico(); //Verifica se a dados na tabela, para poder atualizar
        $arrTrafico = ["visitas_paginas" => $this->trafico['visitas_paginas'] + 1];
        //Atualiza na tabela.
        $update = new update();
        $update->ExeUpdate('site_visitas', $arrTrafico, "WHERE data_visitas = :data_visitas", "data_visitas={$this->data}");
        //limpa da memoria.
        $this->trafico = null;
    }

    //verifica o cookie do usuario.
    private function verificaCookie() {
        //Verifica se existe o cookie criado
        $cookie = filter_input(INPUT_COOKIE, 'usuarioonline', FILTER_DEFAULT);
        //cria o cookie se não existir.
        setcookie('usuarioonline', base64_encode('upinside'), time() + 86400); //time de um dia, quando ele nao existir mais, cont mais uma visita de usuario
        if (!$cookie):
            return false;
        else:
            return true;
        endif;
    }

    //verificar o browser.
    private function verificaBrowser() {
        //pega o browser na sessao.
        $this->browser = $_SESSION['usuarioonline']['agente_online'];
        //verifica se exixte a palavra na string agente_online.
        if (strpos($this->browser, 'Chromium')):
            $this->browser = 'Chromium';
        elseif (strpos($this->browser, 'Chrome')):
            $this->browser = 'Chrome';
        elseif (strpos($this->browser, 'Firefox')):
            $this->browser = 'Firefox';
        elseif (strpos($this->browser, 'Trident/') || (strpos($this->browser, 'MSIE'))):
            $this->browser = 'Chromium';
        else:
            $this->trafico = 'Outros';
        endif;
    }

    //Atualiza o browser e as visitas, caso  nao exista.
    private function atualizaBrowser() {
        //faz a leitura para verificar se existe dados da tabela.
        $browser = new read();
        $browser->ExeRead('site_browsers', "WHERE nome_browser = :nome_browser", "nome_browser={$this->browser}");
        if (!$browser->getResultado()):
            //Se nao existir os valores na tabela seta
            $arrbrowser = ["nome_browser" => $this->browser, "visitas_browser" => 1];
            $createBrowser = new create();
            $createBrowser->ExeCreate('site_browsers', $arrbrowser);
        else:
            //Apenas atualiza apenas as visitas
            $arrbrowserupdate = ["visitas_browser" => $browser->getResultado()[0]['visitas_browser'] + 1];
            $updateBrowser = new update();
            $updateBrowser->ExeUpdate('site_browsers', $arrbrowserupdate, "WHERE nome_browser = :nome_browser", "nome_browser={$this->browser}");
        endif;
    }

    //Cadastra a sessao de usuario na tabela site_online.
    private function setSessaoTabela() {
        $sessaoOnline = $_SESSION['usuarioonline'];
        $sessaoOnline['browser'] = $this->browser;

        $createUsuario = new create();
        $createUsuario->ExeCreate('site_online', $sessaoOnline);
    }

    //Cadastra a atualização da sessao, fim sessao e url no banco.
    private function setAtualizacaoSessao() {
        $arrAtualizarSessao = ["fim_sessao" => $_SESSION['usuarioonline']['fim_sessao'],
            "url_online" => $_SESSION['usuarioonline']['url_online']
        ];
        $id = $_SESSION['usuarioonline']['sessao_online'];
        $updateSessao = new update();
        $updateSessao->ExeUpdate('site_online', $arrAtualizarSessao, "WHERE sessao_online = :sessao_online", "sessao_online={$id}");
    }

}
