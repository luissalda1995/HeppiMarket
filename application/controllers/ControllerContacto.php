<?php
require_once(LIBRARYS_LOCAL."phpmailer".DS."class.phpmailer.php");
Class ControllerContacto extends ControllerMain{
    private $rutaAbsolutlogo;
    private $maqueta;
    private $mail;
    private $correos;
    private $configurarionphmailer;
    public function __construct(){
        $this->mail = new phpmailer(true);
        $this->rutaAbsoluta ="©©";
        $this->maqueta ="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
        <html xmlns=\"http://www.w3.org/1999/xhtml\">
        <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
        <title>MAQUETA CONTACTO</title>
        </head>
        <body style =\"background:#CCC; font-family:Arial, Helvetica\">
        <table style=\"margin:0 auto;background:#FFF;text-align:left;border: 1px solid #d1d1d1;color:#888\" width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <td width=\"228\" height=\"70\" style =\"background:#B0BB2A;text-align:center;scolor:#FFF;border-bottom: 1px solid #d1d1d1;color:#fff;font-size:20px\">{tipo}</td>
            <td style=\"text-align:center;border-bottom: 1px solid #d1d1d1;\" width=\"226\"><img src=\"http://www.mercadoheppi.com/views/template/assets/img/heppi-market.png\"  alt =\"\"/></td>
          </tr>
          <tr>
            <td colspan=\"2\" style=\"text-align:left\">{contenido}</td>
          </tr>
          <tr>
            <td colspan=\"2\" style =\"color:#AFBA2A;font-size:12px;text-align:center;  border-top: 1px solid #d1d1d1;\">Heppi Mercado saludable – 2015 Todos Los Derechos Reservados</td>
          </tr>
        </table>
        </body>";
       
        $mailRigo[]="juan1387@gmail.com";
        $mailRigo[]="desarrollo@drink.com";
        $this->correos = $mailRigo;
        $this->configurarionphmailer = array ("PluginDir"=>LIBRARYS_LOCAL."phpmailer".DS,
        "Helo"=>"www.drink.com.co",
        "Mailer"=>"smtp",
        "Host"=>"smtpout.asia.secureserver.net",
        "SMTPAuth"=>true,
        "Username"=>"compras@heppimarket.com",
        "Password"=>"laheppivendedora",
        "From"=>"compras@heppimarket.com",
        "FromName"=>"Tienda online Heppi mercado saludable",
        "Subject"=>"",
        "Timeout"=>30,
        "IsHTML"=>true,
        "CharSet"=>"utf-8",
        "Port"=>80);
    }
    public function inicializarphpmailer($asunto="NULL"){
            $this->mail->IsSMTP(); 
            $this->mail->SMTPAuth   = true;
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
    public function contactarRecoveri($vector){
        $this->inicializarphpmailer($vector['txtasuntocontacto']);         
        $this->mail->AddAddress($vector['txtcorreo']);
        $contenido = "<table width=\"650\" style=\"color:#999\margin:0 auto;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                        <tr>
                            <td style=\"padding-left:20px;padding-top:20px;\">
                                <p>
                                    Asunto: $vector[txtasuntocontacto]<br />
                                    Nombre: $vector[txtnombre]<br />
                                  
                                </p>
                                <p>Mensaje: 
                                    <br /><br />
                                    $vector[txtmensaje]
                                </p>
                            </td>
                        </tr>
                    </table>";
        $valorhtml = str_replace("{contenido}", $contenido, $this->maqueta);
        $valorhtml = str_replace("{tipo}", "Tu contraseña", $valorhtml);

        $this->mail->Body = $valorhtml;

        if ($this->mail->Send() == 1) {
            $this->mail->ClearAddresses();
            echo $this->mail->Send();
            echo "A su cocrreo se ha enviado un mensaje con una contraseña provisional recerde cambiarla en su perfil";
        } else {
            $this->mail->ClearAddresses();
            echo $this->mail->Send();
            echo "error";
        }
    }
    public function enviarNotificacion($vector){
     
        $this->inicializarphpmailer("Solicitud pedido " . $vector['nombre']);  
        $this->mail->AddAddress("alejaheppi@gmail.com");
        $this->mail->AddAddress("Daniheppi@gmail.com");
         $this->mail->AddAddress("Caroheppi@gmail.com");
        $this->mail->AddAddress("juan1387@gmail.com"); //hay que pasar un vector
        $this->mail->AddAddress($vector['correo']);
        $contenido = "<table width=\"650\" style=\"color:#999\margin:0 auto;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                        <tr>
                            <td style=\"padding-left:20px;padding-top:20px;\">
                                <p>
                                   
                                    Nombre: $vector[nombre]<br />
                                    Telefono: $vector[telefono]<br />
                                    Correo: $vector[correo]
                                </p>
                                <p>
                                <br />
                                $vector[direccion] <br /> 
                               Pedido realizado 
                                    <br /><br />
                                    $vector[mensaje]
                                </p>
                            </td>
                        </tr>
                    </table>";
        $valorhtml = str_replace("{contenido}", $contenido, $this->maqueta);
        $valorhtml = str_replace("{tipo}", "Pedido Heppi", $valorhtml);

        $this->mail->Body = $valorhtml;

        if ($this->mail->Send() == 1) {
            $this->mail->ClearAddresses();
           
        } else {
            $this->mail->ClearAddresses();
            echo "error";
        }
    }
    
}