<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of read
 *
 * @author Edson Lima
 */
class read extends conn {

    private $resultado;
    private $valoresParse;
    private $select;

    /** @var PDOStatement */
    private $read;

    /** @var PDO */
    private $conn;

    //Recebe os dados.
    public function ExeRead($tabela, $cond = null, $parseString = null) {
        if (!empty($parseString)):
            parse_str($parseString, $this->valoresParse);
        endif;
        $this->select = "SELECT * FROM {$tabela} {$cond}";
        $this->execute();
    }

    //Retorna um array com todos os resultados.
    public function getResultado() {
        return $this->resultado;
    }

    //Conta o numero de linhas.
    public function getRowCount() {
        return $this->read->rowCount();
    }

    //Seta os places.
    public function setPlaces($parseString) {
        parse_str($parseString, $this->valoresParse);
        $this->execute();
    }

    //Exeecuta uma query completa.
    public function executeQuery($query, $parseString = null) {
        $this->select = $query;
        if (!empty($parseString)):
            parse_str($parseString, $this->valoresParse);
        endif;
        $this->execute();
    }

    //Faz a conecxao, e prepara a query.
    private function getConn() {
        $this->conn = parent::Conn();
        $this->read = $this->conn->prepare($this->select);
        $this->read->setFetchMode(PDO::FETCH_ASSOC);
    }

    //Verifica se o limit e offset e string e converte para int.
    private function getSintaxe() {
        if ($this->valoresParse):
            foreach ($this->valoresParse as $indices => $valores):
                if ($indices == 'limit' || $indices == 'offset'):
                    $valores = (int) $valores;
                endif;
                $this->read->bindValue(":{$indices}", $valores, (is_int($valores) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;

    }

    //Executa
    private function execute() {
        $this->getConn();
        try {
            $this->getSintaxe();
            $this->read->execute();
            $this->resultado = $this->read->fetchAll();
        } catch (PDOException $e) {
            $this->resultado = null;
            echo "<span style=\"color:red; font-weight: bold\">Erro ao tentar ler -></span> <strong>{$e->getMessage()}</strong>, "
            . "linha <strong>{$e->getLine()}</strong> arquivo <strong>{$e->getFile()}</strong>";
        }
    }

}
