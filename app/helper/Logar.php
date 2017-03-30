<?php

class Logar {

    private $email;
    private $senha;
    private $level;
    private $erro;
    private $resultado;

    function __construct() {
        session_start();
    }

    function getResultado() {
        return $this->resultado;
    }

    function getErro() {
        return $this->erro;
    }

    public function levelAccess($level) {
        $this->level = $level;
    }

    //Recebe o email e a senha.
    public function login($email, $senha) {
        $this->email = $email;
        $this->senha = $senha;
        $this->setLogin();
    }
    
    //Recuperar senha.
    public function recuperarSenha(array $dados) {
        $readUsuario = new read();
        $readUsuario->ExeRead('users',"WHERE email = :email","email={$dados['email_destino']}");
        if(!isset($readUsuario->getResultado()[0])):
            $this->resultado = false;
        else:
            $this->resultado = $readUsuario->getResultado()[0];
        endif;
    }

    //Verifica na tabela, se contem algum usuario correspondente ao email e senha informado.
    //users',"WHERE email = '$this->email' AND password = '$this->senha'
    private function checkUsers() {
        $readUsers = new read();
        $readUsers->ExeRead('users',"WHERE email = :email AND token = :senha","email={$this->email}&senha={$this->senha}");
        if ($readUsers->getResultado()):
            $this->resultado = $readUsers->getResultado()[0];
            return true;
        else:
            return false;
        endif;
    }

    //Verifica as condicoes.
    private function setLogin() {
        if ($this->email == '' || $this->senha == ''):
            $this->erro = 1;
            $this->resultado = false;
        elseif (!$this->checkUsers()):
            $this->erro = 2;
            $this->resultado = false;
        elseif ($this->resultado['nivel'] < 1 || $this->resultado['nivel'] > 2):
            $this->erro = 3;
            $this->resultado = false;
        else:
            $this->Executar();
        endif;
    }

    //Verifica se a sessao existe.
    public function checkSession() {
        if (empty($_SESSION['user']) || $_SESSION['user']['nivel'] < 1 || $_SESSION['user']['nivel'] > 2):
            unset($_SESSION['user']);
            return false;
        else:
            return true;
        endif;
    }

    private function Executar() {
        if (!session_id()):
            session_start();
        endif;
        $_SESSION['user'] = $this->resultado;
        $this->resultado = true;
    }

}
