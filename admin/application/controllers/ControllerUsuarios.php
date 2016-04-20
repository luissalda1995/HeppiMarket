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
    public function traerUsario($vector){
        $query ="SELECT * FROM usuariospanel where login = '$vector[usuario]' && pwd = '".md5($vector['password'])."'";
        try {
           $resultadoConsulta = $this->_modelo->selectPersonalizado($query);
           return $resultadoConsulta->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return false;
        }
    }
    public function cerrarSession(){
        try {
           unset($_SESSION['usuarioadmin']);
           unset($_SESSION['id_pago_echo_10260']);
           $this->redirect('index.php', 0, "Gracias por utilizar nuestro sistema");
        } catch (Exception $e) {
           throw $e;
           $this->redirect(null, 2, 'Se presento un problema'.$e);
        }
    }
    public function iniciarSession($vector){
        $vectorDatos=$this->traerUsario($vector);
        if($vectorDatos){
            $sessionUsuario = array("cedula"=>$vectorDatos['cedula'],
            "nombre"=>$vectorDatos['nombre'],
            "rol"=> $vectorDatos['rol'],
            );
            $_SESSION['usuarioadmin'][0] = $sessionUsuario;
            echo 1;
        }else{
            echo "Sus datos no coinciden";
        }
    }
}
