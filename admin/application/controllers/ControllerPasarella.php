<?php

require_once(LIBRARYS_LOCAL . "nusoap" . DS . "lib" . DS . "nusoap.php");

Class ControllerPasarella extends ControllerMain {

    private $objetosoap;

    public function __construct() {

        $this->_modelo = new ModelMain();
        date_default_timezone_set('America/Bogota');
    }

    public function cargarPago($infoCarga) {
        $valores = array();

        $fiels = $this->getFieldsTable('pagos');
        $valores[] = "null";
        $valores[] = $infoCarga['id_pago'];
        $valores[] = "'" . date("y-m-d h:i:s") . "'";
        $valores[] = $infoCarga['identificador'];
        $valores[] = 22;
        $valores[] = "null";
        $valores[] = $infoCarga['total_con_iva'];
        $valores[] = "null";
        $valores[] = "null";
        $valores[] = $infoCarga['id_cliente'];
        $valores[] = "null";
        $valores[] = "null";
        $valores[] = "null";
        $valores[] = "null";
        try {
            $this->_modelo->insertStand($fiels, $valores, 'pagos');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function conectarwebservices($vectorData) {
        ini_set("default_socket_timeout", 300);
        $Id_pago = $this->generarCodigo(4) . date('y');
        $lista_codigos_servicio_multicredito = null;
        $lista_nit_codigos_servicio_multicredito = null;
        $lista_valores_con_iva = null;
        $lista_valores_iva = null;
        $total_codigos_servicio = 0;
        $codigo_servicio = 1001;
        $arraywebservices = array(
            "id_tienda" => 10260,
            "clave" => "Rium10260",
            "total_con_iva" => $vectorData['total_con_iva'],
            "valor_iva" => $vectorData['valor_iva'],
            "id_pago" => $Id_pago,
            "descripcion_pago" => "Pago tienda Rigo de " . $_SESSION['contador'] . " Artículos",
            "email" => "$vectorData[txtcorreo]",
            "id_cliente" => "$vectorData[txtndocumento]",
            "tipo_id" => $vectorData['slttipodocumento'],
            "nombre_cliente" => "$vectorData[txtnombre]",
            "apellido_cliente" => "$vectorData[txtapellidos]",
            "telefono_cliente" => "$vectorData[txttelefono]",
            "info_opcional1" => "$vectorData[idioma]",
            "info_opcional2" => "$vectorData[txtpais]" . " $vectorData[txtciudad]" . " $vectorData[txtdepartemento]",
            "info_opcional3" => "$vectorData[txtdireccion]",
            "codigo_servicio_principal" => $codigo_servicio,
            "lista_codigos_servicio_multicredito" => null,
            "lista_nit_codigos_servicio_multicredito" => null,
            "lista_valores_con_iva" => null,
            "lista_valores_iva" => null,
            "total_codigos_servicio" => 0
        );
        $url = 'http://www.zonapagos.com/ws_inicio_pagov2/Zpagos.asmx?wsdl';
        if (isset($_SESSION['id_pago_echo_10260']) && !empty($_SESSION['id_pago_echo_10260']) && $_SESSION['id_pago_echo_10260'] != "**") {
            $estadoPago = $this->consultarEstadopago($_SESSION['id_pago_echo_10260'], 1);
            if ($estadoPago['int_error'] == 888 || $estadoPago['int_error'] == 999 || $estadoPago['int_error'] == 4001) {
                echo $estadoPago['int_error'];
                echo "4|" . $estadoPago['msg'];
            } else if ($estadoPago['int_error'] == 0) {
                unset($_SESSION['id_pago_echo_10260']);
                echo "5";
            }
        } else {
            try {
                $this->objetosoap = new SoapClient($url, $arraywebservices);
                $resultado = $this->objetosoap->inicio_pagoV2($arraywebservices);
                $arraywebservices['identificador'] = $resultado->inicio_pagoV2Result;
                if ($this->cargarPago($arraywebservices)) {
                    $urlRedireccion = "https://www.zonapagos.com/t_Rium/pago.asp?estado_pago=iniciar_pago&identificador=$resultado->inicio_pagoV2Result";
                    $_SESSION['id_pago_echo_10260'] = $Id_pago;
                    echo "3|" . $urlRedireccion;
                } else {
                    echo "1";
                }
            } catch (Exception $e) {
                echo "1";
            }
        }
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

    public function consultarEstadopago($idPago, $swforma = 0, $lang = "es") {
        $url = 'https://www.zonapagos.com/ws_verificar_pagos/Service.asmx?wsdl';
        $res_pagos_v3 = array();
        $int_error = 0;
        $str_error = "";
        $codigo = 10260;
        $clave = "Rium10260";
        $arraywebservices = array(
            "str_id_pago" => "$idPago",
            "int_id_tienda" => $codigo,
            "str_id_clave" => "$clave",
            "res_pagos_v3" => $res_pagos_v3,
            "int_error" => $int_error,
            "str_error" => "$str_error",
        );
        $this->objetosoap = new SoapClient($url);
        $resultado = $this->objetosoap->verificar_pago_v3($arraywebservices);
        if ($resultado->verificar_pago_v3Result == 1) {
            $banco = $resultado->res_pagos_v3->pagos_v3->str_nombre_banco;
            if ($resultado->int_error == 0) {
                if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 1) {
                    if ($swforma == 0) {
                        $this->descargarInventario($idPago);
                        unset($_SESSION['carrito']);
                        $_SESSION['contador'] = 0;
                        return "Su pago # $idPago con Nro. de transacción " . $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion .
                                " ha finalizado correctamente lo invitamos a que diligencie el siguiente formulario para hacer el envio de este hasta su domicilio";
                        unset($_SESSION['carrito']);
                        unset($_SESSION['contador']);
                        $_SESSION['id_pago_echo_10260'] = "**";
                    } else {
                        $infoVector = array("int_error" => 0,
                            "msg" => "Su pago # $idPago con Nro. de transacción " . $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion .
                            " ha finalizado correctamente lo invitamos a que diligencie el siguiente formulario para hacer el envio de este hasta su domicilio");
                        return $infoVector;
                    }
                } else {
                    if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 999) {
                        if ($swforma == 0) {
                            $this->redirect($lang . "-my_pedidos", 1);
                        } else {
                            $codigoTransaccion = $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion;
                            $infoVector = array("int_error" => 999,
                                "msg" => "En este momento su pago # $idPago "
                                . "presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, "
                                . "por favor espere unos minutos y vuelva a consultar mas tarde para verificar si su pago fue confirmado de forma exitosa. "
                                . "Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente "
                                . "al teléfono 57-1-9999999 o enviar sus inquietudes al correo tienda@rigobertouran.com y pregunte por el estado de la transacción: " . $codigoTransaccion);
                            return $infoVector;
                        }
                    } else {
                        if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 4001) {
                            if ($swforma == 0) {
                                $this->redirect($lang . "-my_pedidos", 1);
                            } else {
                                $codigoTransaccion = $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion;
                                $infoVector = array("int_error" => 4001,
                                    "msg" => "En este momento su pago # $idPago "
                                    . "presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, "
                                    . "por favor espere unos minutos y vuelva a consultar mas tarde para verificar si su pago fue confirmado de forma exitosa. "
                                    . "Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente "
                                    . "al teléfono 57-1-9999999 o enviar sus inquietudes al correo tienda@rigobertouran.com y pregunte por el estado de la transacción: " . $codigoTransaccion);
                                return $infoVector;
                            }
                        } else {
                            if ($resultado->res_pagos_v3->pagos_v3->int_estado_pago == 888) {
                                if ($swforma == 0) {
                                    $this->redirect($lang . "-my_pedidos", 1);
                                } else {
                                    $codigoTransaccion = $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion;
                                    $infoVector = array("int_error" => 888,
                                        "msg" => "En este momento su # $idPago "
                                        . "presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, "
                                        . "por favor espere unos minutos y vuelva a consultar mas tarde para verificar si su pago fue confirmado de forma exitosa. "
                                        . "Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente "
                                        . "al teléfono 57-1-9999999 o enviar sus inquietudes al correo tienda@rigobertouran.com y pregunte por el estado de la transacción: " . $codigoTransaccion);
                                    return $infoVector;
                                }
                            }
                        }
                    }
                }
            }
        } else if ($resultado->verificar_pago_v3Result == 0) {
            if ($swforma == 0) {
                return 0;
            } else {
                $infoVector = array("int_error" => 0,
                    "msg" => "No se encontraron pagos");
                return $infoVector;
            }
        }
    }

    public function consultarPagos() {
        $query = "SELECT * FROM pagos WHERE pagos.estado !=1";
        try {
            $resultado = $this->_modelo->selectPersonalizado($query);
            if ($resultado->rowCount() > 0) {
                return $resultado;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo false;
        }
    }

    public function guardarPago($vector) {
        $url = 'https://www.zonapagos.com/ws_verificar_pagos/Service.asmx?wsdl';
        $res_pagos_v3 = array();
        $int_error = 0;
        $str_error = "";
        $codigo = 10260;
        $clave = "Rium10260";
        $arraywebservices = array("str_id_pago" => "$vector",
            "int_id_tienda" => $codigo,
            "str_id_clave" => "$clave",
            "res_pagos_v3" => $res_pagos_v3,
            "int_error" => $int_error,
            "str_error" => "$str_error",
        );
        $this->objetosoap = new SoapClient($url);
        $resultado = $this->objetosoap->verificar_pago_v3($arraywebservices);
        if ($resultado->verificar_pago_v3Result == 1) {
            $estado = $resultado->res_pagos_v3->pagos_v3->int_estado_pago;
            $fields = "estado = '" . $estado . "',"
                    . "id_forma_pago = " . $resultado->res_pagos_v3->pagos_v3->int_id_forma_pago . ","
                    . "valor_pagado = " . $resultado->res_pagos_v3->pagos_v3->dbl_valor_pagado . " ,"
                    . "ticketID = " . $resultado->res_pagos_v3->pagos_v3->str_ticketID . ", "
                    . "id_clave = '" . $resultado->res_pagos_v3->pagos_v3->str_id_clave . "' ,"
                    . "id_cliente = '" . $resultado->res_pagos_v3->pagos_v3->str_id_cliente . "' ,"
                    . "franquicia = '" . $resultado->res_pagos_v3->pagos_v3->str_franquicia . "' ,"
                    . "codigo_banco = " . $resultado->res_pagos_v3->pagos_v3->int_codigo_banco . " ,"
                    . "transaccion = " . $resultado->res_pagos_v3->pagos_v3->str_codigo_transaccion . " ,"
                    . "banco = '" . $resultado->res_pagos_v3->pagos_v3->str_nombre_banco . "'";
            $where = "codigopago = '" . $resultado->res_pagos_v3->pagos_v3->str_id_pago . "'";
        } else if ($resultado->verificar_pago_v3Result == 0) {
            $estado = "1" . $resultado->int_error;
            $fields = "estado = '" . $estado . "'";

            $where = "codigopago = '" . $vector . "'";
        }


        try {
            $this->_modelo->updateStand($fields, $where, 'pagos', 0);
            try {
                return true;
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public function descargarInventario($idpago) {
        $objeto = ControllerMain::makeObjects("Productos", 1);
        $valores = array();

        for ($i = 0; $i < $_SESSION['contador']; $i++) {
            $query = "select valoruno from productos where idproductos = " . $_SESSION['carrito'][$i]['producto'];
            $resultado = $objeto->productosBruto($query);
            $fiels = $this->getFieldsTable('detallepagos');
            $valores[] = "null";
            $valores[] = " '$idpago' ";
            $valores[] = $_SESSION['carrito'][$i]['producto'];
            $valores[] = $_SESSION['carrito'][$i]['sexo'];
            $valores[] = $_SESSION['carrito'][$i]['color'];
            $valores[] = $_SESSION['carrito'][$i]['cantidad'];
            $valores[] = $resultado['valoruno'];
            $valores[] = $_SESSION['carrito'][$i]['talla'];
            $valores[] = 1;
            $camposUpdate = "cantidad = cantidad - " . $_SESSION['carrito'][$i]['cantidad'] . "";
            $where = "idproducto = " . $_SESSION['carrito'][$i]['producto'] . " "
                    . " AND idtalla = " . $_SESSION['carrito'][$i]['talla'] . " "
                    . " AND idcolor = " . $_SESSION['carrito'][$i]['color'] . ""
                    . " AND sexo = " . $_SESSION['carrito'][$i]['sexo'] . "";
            try {
                $this->_modelo->updateStand($camposUpdate, $where, 'inventario', 0);
                try {
                    $this->_modelo->insertStand($fiels, $valores, 'detallepagos');
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
