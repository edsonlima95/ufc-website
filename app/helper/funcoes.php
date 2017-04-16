<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funcoes.
 *
 * @author edson
 */
class funcoes {

    public static $formato;
    public static $dados;

    //validação de string e url amigavel.
    public static function Name($nome) {
        self::$formato = array();
        self::$formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        self::$dados = strtr(utf8_decode($nome), utf8_decode(self::$formato['a']), self::$formato['b']); //elimina as acentuaçoes e passa do formato A para o B;
        self::$dados = strip_tags(trim(self::$dados)); //elimina tags html.
        self::$dados = str_replace(' ', '-', self::$dados);
        self::$dados = str_replace(array('-----', '----', '---', '--'), '-', self::$dados); //se houver mais de um traço ele substitui por apenas 1.

        return strtolower(utf8_encode(self::$dados));
    }

    //Transforma a data padrao timestap para a o padrao normal.
    public static function validaData($data) {
        self::$formato = explode(' ', $data);
        self::$dados = explode('/', self::$formato[0]);
        if (empty(self::$formato[1])):
            self::$formato[1] = date('H:i:s');
        endif;

        return self::$dados[2] . '-' . self::$dados[1] . '-' . self::$dados[0] . ' ' . self::$formato[1];
    }

    //Limta o numero de palavras no texto
    public static function limtarTextos($string, $limite) {
        $string = strip_tags($string);
        $numWords = strlen($string);
        self::$dados = substr($string, 0, $limite);
        self::$formato = strrpos(self::$dados, ' ');
        $texoCompleto = substr(self::$dados, 0, self::$formato);
        $res = ($limite < $numWords ? $texoCompleto : $string);
        return $res;
    }

    // pega o id da categoria informada.
    public static function categoriaNome($nome) {
        $novo = strtolower($nome);
        $read = new read();
        $read->ExeRead('categories', "WHERE nome = :nome", "nome={$novo}");
        if ($read->getResultado()):
            return $read->getResultado()[0]['id'];
        else:
            echo "Nenhuma categoria encontrada com o nome <strong>{$nome}</strong>";
        endif;
    }

    //Deleta os usuarios apartir de uma data.
    public static function deltetaUsuarios($data) {
        $data = explode('/', $data);
        $dataStamp = $data[2] . '-' . $data[1] . '-' . $data[0];
        $dataFinal = $dataStamp;
        $delete = new delete();
        $delete->ExeDelete('site_online', "WHERE fim_sessao = :fimsessao", "fimsessao={$dataFinal}");
        if ($delete->getResultado()):
            echo 'Usuarios deletados com sucesso';
        endif;
    }

    //Redireciona imagens.
    public static function redirecionaImagem($nomeImagem, $descricao, $widht = null, $height = null, $caminho = null) {
        self::$dados = (empty($caminho) ? 'uploads/imagens/' . $nomeImagem : $caminho . $nomeImagem);
        if (file_exists(self::$dados) && !is_dir(self::$dados)):
            $url = 'http://localhost/cidadeonline/';
            $caminho = self::$dados;
            $imagem = $caminho;
            return "<img src=\"{$url}/tim.php?src={$imagem}&w={$widht}&h={$height}\" alt=\"{$descricao}\" title=\"{$descricao}\">";
        endif;
    }

    //Metodo com o padrao front-controller.
    public static function frontController($http) {
        if (!empty($http)):
            $caminho = __DIR__ . DIRECTORY_SEPARATOR . '../../admin' . DIRECTORY_SEPARATOR . strip_tags(trim($http) . '.php');
        else:
            $caminho = __DIR__ . DIRECTORY_SEPARATOR . '../../admin' . DIRECTORY_SEPARATOR . 'sis/home.php';
        endif;

        if (file_exists($caminho)):
            require_once ($caminho);
        else:
            $caminho = __DIR__ . DIRECTORY_SEPARATOR . '../../admin' . DIRECTORY_SEPARATOR . 'sis/404.php';
            require_once ($caminho);
        endif;
    }

    //Funcao de acesso ao super usuario.
    public static function superUser($nivel = null) {
        self::$dados = (!empty($nivel) ? $nivel : 1);
        if ($_SESSION['user']['nivel'] != self::$dados):
            header('Location: dashboard.php?exe=sis/403');
        endif;
    }

    //Fucao para contar a soma das visitas do site
    public static function somaTrafico($coluna, $tabela) {
        $read = new read();
        //Soma todas as visitas do campo.
        $read->executeQuery("SELECT SUM({$coluna}) AS visitas FROM {$tabela}");
        return $soma = $read->getResultado()[0]['visitas'];
    }

}
