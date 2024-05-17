<?php

class Core_Model_Mail
{
    private $mail1;
    private $mail2;
    private $mail3;

    public function __construct()
    {
        $informacionModel = new Page_Model_DbTable_Informacion();
        $informacion = $informacionModel->getList("", "orden ASC")[0];

        $this->mail1 = $this->initializeMailer("tls",$informacion->info_pagina_host, $informacion->info_pagina_port, $informacion->info_pagina_username, $informacion->info_pagina_password, $informacion->info_pagina_correo_remitente, $informacion->info_pagina_nombre_remitente);

        // Configuración de correo 2
        // Asegúrate de obtener la información necesaria para la segunda configuración de correo
        $host2 = "smtp.gmail.com";
        $port2 = 465;
        $username2 = "contactowebfoe@gmail.com";
        $password2 = "Foebbva2017";
        $correo_remitente2 = "tiendavirtualfoe@foebbva.com";
        $nombre_remitente2 = "TIENDA VIRTUAL FOE";
        $this->mail2 = $this->initializeMailer("ssl", $host2, $port2, $username2, $password2, $correo_remitente2, $nombre_remitente2);

        // Configuración de correo 3
        // Asegúrate de obtener la información necesaria para la tercera configuración de correo
        $host3 = "foe.omegasolucionesweb.com";
        $port3 = 465;
        $username3 = "contactowebfoe@gmail.com";
        $password3 = "Admin.2008";
        $correo_remitente3 = "tiendavirtualfoe@foebbva.com";
        $nombre_remitente3 = "TIENDA VIRTUAL FOE";
        $this->mail3 = $this->initializeMailer("ssl", $host3, $port3, $username3, $password3, $correo_remitente3, $nombre_remitente3);
    }

    private function initializeMailer($secure, $host, $port, $username, $password, $correo_remitente, $nombre_remitente)
    {
        echo $host;
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPSecure = $secure;
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->setFrom($correo_remitente, $nombre_remitente);
        return $mail;
    }

    public function getMail()
    {
        return $this->mail1;
    }

    public function sed()
    {
        $mails = array($this->mail1, $this->mail2, $this->mail3);

        foreach ($mails as $mail) {
            if ($mail->send()) {
                return true; // Si el correo se envió exitosamente, retorna verdadero
            }
        }

        return false; // Si ninguno de los correos se pudo enviar, retorna falso
    }
}
