<?php

class conn {

    private static $host = 'localhost';
    private static $user = 'root';
    private static $password = '';
    private static $db = 'projquery';
    /** @var PDO tenho que informa que e uma var tipo PDO se nao, ele nao reconhece*/
    private static $conexao = null;

    public static function conexao() {
        try {
            if (self::$conexao == null):
                $dsn = 'mysql:host='.self::$host.';dbname='.self::$db;
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"];
                self::$conexao = new PDO($dsn, self::$user, self::$password, $options);
            endif;
            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$conexao;
            
        } catch (PDOException $e) {
            echo 'Erro ao tentar conectar' . $e->getMessage();
        }
    }
    public function Conn() {
        return self::conexao();
    }

}
