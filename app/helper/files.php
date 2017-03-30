<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require '../../../../revisao/uploads/';
/**
 * Description of files
 *
 * @author edson
 */
class files {

    //Imagem
    private $file;
    private $nome;
    private $caminho;
    private $width;
    private $imagem;
    //Rsults
    private $resultado;
    private $erro;
    //Diretorios
    private $folder;
    private $dirBase;

    function __construct($dirBase = null) {
        //Se nenhum diretorio for informado, a pasta uploads sera criada.
        $this->dirBase = ((string) $dirBase ? $dirBase : '../uploads/'); //Não esquecer da / no final.
        if (!file_exists($this->dirBase) && !is_dir($this->dirBase)):
            mkdir($this->dirBase, 0777); //Cria o diretorio
        endif;
    }

    function getResultado() {
        return $this->resultado;
    }

    function getErro() {
        return $this->erro;
    }

    //Metodo envio de imagens.
    public function enviarImagem(array $imagens, $nome = null, $width = null, $folder = null) {
        $this->file = $imagens;
        $this->nome = ((string) $nome ? $nome : substr($imagens['name'], 0, strrpos($imagens['name'], '.'))); //Pega o nome ate o ponto so.
        $this->width = ((int) $width ? $width : 1366);
        $this->folder = ((string) $folder ? $folder : 'imagens');
        $this->verificaFolder($this->folder);
        $this->setNome();
        if(!$this->file['tmp_name']):
            return false;
        else:
            $this->moveFiles();
        endif;
        
    }

    //Metodo para enviar files;
    public function enviarFiles(array $files, $nome = null, $fold = null, $size = null) {
        $this->file = $files;
        $this->nome = ($nome ? $nome : substr($this->file['name'], 0, strrpos($this->file['name'], '.')));
        $this->folder = ($fold ? $fold : 'files');
        $tamanho = ($size ? $size : 2);

        //Tipo
        $arrTipo = [
            "text/plain",
            "application/pdf",
            "application/msword"
        ];
        //Validação tipo e tamanho. 
        if ($this->file['size'] > $tamanho * (1024 * 1024)):
            $this->erro = ['Tamanho permitido apenas 2mb!', ALERT];
            $this->resultado = false;
        elseif (!in_array($this->file['type'], $arrTipo)):
            $this->erro = ['Apenas tipo de arquivos PDF TXT!', ALERT];
            $this->resultado = false;
        else:
            $this->verificaFolder($this->folder);
            $this->setNome();
            $this->moveFiles();
        endif;
    }

    //Metodo para enviar files;
    public function enviarMidias(array $files, $nome = null, $fold = null, $size = null) {
        $this->file = $files;
        $this->nome = ($nome ? $nome : substr($this->file['name'], 0, strrpos($this->file['name'], '.')));
        $this->folder = ($fold ? $fold : 'midias');
        $tamanho = ($size ? $size : 40);

        //Tipo
        $arrTipo = [
            "audio/mp3",
            "video/mp4",
            "video/x-msvideo",
            "video/x-ms-wmv"
        ];
        //Validação tipo e tamanho. 
        if ($this->file['size'] > $tamanho * (1024 * 1024)):
            $this->erro = ['Tamanho permitido apenas 40mb!', ALERT];
            $this->resultado = false;
        elseif (!in_array($this->file['type'], $arrTipo)):
            $this->erro = ['Apenas tipo de midias MP3 MP4 AVI WMV!', ALERT];
            $this->resultado = false;
        else:
            $this->verificaFolder($this->folder);
            $this->setNome();
            $this->moveFiles();
        endif;
    }

    //Verifica os folders, e cria se não existir.
    private function verificaFolder($folder) {
        //Pega o ano e o mes e joga nos indecis da list.
        list($y, $m) = explode('/', date('Y/m'));
        $this->criaFolders("{$folder}");
        $this->criaFolders("{$folder}/{$y}/");
        $this->criaFolders("{$folder}/{$y}/{$m}/");
        $this->caminho = "{$folder}/{$y}/{$m}/";
    }

    //Cria folders.
    private function criaFolders($folder) {
        if (!file_exists($this->dirBase . $folder) && !is_dir($this->dirBase . $folder)):
            mkdir($this->dirBase . $folder, 0777); //Cria o folder, dentro da uploads.
        endif;
    }

    //seta o nome.
    private function setNome() {
        $filename = $this->nome . strrchr($this->file['name'], '.'); //Pega o nome, e implementa a extenção .php.
        if (file_exists($this->dirBase . $this->caminho . $filename)):
            $filename = $this->nome . '-' . time() . strrchr($this->file['name'], '.'); //Pega o nome, se for o mesmo adiciona o time.
        endif;
        $this->nome = $filename;
    }

    //Envia o file da pasta tmpname.
    private function moveFiles() {
        if (!empty($this->file)):
            move_uploaded_file($this->file['tmp_name'], $this->dirBase . $this->caminho . $this->nome);
            $this->resultado = true;
            $this->erro = ['Enviado com sucesso!', SUCCESS];
        else:
            $this->resultado = false;
        endif;
    }

}
