<?php
require_once(LIBRARYS_LOCAL."phpmailer".DS."class.phpmailer.php");
Class ControllerContacto extends ControllerMain{
    private $rutaAbsolutlogo;
    private $maqueta;
    private $mail;
    private $correos;
    private $configurarionphmailer;
    public function __construct(){
        $this->mail = new phpmailer();
        $this->rutaAbsoluta ="http://200.116.1.182:8088/framework_v2/views/template/assets/img/rigo-uran.jpg";
        $this->maqueta ="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
        <html xmlns=\"http://www.w3.org/1999/xhtml\">
        <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
        <title>MAQUETA CONTACTO</title>
        </head>
        <body style =\"background:#CCC; font-family:Arial, Helvetica\">
        <table style=\"margin:0 auto;background:#FFF;text-align:left;border: 1px solid #d1d1d1;color:#888\" width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <td width=\"228\" height=\"70\" style =\"background:#FF4F65;text-align:center;scolor:#FFF;border-bottom: 1px solid #d1d1d1;color:#fff;font-size:20px\">{tipo}</td>
            <td style=\"text-align:center;border-bottom: 1px solid #d1d1d1;\" width=\"226\"><img src=\"http://200.116.1.182:8088/framework_v2/views/template/assets/img/logo-rigo-uran.jpg\"  alt =\"\"/></td>
          </tr>
          <tr>
            <td colspan=\"2\" style=\"text-align:left\">{contenido}</td>
          </tr>
          <tr>
            <td colspan=\"2\" style =\"color:#FF4F65;font-size:12px;text-align:center;  border-top: 1px solid #d1d1d1;\">Tienda Rigoberto Uran – 2015 Todos Los Derechos Reservados</td>
          </tr>
        </table>
        </body>";
       
        $mailRigo[]="juan1387@gmail.com";
        $mailRigo[]="desarrollo@drink.com";
        $this->correos = $mailRigo;
        $this->configurarionphmailer = array ("PluginDir"=>LIBRARYS_LOCAL."phpmailer".DS,
        "Helo"=>"www.drink.com.co",
        "Mailer"=>"smtp",
        "Host"=>"mail.drink.com.co",
        "SMTPAuth"=>true,
        "Username"=>"desarrollo@drink.com.co",
        "Password"=>"23camilo",
        "From"=>"desarrollo@drink.com.co",
        "FromName"=>"Tienda Rigo",
        "Subject"=>"",
        "Timeout"=>30,
        "IsHTML"=>true,
        "CharSet"=>"utf-8",
        "Port"=>25);
    }
    public function inicializarphpmailer($asunto="NULL"){
     
            $this->mail->PluginDir =  trim($this->configurarionphmailer['PluginDir']); 
            $this->mail->Helo = trim($this->configurarionphmailer['Helo']);
            $this->mail->Mailer = trim($this->configurarionphmailer['Mailer']);
            $this->mail->Host = trim($this->configurarionphmailer['Host']);
            $this->mail->SMTPAuth = trim($this->configurarionphmailer['SMTPAuth']); 
            $this->mail->Username = trim($this->configurarionphmailer['Username']); // Cuenta de e-mail
            $this->mail->Password = trim($this->configurarionphmailer['Password']); // Password
            $this->mail->From = trim($this->configurarionphmailer['From']);
            $this->mail->FromName = trim($this->configurarionphmailer['FromName']);
            $this->mail->Subject = $asunto;
            $this->mail->Timeout = trim($this->configurarionphmailer['Timeout']);
            $this->mail->IsHTML(trim($this->configurarionphmailer['IsHTML']));
            $this->mail->CharSet=trim($this->configurarionphmailer['CharSet']);
            $this->mail->Port = trim($this->configurarionphmailer['Port']);
    }
    public function contactarCliente($vector){
        $this->inicializarphpmailer("Contacto cliente " . $vector['txtasuntocontacto']);
        $this->mail->AddAddress("juan1387@gmail.com"); //hay que pasar un vector
        $contenido = "<table width=\"650\" style=\"color:#999\margin:0 auto;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                        <tr>
                            <td style=\"padding-left:20px;padding-top:20px;\">
                                <p>
                                    Asunto: $vector[txtasuntocontacto]<br />
                                    Nombre: $vector[txtnombre]<br />
                                    Correo: $vector[txtcorreo]
                                </p>
                                <p>Mensaje: 
                                    <br /><br />
                                    $vector[txtmensaje]
                                </p>
                            </td>
                        </tr>
                    </table>";
        $valorhtml = str_replace("{contenido}", $contenido, $this->maqueta);
        $valorhtml = str_replace("{tipo}", "Contacto cliente", $valorhtml);

        $this->mail->Body = $valorhtml;

        if ($this->mail->Send() == 1) {
            $this->mail->ClearAddresses();
            echo $this->mail->Send();
            echo "Gracias por ponerte en contacto con nosotros. Uno de nuestro asesores se pondra en contacto contigo";
        } else {
            $this->mail->ClearAddresses();
            echo $this->mail->Send();
            echo "error";
        }
    }
    public function contactarPrensa($vector) {
        $this->inicializarphpmailer("Contacto cliente " . $vector['txtmedio']);
        $this->mail->AddAddress("juan1387@gmail.com"); //hay que pasar un vector
        $contenido = "<table width=\"650\" style=\"color:#999\margin:0 auto;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                        <tr>
                            <td style=\"padding-left:20px;padding-top:20px;\">
                                <p>
                                    Asunto: $vector[txtasunto]<br />
                                    Nombre: $vector[txtnombre]<br />
                                    Correo: $vector[txtcorreo]<br />
                                    Medio: $vector[sltmedio]
                                </p>
                                <p>Mensaje: 
                                    <br /><br />
                                    $vector[txtmensaje]
                                </p>
                            </td>
                        </tr>
                    </table>";
        $valorhtml = str_replace("{contenido}", $contenido, $this->maqueta);
        $valorhtml = str_replace("{tipo}", "Contacto medio$vector[txtmedio]", $valorhtml);
        $this->mail->Body = $valorhtml;
        if ($this->mail->Send() == 1) {
            $this->mail->ClearAddresses();
            echo $this->mail->Send();
            echo "Gracias por ponerte en contacto con nosotros. Uno de nuestro asesores se pondra en contacto contigo";
        } else {
            $this->mail->ClearAddresses();
            echo $this->mail->Send();
            echo "error";
        }
    }
}

