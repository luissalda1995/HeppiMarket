<?php
Class ControllerUsuarios extends ControllerMain{
    public function __construct(){
        $this->_modelo = new ModelMain();
    }
    
    public function registrarUsuario($vector){ 
        if($this->selectUser($vector['txtusuario'],$vector['txtndocumento'])==0){
            $valores = array();
            $fiels =$this->getFieldsTable('clientescompra');
            $valores[]="null";
            $valores[]="'$vector[txtndocumento]'";
            $valores[]="'$vector[txtnombre]'";
            $valores[]="'$vector[txtapellidos]'";
            $valores[]="'$vector[txtusuario]'";
            $valores[]="'".md5($vector['txtconstra'])."'";
            $valores[]="$vector[slttipodocumento]";
            $valores[]="'$vector[txttelefono]'";
            $valores[]="'$vector[txtcorreo]'";
            $valores[]="'$vector[txtpais]'";
            $valores[]="'$vector[txtdepartemento]'";
            $valores[]="'$vector[txtciudad]'";
            $valores[]="'$vector[txtdireccion]'";
            $valores[]="'".date("y-m-d")."'";
            
            $request = $this->_modelo->insertStand($fiels ,  $valores,'clientescompra');
            if($request){
                $sessionUsuario = array("cedula"=>$vector['txtndocumento'],
                "nombre"=>$vector['txtnombre'],
                "apellido"=> $vector['txtapellidos'],
                );
                try{
                    $this->iniciarSession($sessionUsuario,1);
                    echo 1;
                }catch (Exception $e){
                    echo "Se ha presentado un proble".$e;
                }
            }else{
                echo $this->translate("Ya existe un usuario con  estos datos", $vector['idioama']);
            }
//             echo $this->translate("Ya existe un usuario con  estos datos", $vector['idioama']);
        }else{
            echo $this->translate("Ya existe un usuario con  estos datos", $vector['idioama']);
        }
    }
    public  function selectUser($userLogiun = false,$cedula = false){
        if($userLogiun == false  && $cedula == false){
       
        }else{
           $query ="SELECT * FROM clientescompra where usuarologuin = '$userLogiun' or cedulacliente = '$cedula'";
           $resultadoConsulta = $this->_modelo->selectPersonalizado($query);
           if($resultadoConsulta){
               return $resultadoConsulta->rowCount();
           }
        }
    }
    public function traerUsario($vector,$sw=0){
        if($sw ==0){
            $query ="SELECT * FROM clientescompra where usuarologuin = '$vector[usuario]' && contrasena = '".md5($vector['password'])."'";
            try {
               $resultadoConsulta = $this->_modelo->selectPersonalizado($query);
               return $resultadoConsulta->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $exc) {
                return false;
            }
        }else{
            $query ="SELECT * FROM clientescompra where cedulacliente = '$vector[cedula]'";
            try {
               $resultadoConsulta = $this->_modelo->selectPersonalizado($query);
               return $resultadoConsulta->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $exc) {
                return false;
            }
        }
    }
    public function cerrarSession(){
        try {
           unset($_SESSION['usuario']);
           unset($_SESSION['id_pago_echo_10260']); 
           $this->redirect('index.php', 0, "Gracias por utilizar nuestro sistema");
        } catch (Exception $e) {
           throw $e;
           $this->redirect(null, 2, 'Se presento un problema'.$e);
        }
    }
    public function iniciarSession($vector,$sw =0){
        if($sw == 0){
            $vectorDatos=$this->traerUsario($vector);
            if($vectorDatos){
                $sessionUsuario = array("cedula"=>$vectorDatos['cedulacliente'],
                "nombre"=>$vectorDatos['nombrecliente'],
                "apellido"=> $vectorDatos['apellidocliente'],
                );
                $_SESSION['usuario'][0] = $sessionUsuario;
                if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])){
                    echo 2;
                }else{
                    echo 1;
                }
                
            }else{
                echo "Sus datos no coinciden";
            }
        }else{
            try{
            
                $_SESSION['usuario'][0] = $vector;
                echo 1;
            }catch ( Exception $e){
                echo 'Se presento un problema'.$e;
            }
        }
       
    }
    public function guardarPerfil($informacion){
        if($informacion['txtconstra'] == ""){
            $fields = "cedulacliente = '$informacion[txtndocumento]',
                    nombrecliente = '$informacion[txtnombre]',
                    apellidocliente = '$informacion[txtapellidos]',
                    tipodocumento = $informacion[slttipodocumento],
                    telefonocliente = '$informacion[txttelefono]',
                    mailcliente = '$informacion[txtcorreo]',
                    pais  = '$informacion[txtpais]',
                    departamento = '$informacion[txtdepartemento]',
                    ciudad = '$informacion[txtciudad]',
                    direccionentrega = '$informacion[txtdireccion]',
                    fecharegistro = '".date('y-m-d')."'";
        }else{
            $contrasena = md5($informacion['txtconstra']);
            $fields = "cedulacliente = '$informacion[txtndocumento]',
                    nombrecliente = '$informacion[txtnombre]',
                    apellidocliente = '$informacion[txtapellidos]',
                    contrasena = '$contrasena',
                    tipodocumento = $informacion[slttipodocumento],
                    telefonocliente = '$informacion[txttelefono]',
                    mailcliente = '$informacion[txtcorreo]',
                    pais  = '$informacion[txtpais]',
                    departamento = '$informacion[txtdepartemento]',
                    ciudad = '$informacion[txtciudad]',
                    direccionentrega = '$informacion[txtdireccion]',
                    fecharegistro = '".date('y-m-d')."'";
        }
        $where = "idclientescompra = '$informacion[idperfil]'";
        try {
            $this->_modelo->updateStand($fields,$where,"clientescompra",0);
            echo "Su perfil se ha actualizado correctamente";
        } catch (Exception $e) {
            echo $e;
        }
     
    }
    public function recuperarContrasena($info){
        // echo rawurldecode($info['mailcliente']);
        $query = "SELECT * FROM clientescompra WHERE  
        cedulacliente  = '$info[cedulacliente]' 
        AND  tipodocumento = $info[tipodocumento] 
        AND mailcliente = '$info[mailcliente]' ";
        try {
           $resultadoConsulta = $this->_modelo->selectPersonalizado($query);
           if($resultadoConsulta->rowCount()>0){
                $vectorInfo = $resultadoConsulta->fetch(PDO::FETCH_ASSOC);
                $contra = $this->generarCodigo(8);
                $contraEncriptada = md5($contra);
                $fields = "contrasena = '$contraEncriptada'";
                $where = " cedulacliente  = '$info[cedulacliente]' AND  tipodocumento =$info[tipodocumento] AND mailcliente = '$info[mailcliente]'";
                $this->_modelo->updateStand($fields,$where,"clientescompra",0);
                $objeContacto = ControllerMain::makeObjects("Contacto",1);
                $mensaje ="Gracias por ponerte en contacto con nosotros tu usuario es ".$vectorInfo['usuarologuin']." tu contraseña provicional es esta \"$contra\" por favor no colocar las comillas y recuerda cambiarla una vez ingreses en tu perfil";
                $objeContacto->contactarRecoveri(array("txtasuntocontacto"=>'Contraseña para ingreso provicional',"txtnombre"=>"Mercado heppi","txtmensaje"=>$mensaje,"txtcorreo"=>$info['mailcliente']));
                echo "A su cocrreo se ha enviado un mensaje con una contraseña provisional recerde cambiarla en su perfil";
           }else{
                echo "Sus datos no registran en nuesta base de datos";
           }
            
        } catch (Exception $exc) {
            echo "Se ha producido un error consulte con su administrador ".$exc;
        }
        
    }
}
