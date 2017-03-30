<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contar
 *
 * @author Edson Lima
 */
class contar {

    private $id;
    private $view;

   
    public function contaViews($id) {
        $this->id = $id;
        if(!isset($_COOKIE['teste'])):
            $this->verficaViews();
            $this->setCookie();
        endif;
        
    }

    private function verficaViews() {
        $readPostViews = new read();
        $readPostViews->ExeRead('posts', "WHERE id = :id", "id={$this->id}");
        if ($readPostViews->getResultado()[0]['post_views']):
            $this->view['post_views'] = $readPostViews->getResultado()[0]['post_views'] + 1;
            $this->updateViews();
        else:
            $this->view['post_views'] = 1;
            $this->updateViews();
        endif;
    }
    
    private function setCookie() {
         setcookie('teste','usuario_on', time() + 3600);
    }

    private function updateViews() {
        $updateViews = new update();
        $updateViews->ExeUpdate('posts', $this->view, "WHERE id = :id", "id={$this->id}");
    }

}
