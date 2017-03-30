<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of seo
 *
 * @author Edson Lima
 */
class seo {

    private $link;
    private $dados;
    private $file;
    private $tags;
    //Dados povoados.
    private $seoTags;
    private $seoDados;

    function __construct($file, $link) {
        $this->file = strip_tags(trim($file));
        $this->link = strip_tags(trim($link));
    }

    //Pega as tags do seo, descricão, autor, titulo etc.
    public function getTags() {
        $this->checkDados();
        return $this->seoTags;
    }

    //Obetem os dados do banco de dados.
    public function getDados() {
        $this->checkDados();
        return $this->seoDados;
    }

    //Verifica os dados no banco de acordo com o arquivo e link pelo getSeo.
    private function checkDados() {
        if (!$this->seoDados):
            $this->getSeo();
        endif;
    }

    private function getSeo() {
        $readSeo = new read();
        //Verifica pelo arquivo passado.
        switch ($this->file):
            case 'artigo':
                //Verifica o usuario se e um admin ou tem nivel de acesso.
                $admin = (isset($_SESSION['user']['nivel']) && $_SESSION['user']['nivel'] == 1);
                //Se não for admin o post tem que ta ativo.
                $check = ($admin ? '' : 'status = 1 AND');

                //Verfica o post pelo link
                $readSeo->ExeRead('posts', "WHERE {$check} nome = :link", "link={$this->link}");
                if (!$readSeo->getResultado()):
                    $this->seoTags = null;
                    $this->seoDados = null;
                else:
                    extract($readSeo->getResultado()[0]);

                    //Recebe o resultado do banco.
                    $this->seoDados = $readSeo->getResultado()[0];

                    //Seta os valores no setTags caso exista o artigo.
                    $this->dados = [$titulo . SITENOME, $conteudo, "http://localhost/cidadeonline/artigo/{$nome}", "'http://localhost/cidadeonline/view/img/site.png'"];

                    //Conta a visita no post.
                    $Countviews = ['post_views' => $post_views + 1];
                    $updateViews = new update();
                    $updateViews->ExeUpdate('posts', $Countviews, "WHERE id = :id", "id={$id}");
                endif;
                break;
            case 'empresa':
                //Verfica o post pelo link
                $readSeo->ExeRead('app_empresas', "WHERE empresa_name = :link", "link={$this->link}");
                if (!$readSeo->getResultado()):
                    $this->seoTags = null;
                    $this->seoDados = null;
                else:
                    extract($readSeo->getResultado()[0]);

                    //Recebe o resultado do banco.
                    $this->seoDados = $readSeo->getResultado()[0];

                    //Seta os valores no setTags caso exista o artigo.
                    $this->dados = [$empresa_title . SITENOME, $empresa_sobre, "http://localhost/cidadeonline/empresa/{$empresa_name}", "http://localhost/cidadeonline/view/img/site.png"];

                    //Conta a visita na empresa.
                    $Countviews = ['empresa_views' => $empresa_views + 1];
                    $updateViews = new update();
                    $updateViews->ExeUpdate('app_empresas', $Countviews, "WHERE empresa_id = :empresa_id", "empresa_id={$empresa_id}");
                endif;
                break;
            case'categorias':
                //Verfica a categoria pelo link
                $readSeo->ExeRead('categories', "WHERE nome = :link", "link={$this->link}");
                if (!$readSeo->getResultado()):
                    $this->seoTags = null;
                    $this->seoDados = null;
                else:
                    extract($readSeo->getResultado()[0]);

                    //Recebe o resultado do banco.
                    $this->seoDados = $readSeo->getResultado()[0];

                    //Seta os valores no setTags caso exista o artigo.
                    $this->dados = [$titulo . SITENOME, $conteudo, "http://localhost/cidadeonline/categorias/{$nome}", 'http://localhost/cidadeonline/view/img/site.png'];

                    //Conta a visita no post.
                    $Countviews = ['views' => $views + 1];
                    $updateViews = new update();
                    $updateViews->ExeUpdate('categories', $Countviews, "WHERE id = :id", "id={$id}");
                endif;
                break;
            case 'pesquisa';
                //Verfica a categoria pelo link
                $readSeo->ExeRead('posts', "WHERE status = 1 AND (titulo LIKE '%' :link '%' OR conteudo LIKE '%' :link '%')", "link={$this->link}");
                if (!$readSeo->getResultado()):
                    $this->seoTags = null;
                    $this->seoDados = null;
                else:
                    //Cria um indice e recebe a quantidade de resultados.
                    $this->seoDados['count'] = $readSeo->getRowCount();

                    //Seta os valores no setTags caso exista o artigo.
                    $this->dados = ["Pesquisa por: {$this->link} " . SITENOME, "Sua pesquisa por {$this->link} retornou {$this->seoDados['count']} resultados!", "http://localhost/cidadeonline/pesquisa/{$this->link}", 'http://localhost/cidadeonline/view/img/site.png'];
                endif;
                break;
            case 'empresas';
                //Nome vindo da url.
                $nome = ucfirst(str_replace('-', ' ', $this->link));

                //Como não tem uma categoria especifica no banco, então vou criar um indice passar o valor manualmente.
                $this->seoDados = ['empresa_cat' => $nome];

                //Seta os valores no setTags manualmento pois nao contem uma categoria especifica no banco.
                $this->dados = ["Empresas {$this->link}" . SITENOME, 'Empresa no ramo de hospedagens', "http://localhost/cidadeonline/empresas/{$this->link}", 'http://localhost/cidadeonline/view/img/site.png'];

                break;
            case 'index':
                //Se não existir nenhum dos case vai seta esses default no meta.
                $this->dados = [SITENOME . ' Guida de noticias e empreasas', SITEDESC, 'http://localhost/cidadeonline', 'http://localhost/cidadeonline/view/img/site.png'];
                break;
            default :
                $this->dados = ['Opsssss nada encontrado!', ' Guida de noticias e empreasas', SITEDESC, 'http://localhost/cidadeonline/404', 'http://localhost/cidadeonline/view/img/site.png'];
        endswitch;

        //Executa o setTags.
        if ($this->dados):
            $this->setTags();
        endif;
    }

