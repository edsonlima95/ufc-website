<?php

/* * ***************************
  FUNCÇÃO DO PRO PHP
  FAZ A NAVEGAÇÃO AMIGÁVEL
 * *************************** */

function getHome() {
    $url = $_GET['url'];
    $url = explode('/', $url);
    $url[0] = ($url[0] == NULL ? 'index' : $url[0]);

    if (file_exists('tpl/' . $url[0] . '.php')) {
        require_once('tpl/' . $url[0] . '.php');
    } elseif (file_exists('tpl/' . $url[0] . '/' . $url[1] . '.php')) {
        require_once('tpl/' . $url[0] . '/' . $url[1] . '.php');
    } else {
        require_once('tpl/404.php');
    }
}

/* * ***************************
  FUNCÇÃO DO PRO PHP
  INCLUE ARQUIVOS
 * *************************** */

function setArq($nomeArquivo) {
    if (file_exists($nomeArquivo . '.php')) {
        include($nomeArquivo . '.php');
    } else {
        echo 'Erro ao incluir <strong>' . $nomeArquivo . '.php</strong>, arquivo ou caminho não conferem!';
    }
}

/* * ***************************
  FUNCÇÃO DO PRO PHP
  SETA URL DA HOME
 * *************************** */

function setHome() {
    echo BASE;
}

/* * ***************************
  FUNCÇÃO DO PRO PHP
  GERA RESUMOS
 * *************************** */

function lmWord($string, $words = '100') {
    $string = strip_tags($string);
    $count = strlen($string);

    if ($count <= $words) {
        return $string;
    } else {
        $strpos = strrpos(substr($string, 0, $words), ' ');
        return substr($string, 0, $strpos) . '...';
    }
}

/* * ***************************
  TRANFORMA STRING EM URL
  FUNCÇÃO DO PRO PHP
 * *************************** */

function setUri($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b);
    $string = strip_tags(trim($string));
    $string = str_replace(" ", "-", $string);
    $string = str_replace(array("-----", "----", "---", "--"), "-", $string);
    return strtolower(utf8_encode($string));
}

/* * ***************************
  SOMA VISITAS
 * *************************** */

function setViews($topicoId) {
    $topicoId = mysql_real_escape_string($topicoId);
    $readArtigo = read('up_posts', "WHERE id = '$topicoId'");

    foreach ($readArtigo as $artigo)
        ;
    $views = $artigo['visitas'];
    $views = $views + 1;
    $dataViews = array(
        'visitas' => $views
    );
    update('up_posts', $dataViews, "id = '$topicoId'");
}

function getSeo() {
    //IMAGEM
$metaImage = ($metaImage != '' ? BASE.'/uploads/'.$metaImage : BASE.'/tpl/images/siteavatar.png');

//SEO
$metaInfo = array(
	'title' 		=> SITENAME,
	'description' 	=> SITEDESC,
	'url' 			=> BASE,
	'image'			 => $metaImage
);

//NORMAL PAGE
echo '<title>'.lmWord($metaInfo['title'],'70').'</title> ';
echo '<meta name="description" content="'.lmWord($metaInfo['description'],'160').'"/>';

//FACEBOOK
echo '<meta property="og:title" content="'.$metaInfo['title'].'" />';
echo '<meta property="og:url" content="'.$metaInfo['url'].'" />';
echo '<meta property="og:image" content="'.$metaInfo['image'].'" />';
echo '<meta property="og:site_name" content="'.SITENAME.'" />';
echo '<meta property="og:description" content="'.$metaInfo['description'].'" />';
echo '<meta property="og:locale" content="pt_BR" />';

//ITEM GROUP (TWITTER)
echo '<meta itemprop="name" content="'.$metaInfo['title'].'">';
echo '<meta itemprop="description" content="'.$metaInfo['description'].'">';
echo '<meta itemprop="url" content="'.$metaInfo['url'].'">';

//ROBOS AND FALLOW
echo '<meta name="robots" content="index, follow" />';
echo '<link rel="canonical" href="'.$metaInfo['url'].'">';
}
