<?php
require_once(LIBRARYS_LOCAL."pdf".DS."fpdf.php");
Class ControllerFactura extends ControllerMain {

    public function __construct() {
        $this->_modelo = new ModelMain();
    }
    public function crearFactura(){
        $vector[]= array('Producto' =>"Camiseta rigo pro talla xs colo unico" ,
        'Cantidad' =>1 ,
        'Valor' =>150000);
        $vector[] =  array('Producto' =>"Camiseta rigo clasci talla s color azul" ,
        'Cantidad' =>2 ,
        'Valor' =>20000);
        $vector[] =  array('Producto' =>"Pantoleta rigo clasci talla l color unico" ,
        'Cantidad' =>10 ,
        'Valor' =>175000);
        $id_factura = 22;

        //variable que guarda el nombre del archivo PDF
        $archivo="factura-$id_factura.pdf";



        $archivo_de_salida=$archivo;

        $pdf=new FPDF();  //crea el objeto
        $pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.


        //logo de la tienda


        // Encabezado de la factura
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(50, 45, $pdf->Image('http://200.116.1.182/framework_v2/views/template/assets/img/logo-rigo-uran.jpg' , 5 ,4, 40 , 40,'JPG', 'http://200.116.1.182/framework_v2/') ,0, 0, "C");
        $pdf->SetFont('Arial','B',11);
        $pdf->SetXY(48, 10);
        $pdf->MultiCell(50,6, "RIUM S.A.S"."\n"."NIT: 900.748.651-0"."\n"."Tel: 268 62 59"."\n"."Calle: 10 a nro 43 d 64"."\n"."Medellín - Colombia", 1, "C", false);
        $pdf->SetXY(100, 10);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(50, 4,"Fecha de emsión",1, 2, "C");
        $pdf->Cell(16.66666666666667, 4,"Día",1, 0, "C");
        $pdf->Cell(16.66666666666667, 4,"Mes",1, 0, "C");
        $pdf->Cell(16.66666666666667, 4,"Año",1, 0, "C");
        $pdf->SetXY(100, 18);
        $pdf->Cell(16.66666666666667, 8,"  ",1, 0, "C");
        $pdf->Cell(16.66666666666667, 8,"  ",1, 0, "C");
        $pdf->Cell(16.66666666666667, 8,"  ",1, 0, "C");
        $pdf->SetXY(150, 10);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(50, 8,"FACTURA VENTAS",1, 2, "C");
        $pdf->Cell(50, 8,"NRO.",1, 0, "C");
        $pdf->SetFont('Arial','B',11);
        $top_datos=55;
        $pdf->SetXY(10, $top_datos);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100, 8,"Nombre o razón social:",1, 0, "L");
        $pdf->Cell(90, 8,"C.C o NIT.",1, 0, "L");
        $top_datos=63;
        $pdf->SetXY(10, $top_datos);
        $pdf->Cell(100, 8,"Dirección",1, 0, "L");
        $pdf->Cell(45, 8,"Ciudad: ",1, 0, "L");
        $pdf->Cell(45, 8,"Teléfono: ",1, 0, "L");
        $top_datos=71;
        $pdf->SetXY(10, $top_datos);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(100, 8,"Descripción",1, 0, "C");
        $pdf->Cell(18, 8,"Cantidad: ",1, 0, "L");
        $pdf->Cell(27, 8,"Valor Unit: ",1, 0, "L");
        $pdf->Cell(45, 8,"Valor total: ",1, 0, "C");
        $top_datos=79;
        $pdf->SetXY(10, $top_datos);
        $pdf->SetFont('Arial','',8);
        foreach ($vector as $value) {
            $producto =  $value['Producto'];
            $cantidad = $value['Cantidad'];
            $valor = $value['Valor'];
            $valortotal = "$ ".number_format($cantidad * $valor)." COP" ;
        $pdf->Cell(100, 8,$producto,1, 0, "C");
        $pdf->Cell(18, 8,$cantidad,1, 0, "C");
        $pdf->Cell(27, 8,"$ ".number_format($valor)." COP" ,1, 0, "L");
        $pdf->Cell(45, 8,  $valortotal ,1, 0, "C");
            $top_datos = $top_datos + 8;
            $pdf->SetXY(10, $top_datos);
        }
        $pdf->SetXY(128, $top_datos);
        $pdf->Cell(27, 8,"Subtotal: ",1, 0, "L");
        $pdf->Cell(45, 8,"",1, 0, "C");
        $top_datos = $top_datos +8;
        $pdf->SetXY(128, $top_datos);
        $pdf->Cell(27, 8,"Iva 16 %",1, 0, "L");
        $pdf->Cell(45, 8,"",1, 0, "C");
        $top_datos = $top_datos +8;
        $pdf->SetXY(128, $top_datos);
        $pdf->Cell(27, 8,"Total",1, 0, "C");
        $pdf->Cell(45, 8,"",1, 0, "C");
        $top_datos = $top_datos +15;
        $pdf->SetXY(10, $top_datos);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(100, 8,"Resolución DIAN Nº 1111111000000000000 fecha 2015/02/18 Rango:  N 0001  hasta N 3000",0, 0, "C");




        $pdf->Output($archivo_de_salida);//cierra el objeto pdf

        //Creacion de las cabeceras que generarán el archivo pdf
        header ("Content-Type: application/download");
        header ("Content-Disposition: attachment; filename=$archivo");
        header("Content-Length: " . filesize("$archivo"));
        $fp = fopen($archivo, "r");
        fpassthru($fp);
        fclose($fp);

        //Eliminación del archivo en el servidor
        unlink($archivo);
        
    }

    public function selectProducto($vector = false) {
        if($vector == false){
           $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado, banco"
                . " FROM pagos where DATE(fecha) = DATE(NOW()) and estado = 1";
        }else{
           $fechaInicial =$vector['fechaini'];
           $fechafinal= $vector['fechaend'];
            $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado, banco"
                . " FROM pagos where fecha  BETWEEN '$fechaInicial'  AND '$fechafinal' and estado = 1";
        }
        $recursos = $this->_modelo->selectPersonalizado($query);
       
        if ($recursos && $recursos->rowCount() > 0) {
            echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">"
            . "  <thead>
                    <tr>
                        <th >Código</th>
                        <th >Fecha</th>
                        <th >Valor pagado</th>
                        <th >Banco</th>
                        <th>Estado</th>
                        <th   >Acción</th>
                    </tr>
                    </thead>
                    <tbody>";
             $total = 0;
            foreach ($recursos as $value) {
                if ($value['estado'] == 1) {
                    $estado = "<span class ='full'>Exitoso</span>";
                    $detalle = "<a href ='$value[codigopago]'  class='tbl-axpan'>[+]  </a> | <a target ='_blank' href ='es-order_sent-$value[codigopago]'>Envio</a> | "
                            . "<a target ='blank' href ='es-sengle_envio-$value[codigopago]'>Mi pedido</a>";
                } else {
                    if ($value['estado'] == 11) {
                        $estado = "<span class ='malo'>Rechazado</span>";
                    } else {
                        $estado = "<span class ='medium'>Pendiente</span>";
                    }
                    $detalle = "&nbsp;";
                }

                echo "<tr>
                            <td >$value[codigopago]</td>
                            <td>$value[fecha]</td>
                            <td  > $ ".number_format($value['valor_pagado'])." COP</td>
                            <td>$value[banco]</td>
                            <td >$estado</td>
                            <td  >$detalle</td>
                    </tr>";
                $total = $total + $value['valor_pagado'];
                
            }
            echo
            "</tbody>
                </table>";
        }
        echo "<h2>Total ventas: $ ".number_format($total)." COP</h2>";
    }
    public function selectVentastodas($vector = false) {
        if($vector == 0){
           $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado, banco"
                . " FROM pagos";
        }else{
           $fechaInicial =$vector['fechaini'];
           $fechafinal= $vector['fechaend'];
            $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado, banco"
                . " FROM pagos where fecha  BETWEEN '$fechaInicial'  AND '$fechafinal'";
        }
        $recursos = $this->_modelo->selectPersonalizado($query);
        if ($recursos && $recursos->rowCount() > 0) {
            echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">"
            . "  <thead>
                    <tr>
                        <th >Código</th>
                        <th >Fecha</th>
                        <th >Valor pagado</th>
                        <th >Banco</th>
                        <th>Estado</th>
                        <th   >Acción</th>
                    </tr>
                    </thead>
                    <tbody>";
            foreach ($recursos as $value) {
                if ($value['estado'] == 1) {
                    $estado = "<span class ='full'>Exitoso</span>";
                    $detalle = "<a href ='$value[codigopago]'  class='tbl-axpan'>[+]  </a> | <a target ='_blank' href ='es-order_sent-$value[codigopago]'>Envio</a> | "
                            . "<a target ='blank' href ='es-sengle_envio-$value[codigopago]'>Mi pedido</a>";
                } else {
                    if ($value['estado'] == 11) {
                        $estado = "<span class ='malo'>Rechazado</span>";
                    } else {
                        $estado = "<span class ='medium'>Pendiente</span>";
                    }
                    $detalle = "&nbsp;";
                }

                echo "<tr>
                            <td >$value[codigopago]</td>
                            <td>$value[fecha]</td>
                            <td  >$value[valor_pagado]</td>
                            <td>$value[banco]</td>
                            <td >$estado</td>
                            <td  >$detalle</td>
                    </tr>";
                
            }
            echo
            "</tbody>
                </table>";
        } else {
            echo "<table class=\"rwd_auto\">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Valor pagado</th>
                        <th >Banco</th>
                        <th >Estado</th>
                        <th >Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan=\"6\">No hay pedidos realizados</td>
                        </tr>
                    </tbody>
                </table>";
        }
    }
    public function detallePago($codigoPago) {
        if (is_array($codigoPago)) {
            $valor = @$codigoPago[idpago];
        } else {
            $valor = $codigoPago;
        }
        $query = "SELECT productos.nombrem, 
        sexo.sexo, 
        color.nombre as color,
        detallepagos.cantidad, 
        detallepagos.valorunitario, 
        tallas.nombre  as talla FROM detallepagos
        INNER JOIN sexo ON sexo.idSexo  = detallepagos.sexo 
        INNER JOIN color ON color.idcolor = detallepagos.color 
        INNER JOIN productos ON productos.idproductos = detallepagos.producto
        INNER JOIN tallas ON tallas.idtallas = detallepagos.talla
        INNER JOIN pagos ON detallepagos.factura = pagos.codigopago
        WHERE detallepagos.factura = '$valor' AND  pagos.estado = 1;";
        $recursos = $this->_modelo->selectPersonalizado($query);
        if ($recursos && $recursos->rowCount() > 0) {
            echo "<table class=\"rwd_auto\" style='margin-bottom:0px'>"
            . "  <thead>
                    <tr>
                        <th >Producto</th>
                        <th>Cantidad</th>
                        <th  >Val Unit.</th>
                        <th>Color</th>
                        <th >Talla</th>
                        
                        <th >Sexo</th>
                    </tr>
                   
                    </thead>
                    <tbody>";
            $suma = 0;
            $descripcion = "";
            foreach ($recursos as $value) {
                $descripcion .= " $value[nombrem] $value[color]";
                echo "<tr>
                            <td >$value[nombrem]</td>
                            <td>$value[cantidad]</td>
                            <th  >$value[valorunitario]</th>
                            <td >$value[color]</td>
                            <td>$value[talla]</td>
                            <td >$value[sexo]</td>
                        </tr>";
                $suma += $value['valorunitario'] * $value['cantidad'];
            }
            echo
            "<tr><td colspan = '6' style ='text-aling:center'>$suma</td></tr>
                        </tbody>
                </table><div style ='display:none' id = 'description' val ='" . $suma . "' >" . $descripcion . "</div>";
        } else {
            echo "No exiten registros";
            echo "<script>"
            . "$(document).ready(function(){"
            . "$('#btn-enviar-fedex').attr(\"disabled\", true);"
            . "})    "
            . "</script>";
        }
    }

}
