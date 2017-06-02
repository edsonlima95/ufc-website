<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of update
 *
 * @author Edson Lima
 */
class update extends conn {

    private $tabela;
    private $dados;
    private $condicao;
    private $parseString;
    private $resultado;

    /** @var PDOStatement Description */
    private $update;

    /** @var PDO Description */
    private $conn;
    
    //Recebe os dados.
    public function ExeUpdate($tabela, array $dados, $condicao, $parseString) {
        $this->tabela = $tabela;
        $this->dados = $dados;
        $this->condicao = $condicao;
        parse_str($parseString, $this->parseString);
        $this->getSintaxe();
        $this->execute();
    }

    public function getResultado() {
        return $this->resultado;
    }
    
    public function setPlaces($parseString) {
        parse_str($parseString, $this->parseString);
        $this->getSintaxe();
        $this->execute();
    }
    //Faz a conexao, e prepara a query.
    private function getConn() {
        $this->conn = parent::Conn();
        $this->update = $this->conn->prepare($this->update);
    }
    //Sintaxe, query update
    private function getSintaxe() {
        foreach ($this->dados as $indices => $valores):
            $places[] = $indices . " = :" . $indices;
        endforeach;
        $places = implode(', ', $places);
        $this->update = "UPDATE {$this->tabela} SET {$places} {$this->condicao}";
    }
    //Executa tudo.
    private function execute() {
        $this->getConn();
        try {
            $this->update->execute(array_merge($this->dados, $this->parseString));
            $this->resultado = true;
        } catch (PDOException $e) {
            $this->resultado = null;
            echo "<span style=\"color:red; font-weight: bold\">Erro ao tentar atualizar -></span> <strong>{$e->getMessage()}</strong>, "
            . "linha <strong>{$e->getLine()}</strong> arquivo <strong>{$e->getFile()}</strong>";
        }
        }

}
