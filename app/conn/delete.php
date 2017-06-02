<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of delete
 *
 * @author Edson Lima
 */
class delete extends conn {

    private $tabela;
    private $condicao;
    private $parseString;
    private $resultado;

    /** @var PDOStatement Description  */
    private $delete;

    /** @var PDO */
    private $conn;

    public function ExeDelete($tabela, $condicao, $parseString) {
        $this->tabela = $tabela;
        $this->condicao = $condicao;
        $this->parseString = $parseString;
        parse_str($parseString, $this->parseString);
        $this->getSintaxe();
        $this->execute();
    }

    //Retorna o resultado.
    public function getResultado() {
        return $this->resultado;
    }

    //Sintaxe delete.
    private function getSintaxe() {
        $this->delete = "DELETE FROM {$this->tabela} {$this->condicao}";
    }

    //Efetua a conxão.
    private function getConn() {
        $this->conn = parent::Conn();
        $this->delete = $this->conn->prepare($this->delete);
    }

    //Executa tudo.
    private function execute() {
        $this->getConn();
        try {
            $this->delete->execute($this->parseString);
            $this->resultado = true;
        } catch (PDOException $e) {
            $this->resultado = null;
            echo "<span style=\"color:red; font-weight: bold\">Erro ao tentar ler -></span> <strong>{$e->getMessage()}</strong>, "
            . "linha <strong>{$e->getLine()}</strong> arquivo <strong>{$e->getFile()}</strong>";
        }
    }

}
