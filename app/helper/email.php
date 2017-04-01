<?php

require '../../app/email/class.phpmailer.php';
require '../../app/email/class.smtp.php';

class email {

    /** @var PHPMailer */
    private $mail;
    //Atributos.
    private $dados;
    private $nome_remetente;
    private $email_remetente;
    private $assunto;
    private $mensagem;
    private $nome_destino;
    private $email_destino;
    private $resultado;

    function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->Host = MAILHOST;
        $this->mail->Port = MAILPORT;
        $this->mail->Username = MAILUSER;
        $this->mail->Password = MAILPASS;
    }

    //Recebe os dados do formulario
    public function enviarEmail(array $dados) {
        $this->dados = $dados;
        $this->setClear();
        $this->setDados();
        $this->Config();
        $this->sendEmail();
    }

    //Limpa espaços em branco e tags
    private function setClear() {
        $this->dados = array_map('trim', $this->dados);
        $this->dados = array_map('strip_tags', $this->dados);
    }

    //Set os dados.
    private function setDados() {
        $this->nome_remetente = $this->dados['nome_remetente'];
        $this->email_remetente = $this->dados['email_remetente'];
        $this->nome_destino = $this->dados['nome_destino'];
        $this->email_destino =  $this->dados['email_destino'];
        $this->assunto = $this->dados['assunto'];
        $this->setMsg();
    }

    //Set Mensagem personalizada.
    private function setMsg() {
        $this->mensagem = $this->dados['mensagem_remetente'];
    }

    //Configuração de email.
    private function Config() {
        //SMTP
        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->SMTPAuth = true;

        //REMETENTE E RETORNO.
        $this->mail->From = $this->email_remetente;
        $this->mail->FromName = $this->nome_remetente;
//        $this->mail->addReplyTo($this->email_remetente, $this->nome_remetente);

        //ASSUNTO MSG E DESTINO.
        $this->mail->Subject = $this->assunto;
        $this->mail->Body = $this->mensagem;
        $this->mail->addAddress($this->email_destino, $this->nome_destino);
    }

    private function sendEmail() {
        if ($this->mail->Send()):
            echo 1;
        else:
            echo 2;
        endif;
    }

}
