<?php

Class ControllerPedidos extends ControllerMain {
    public function __construct() {
        $this->_modelo = new ModelMain();
    }
    public function selectProducto($vector = false) {
        if($vector == false){
           $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado"
                . " FROM pagos where DATE(fecha) = DATE(NOW()) ";
        }else{
           $fechaInicial =$vector['fechaini'];
           $fechafinal= $vector['fechaend'];
            $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado"
                . " FROM pagos where fecha  BETWEEN '$fechaInicial'  AND '$fechafinal' ";
        }
        $recursos = $this->_modelo->selectPersonalizado($query);
       
        if ($recursos && $recursos->rowCount() > 0) {
            echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">"
            . "  <thead>
                    <tr>
                        <th >Código</th>
                        <th >Fecha</th>
                        <th >Valor pagado</th>
                      
                        <th>Estado</th>
                        <th   >Acción</th>
                    </tr>
                    </thead>
                    <tbody>";
             $total = 0;
             $totalEntregado = 0;
            foreach ($recursos as $value) {
                if ($value['estado'] == 2) {
                    $estado = "<span class ='full'>Entregado</span>";
                    $detalle = "<a href ='$value[codigopago]'  class='tbl-axpan'>[+]  </a> | <a target ='_blank' href ='index.php?fancy=factura&coidgopago=$value[codigopago]'>Descargar Factura</a> | "
                            . "<a target ='blank' href ='es-sengle_envio-$value[codigopago]'>Mi pedido</a>";
                            $totalEntregado = $totalEntregado + $value['valor_pagado'];
                } else {
                    if ($value['estado'] == 3) {
                        $estado = "<span class ='malo'>Cancelado</span>";
                    } else {
                        $estado = "<span class ='medium'>Solicitado</span>";
                    }
                    $detalle = "&nbsp;";
                }

                echo "<tr>
                            <td >$value[codigopago]</td>
                            <td>$value[fecha]</td>
                            <td  > $ ".number_format($value['valor_pagado'])." COP</td>
                            <td >$estado</td>
                            <td  ><button class ='gestion' val ='$value[codigopago]'> Gestionar</button></td>
                    </tr>";
                $total = $total + $value['valor_pagado'];
                
            }
            echo
            "</tbody>
                </table>"; 
                
                 echo "<h2>Total pedidos Entregados: $ ".number_format($totalEntregado )." COP</h2>";
                  echo "<h3>Total pedidos por entregar: $ ".number_format($total- $totalEntregado)." COP</h3>";
                    echo "<style>
                #descargareexcel{
            display:block;
        }
            </style>";
        }else{
            echo "No existen pedidos";
            echo "<style>
                #descargareexcel{
            display:none;
        }
            </style>";
        }
       
    }
    public function selectVentastodas($vector = false) {
        if($vector == 0){
           $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado "
                . " FROM pagos";

        }else{
           $fechaInicial =$vector['fechaini'];
           $fechafinal= $vector['fechaend'];
            $query = "SELECT idpagos, codigopago, fecha, estado, valor_pagado"
                . " FROM pagos where fecha  BETWEEN '$fechaInicial'  AND '$fechafinal'";
                        echo $query;
        }
        $recursos = $this->_modelo->selectPersonalizado($query);
        if ($recursos && $recursos->rowCount() > 0) {
            echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">"
            . "  <thead>
                    <tr>
                        <th >Código</th>
                        <th >Fecha</th>
                        <th >Valor pagado</th>
                     
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
    public function detallePagoFactura($codigoPago) {
        if (is_array($codigoPago)) {
            $valor = @$codigoPago['idpago'];
        } else {
            $valor = $codigoPago;
        }
        $query = "SELECT productos.nombre, 
       
        detalle_pago.cantidad, 
        detalle_pago.total 
       FROM detalle_pago
     
      
        INNER JOIN productos ON productos.idproducto = detalle_pago.id_producto
      
        INNER JOIN pagos ON detalle_pago.id_pago = pagos.codigopago
        WHERE detalle_pago.id_pago = '$valor' ";
        $recursos = $this->_modelo->selectPersonalizado($query);
        return $recursos;
    }
    public function detallePagoCliente($idpago){
        $query ="SELECT pagos.* , clientescompra.* FROM  pagos inner join 
        clientescompra on pagos.id_cliente =  clientescompra.cedulacliente WHERE pagos.codigopago = '$idpago'";
            $recursos = $this->_modelo->selectPersonalizado($query);
          return $recursos->fetch(PDO::FETCH_ASSOC);
    }
    public  function getinfoCliente($codigoPago){
          $query = " select clientescompra.* from clientescompra inner join pagos on pagos.id_cliente = clientescompra.cedulacliente 
            where pagos.codigopago = '$codigoPago' ";
          $recursos = $this->_modelo->selectPersonalizado($query);
          return $recursos->fetch(PDO::FETCH_ASSOC);
    }
    public function cambiarEstadoPedido($informacion){
        $campos = "estado = $informacion[estado]";
        $where ="codigopago = $informacion[codigopago]";
        $tabla ="pagos";
        try{
            $this->_modelo->updateStand($campos,$where,$tabla,0);
            echo "Su pedido ha cambiado de estado";
        }catch(Exeption $e){
            echo $e;
        }
       
    }
    public function reporteVentas($informacio){
        $query ="SELECT  detalle_pago.*, pagos.* , clientescompra.*, productos.* FROM  pagos
inner join clientescompra on  clientescompra.cedulacliente =  pagos.id_cliente 
inner join detalle_pago on pagos.codigopago =  detalle_pago.id_pago 
inner join productos on productos.idproducto = detalle_pago.id_producto  WHERE
            pagos.fecha  BETWEEN '$informacio[ini]'  AND '$informacio[fin]' order by pagos.codigopago asc";
        

     
         $recursos = $this->_modelo->selectPersonalizado($query);
         $registros = $recursos->rowCount();
         $tr ="";
    if($registros>0){
    
        foreach ($recursos as $key => $value) {
            $tr .=" <tr>
                        <td >$value[id_pago]</td>
                        <td  >$value[fecha]</td>
                        <td>$value[nombre]</td>
                        <td >$value[3]</td>
                        <td >$value[nombrecliente] $value[apellidocliente]</td>
                        <td >$value[id_cliente] </td>
                        <td >$value[costo]</td>
                         <td>".$value['costo'] * $value[3]."</td>
                    </tr>";
        }
        
    }
         return $tr;
    }
}