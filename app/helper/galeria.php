<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelGaleria
 *
 * @author Edson Lima
 */
class galeria {

    private $dados;
    private $id;

    //ENVIA A GALERIA DE IMAGENS.
    public function enviarGaleria(array $imagens, $postid) {
        $this->dados = $imagens;
        $this->id = $postid;

        //Ler na tabela post se existe o id.
        $readPost = new read();
        $readPost->ExeRead('posts', "WHERE id = :id", "id={$this->id}");
        if (!$readPost->getResultado()):
            echo "Você não pode cadastrar a galeria, o post não existe";
        else:
            //Recupera o nome do post.
            $NomeImagem = $readPost->getResultado()[0]['nome'];

            //Monta um array de todos as imagems
            $arrayImagens = array();
            //conta o total de imagens
            $arrayCount = count($this->dados['tmp_name']);
            //Recupera os indecis, tmp_name, size etc.
            $arrayKeys = array_keys($this->dados);

            //Monta o array de imagem, cada imagem com seus indices.
            for ($i = 0; $i < $arrayCount; $i++):
                foreach ($arrayKeys as $key):
                    $arrayImagens[$i][$key] = $this->dados[$key][$i];
                endforeach;
            endfor;

            //Envia as imagens.
            $uploadImagem = new files('../../uploads/');
            $i = 0;
            foreach ($arrayImagens as $upimagens):
                $i++; //Conta as imagens existe, sem o $i os nomes repete.
                $novoNome = "{$this->id}-" . (substr(md5(time() + $i), 0, 5));
                //Eviar as imagens
                $uploadImagem->enviarImagem($upimagens, $novoNome, 0, 'galeria');

                //Seta os campos, e salva na tabela as imagens.
                if ($uploadImagem->getResultado()):
                    $nome = $uploadImagem->getResultado();
                    $arrayDados = [
                        "id_post" => $this->id,
                        "imagem" => $nome,
                        "data_creacao" => date('Y-m-d H:i:s')
                    ];
                    $createGaleria = new create();
                    $createGaleria->ExeCreate('imagens', $arrayDados);
                endif;
            endforeach;
        endif;
    }

    //Deleta a categoria pelo id informado.
    public function deleteGaleria($id) {
        $this->id = $id;
        $readGaleri = new read();
        $readGaleri->ExeRead('imagens', "WHERE id_post = :id", "id={$this->id}");
        if ($readGaleri->getResultado()):
            //Deleta as imagens da pasta.
            foreach ($readGaleri->getResultado() as $delg):
                $nome = '../../uploads/' . $delg['imagem'];
                if (file_exists($nome) && !is_dir($nome)):
                    unlink($nome);
                endif;
            endforeach;

            $delete = new delete();
            $delete->ExeDelete('imagens', "WHERE id_post = :id", "id={$this->id}");
            if ($delete->getResultado()):
                return true;
            endif;
        endif;
    }

}
