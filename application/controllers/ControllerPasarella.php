<?php

Class ControllerPasarella extends ControllerMain {

    private $objetosoap;

    public function __construct() {

        $this->_modelo = new ModelMain();
        date_default_timezone_set('America/Bogota');
    }

    public function cargarPago($infoCarga) {
       $objeProducto = ControllerMain::makeObjects("Carrito",1);
 
        if($objeProducto->cosotroBruto()<30000){
            echo "Lo sentimos el valor de compra debe ser igual o superior a $ 30.000 COP";
        }else{
             $valores = array();

        $fiels = $this->getFieldsTable('pagos');
        $valores[] = "null";
        $valores[] = "'" . $infoCarga['id_pago']. "'";
        $valores[] = "'" . date("y-m-d h:i:s"). "'" ;
        $valores[] = 1; //1 pendiente 2 visto 3 enviado 4 recibido
        $valores[] = $infoCarga['total_con_iva'];
        $valores[] = "'" .$infoCarga['id_cliente']. "'";
        try {
            $this->_modelo->insertStand($fiels, $valores, 'pagos');
            $this->descargarInventario($infoCarga['id_pago']);
            $objeto = ControllerMain::makeObjects("Contacto",1);
            $mensaje = $this->crearTablaproductos();
            $vector = array(
            'nombre' => $infoCarga['nombre_cliente']." ".$infoCarga['apellido_cliente'],
            'correo' => $infoCarga['email'],
            'telefono' => $infoCarga['telefono_cliente'], 
            'direccion' => $infoCarga['info_opcional2']."<br />Dirección: ".$infoCarga['info_opcional3'],
            'mensaje' =>  $mensaje 
            );
          
            $objeto->enviarNotificacion($vector);

            $objetocarrito = ControllerMain::makeObjects("Carrito",1);
            $objetocarrito->vaciarCarrito($vector);
            echo "Su pedido se ha realizado correctamente, uno de nuestros asesores se pondra en contacto con usted";
        } catch (Exception $e) {
            echo $e;
        }
        }
       
    }
    public function crearTablaproductos(){
        $mensaje =  "<table style = '  border-collapse: separate;
        border-spacing:  0px;'>
        <thead>
        <tr>
            <th style = 'border: 1px solid #d1d1d1;'>Descripción</th>
             <th style = 'border: 1px solid #d1d1d1;'>Cantidad</th>
             <th style = 'border: 1px solid #d1d1d1;'>Valor unitario</th>
              <th style = 'border: 1px solid #d1d1d1;'>Valor total</th>
        </tr>
        </thead>
        <tbody>
        ";
          $mensaje .= "<tr><td style = 'border: 1px solid #d1d1d1;'>Valor Domicilio</td>
          <td style = 'border: 1px solid #d1d1d1;'>1</td>
          <td style = 'border: 1px solid #d1d1d1;'>1</td>
          <td style = 'border: 1px solid #d1d1d1;'>$ ".number_format(5000)." COP</td></tr>";
        $totalcompra = 5000;
        for ($i = 0; $i < $_SESSION['contador']; $i++) {
            $query = "select * from productos where idproducto = " . $_SESSION['carrito'][$i]['producto'];
            $resultado = $this->_modelo->selectPersonalizado($query);
            $info = $resultado->fetch(PDO::FETCH_ASSOC);
            $cantidadfac = $_SESSION['carrito'][$i]['cantidad'];
            $valortotal =$cantidadfac * $info['costo'];
            $totalcompra = $totalcompra + $valortotal; 
           $mensaje .= "<tr>
                    <td style = 'border: 1px solid #d1d1d1;'>$info[nombre]</td>
                     <td style = 'border: 1px solid #d1d1d1;'>$cantidadfac</td>
                     <td style = 'border: 1px solid #d1d1d1;'> $ ".number_format($info['costo'])." COP</td>
                      <td style = 'border: 1px solid #d1d1d1;'> $ ".number_format($valortotal)." COP</td>
                </tr>";

        }
        $mensaje .= "
        <tr>
                    <td >&nbsp;</td>
                     <td >&nbsp;</td>
                     <td ><strong> Total</strong></td>
                      <td style = 'border: 1px solid #d1d1d1;'> $ ".number_format($totalcompra)." COP</td>
                </tr>
        </tbody>
        </table>";
        return $mensaje;
    }
    public function conectarwebservices($vectorData) {
        $Id_pago = $this->generarCodigo(4) . date('y');
       
       
        $arraywebservices = array(
            "total_con_iva" => $vectorData['total_con_iva'],
            "valor_iva" => $vectorData['valor_iva'],
            "id_pago" => $Id_pago,
            "descripcion_pago" => "Pago tienda Hehppi de " . $_SESSION['contador'] . " Artículos",
            "email" => "$vectorData[txtcorreo]",
            "id_cliente" => "$vectorData[txtndocumento]",
            "tipo_id" => $vectorData['slttipodocumento'],
            "nombre_cliente" => "$vectorData[txtnombre]",
            "apellido_cliente" => "$vectorData[txtapellidos]",
            "telefono_cliente" => "$vectorData[txttelefono]",
            "info_opcional2" => "$vectorData[txtpais]" . " $vectorData[txtciudad]" . " $vectorData[txtdepartemento]",
            "info_opcional3" => "$vectorData[txtdireccion]"
        );
        $this->cargarPago($arraywebservices);
      
    }

    public function generarCodigo($longitud) {
        $key = '';
        $pattern = '123456789';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++)
            $key .= $pattern{
                    mt_rand(0, $max)
                    };
        if (!$this->consultarCodigo($key)) {
            return $key;
        } else {
            $this->generarCodigo(4);
        }
    }

    public function consultarCodigo($codigo) {
        $query = "SELECT * FROM pagos where codigopago = '$codigo'";
        try {
            $resultado = $this->_modelo->selectPersonalizado($query);
            if ($resultado->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

   

   

    

    public function descargarInventario($idpago) {
        $objeto = ControllerMain::makeObjects("Productos", 1);
        $valores = array();

        for ($i = 0; $i < $_SESSION['contador']; $i++) {
            $query = "select costo from productos where idproducto = " . $_SESSION['carrito'][$i]['producto'];
            $resultado = $objeto->productosBruto($query);
            $fiels = $this->getFieldsTable('detalle_pago');
            $valores[] = "null";
            $valores[] = " '$idpago' ";
            $valores[] = $_SESSION['carrito'][$i]['producto'];
            $valores[] = $_SESSION['carrito'][$i]['cantidad'];
            $valores[] = $resultado['costo'];
            $camposUpdate = "cantidad = cantidad - " . $_SESSION['carrito'][$i]['cantidad'] . "";
            $where = "idproducto = " . $_SESSION['carrito'][$i]['producto'] . " ";
                
            try {
                $this->_modelo->updateStand($camposUpdate, $where, 'productos', 0);
                try {
                    $this->_modelo->insertStand($fiels, $valores, 'detalle_pago');
                    unset($valores);
                } catch (Exception $e) {
                    echo "error agregando detalle " . $e;
                }
            } catch (Exception $e) {
                echo "error actuzalizando cantidad " . $e;
            }
        }
    }

    public function actualizarEstadoPago($vectorDatos, $sw = 0) {
        if ($sw == 0) {
            $fields = " estado= $vectorDatos[estado], "
                    . "id_forma_pago=$vectorDatos[int_id_forma_pago],"
                    . " valor_pagado=$vectorDatos[valor_pagado], "
                    . "ticketID=$vectorDatos[ticketID],"
                    . " id_clave= '$vectorDatos[str_id_clave]' , "
                    . "id_cliente = $vectorDatos[str_id_cliente],"
                    . "banco = '$vectorDatos[banco]', "
                    . "codigo_banco = $vectorDatos[codigo_banco], "
                    . "franquicia = ' $vectorDatos[str_franquicia] ',"
                    . "transaccion = '$vectorDatos[str_codigo_transaccion]' ";
        } else {
            $fields = "estado= $vectorDatos[estado] ";
        }

        $where = "codigopago = $vectorDatos[str_id_pago]";
        try {
            $this->_modelo->updateStand($fields, $where, 'pagos', 0);
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public function sonda() {
        $url = 'https://www.zonapagos.com/ws_verificar_pagos/Service.asmx?wsdl';
        $arraywebservices = array();
        try {
            $this->objetosoap = new SoapClient($url);
            $resultadoConsulta = $this->consultarPagos();
            if ($resultadoConsulta) {
                $res_pagos_v3 = array();
                $int_error = 0;
                $str_error = "";
                $codigo = 10260;
                $clave = "Rium10260";

                foreach ($resultadoConsulta as $value) {
                    print_r($value['codigopago']) . "<br />";
                    $arraywebservices = array("str_id_pago" => "$value[codigopago]",
                        "int_id_tienda" => $codigo,
                        "str_id_clave" => "$clave",
                        "res_pagos_v3" => $res_pagos_v3,
                        "int_error" => $int_error,
                        "str_error" => "$str_error",
                    );
                    $resultado = $this->objetosoap->verificar_pago_v3($arraywebservices);



                    if ($resultado->verificar_pago_v3Result == 1) {

                        //print_r($resultado->res_pagos_v3->pagos_v3);
                        $banco = $resultado->res_pagos_v3->pagos_v3->str_nombre_banco;
                        $vectorDatos = array(
                            "estado" => $resultado->res_pagos_v3->pagos_v3->int_estado_pago,
                            "valor_pagado" => $resultado->res_pagos_v3->pagos_v3->dbl_valor_pagado,
                            "ticketID" => $resultado->res_pagos_v3->pagos_v3->str_ticketID,
                            "int_id_forma_pago" => $resultado->res_pagos_v3->pagos_v3->int_id_forma_pago,
                            "str_id_clave" => $resultado->res_pagos_v3->pagos_v3->str_id_clave,
                            "str_id_cliente" => $resultado->res_pagos_v3->pagos_v3->str_id_cliente,
                            "banco" => $banco,
                            "str_id_pago" => $resultado->res_pagos_v3->pagos_v3->str_id_pago,
                            "codigo_banco" => $resultado->res_pagos_v3->pagos_v3->int_codigo_banco,
                            "str_franquicia" => $resultado->res_pagos_v3->pagos_v3->str_franquicia,
                            "str_codigo_transaccion" => $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion
                        );

                        if ($resultado->int_error == 0) {
                            if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 1) {
                                if ($value['estado'] != 1) {
                                    $this->actualizarEstadoPago($vectorDatos);
                                }
                            } else {
                                if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 999) {
                                    if ($value['estado'] != 999) {
                                        $this->actualizarEstadoPago($vectorDatos);
                                    }
                                } else {
                                    if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 4001) {
                                        if ($value['estado'] != 4001) {
                                            $this->actualizarEstadoPago($vectorDatos);
                                        }
                                    } else {
                                        if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 888) {
                                            if ($value['estado'] != 888) {
                                                $this->actualizarEstadoPago($vectorDatos);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo "listo";
                    } else if ($resultado->verificar_pago_v3Result == 0) {
                        $vectorDatos = array("estado" => "",
                            "str_id_pago" => " '$value[codigopago] ' ");
                        switch ($resultado->int_error) {
                            case 1:
                                echo "no se encontrarron pagos";
                                $vectorDatos['estado'] = "1" . $resultado->int_error; // rechazado
                                $this->actualizarEstadoPago($vectorDatos, 1);
                                break;
                            case 2:
                                echo "Claves web services invalidos";
                                $vectorDatos['estado'] = "1" . $resultado->int_error; // Pilas no hay accesos por claves errorneas
                                $this->actualizarEstadoPago($vectorDatos, 1);
                                break;
                            case 3:
                                echo "Se genero un error buscando al comercio";
                                $vectorDatos['estado'] = "1" . $resultado->int_error; // Error en la plataforma
                                $this->actualizarEstadoPago($vectorDatos, 1);
                                break;
                            case -1:
                                echo "Error no se encontraron causas";
                                $vectorDatos['estado'] = "1" . $resultado->int_error; // Error no se encontraron causas
                                $this->actualizarEstadoPago($vectorDatos, 1);
                                break;
                            default:
                                break;
                        }
                        echo "listo";
                    }
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

}