    private function setTags() {
        //Seta as tags de acordo com os resultados setados no $this->dados.
        $this->tags['Title'] = $this->dados[0];
        $this->tags['Content'] = funcoes::limtarTextos(html_entity_decode($this->dados[1]), 25);
        $this->tags['Link'] = $this->dados[2];
        $this->tags['Image'] = $this->dados[3];

        //Limap os dados e espaços em branco.
        $this->tags = array_map('strip_tags', $this->tags);
        $this->tags = array_map('trim', $this->tags);

        //Libera a memoria pois ja foi setada os valores.
        $this->dados = null;

        //NORMAL PAGE
        $this->seoTags = '<title>' . $this->tags['Title'] . '</title> ' . "\n";
        $this->seoTags .= '<meta name="description" content="' . $this->tags['Content'] . '"/>' . "\n";
        $this->seoTags .= '<meta name="robots" content="index, follow" />' . "\n";
        $this->seoTags .= '<link rel="canonical" href="' . $this->tags['Link'] . '">' . "\n";
        $this->seoTags .= "\n";

        //FACEBOOK
        $this->seoTags .= '<meta property="og:site_name" content="' . SITENOME . '" />' . "\n";
        $this->seoTags .= '<meta property="og:locale" content="pt_BR" />' . "\n";
        $this->seoTags .= '<meta property="og:title" content="' . $this->tags['Title'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:description" content="' . $this->tags['Content'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:image" content="' . $this->tags['Image'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:url" content="' . $this->tags['Link'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:type" content="article" />' . "\n";
        $this->seoTags .= "\n";

        //ITEM GROUP (TWITTER)
        $this->seoTags .= '<meta itemprop="name" content="' . $this->tags['Title'] . '">' . "\n";
        $this->seoTags .= '<meta itemprop="description" content="' . $this->tags['Content'] . '">' . "\n";
        $this->seoTags .= '<meta itemprop="url" content="' . $this->tags['Link'] . '">' . "\n";


        //Libera a memoria pois ja foi setada os valores.
        $this->tags = null;
    }

}
