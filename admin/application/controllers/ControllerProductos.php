<?php

Class ControllerProductos extends ControllerMain {

    private $table;
    private $msg_error;
    private $msg_good;

    public function __construct() {
        $this->_modelo = new ModelMain();
        $this->table = "producto";
        $this->msg_error = "Error. Intente nuevamente, si el problema pesiste contáctenos";
        $this->msg_good = "La Operación se realiazo con exito";
    }

    public function selectProducto($lang = "es") {
        $query = "SELECT * FROM productos where estado = 1;";
        $productos = $this->_modelo->selectPersonalizado($query);

        return $this->crearSelect("idproductos", "nombrem", "sltproductos", $productos, 1, "data-rel='chosen'");
    }

   

   
    public function seletCategorias($lang = "es") {
        $query = "SELECT * FROM categorias order by orden asc";
        $categorias = $this->_modelo->selectPersonalizado($query);
        $option ="";
        foreach ($categorias as $key => $value) {
             $option .="<option value ='$value[idcategoria]'>$value[categoria]</option>";
         } 
        //return $this->crearSelect("idcategoria", "categoria", "sltcategorias", $categorias, 1, "data-rel='chosen'", "class='selectpicker' multiple");
          return $option;
    }

    public function insertarProducto($vectorData) {
        $query = "INSERT INTO inventario` (`cantidad`, `idtalla`, `idcolor`, `idproducto`, `sexo`) "
                . "VALUES ('$vectorData[txtcantidad]', '$vectorData[slttallas]', '$vectorData[sltcolor]', '$vectorData[sltproductos]', '$vectorData[sltsexo]')";
        $queryExistencia = "SELECT * FROM inventario WHERE idtalla = '$vectorData[slttallas]' "
                . "AND  idcolor = '$vectorData[sltcolor]' "
                . "AND  idproducto = '$vectorData[sltproductos]' "
                . "AND sexo = '$vectorData[sltsexo]'";
        $existe = $this->_modelo->selectPersonalizado($queryExistencia);
        if ($existe->rowCount() == 0) {

            $valores = array();
            $fiels = $this->getFieldsTable('inventario');
            $valores[] = "null";
            $valores[] = $vectorData['txtcantidad'];
            $valores[] = $vectorData['slttallas'];
            $valores[] = $vectorData['sltcolor'];
            $valores[] = $vectorData['sltproductos'];
            $valores[] = $vectorData['sltsexo'];
            try {
                $this->_modelo->insertStand($fiels, $valores, 'inventario');
                echo 1;
            } catch (Exception $e) {
                echo "Se ha presentado un problema por favor intenta nuevamente";
            }
        } else {
            echo "Ya existe un registro con las mismas características revisa el inventario y cambia su cantidad";
        }
    }

    public function cargarInventarioProducto($sw = 1) {
        if($sw ==1){
             $query = "SELECT  categorias.categoria, productos.* FROM productos inner join categorias on categorias.idcategoria = productos.categoria and productos.estado  = 1 order by productos.nombre asc";
        }else{
             $query = "SELECT  categorias.categoria, productos.* FROM productos inner join categorias on categorias.idcategoria = productos.categoria order by productos.nombre asc";
        }
        
      
        $inventario = $this->_modelo->selectPersonalizado($query);
        echo "   <table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Categoría</th>
                                <th>Costo</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
        foreach ($inventario as $value) {
            if ($value['cantidad'] == 0 || $value['cantidad'] < 0) {
                $estado = "<span class=\"label-default label label-danger\">No hay</span>";
            } else {
                if ($value['cantidad'] > 0 && $value['cantidad'] <= 5) {
                    $estado = "<span class=\"label-warning label label-default\">Alerta</span>";
                } else {
                    $estado = "<span class=\"label-success label label-default\">Full</span>";
                }
            }
            echo "<td>$value[nombre]</td>
                                <td class=\"center\">$value[cantidad]</td>
                                <td class=\"center\">$value[categoria]</td>
                                <td class=\"center\">
                                   $value[costo]
                                </td>
                                <td class=\"center\">
                                   $estado 
                                </td>
                                <td class=\"center\">
                                    <a class=\"btn btn-info\" href=\"index.php?vista=editar_producto&idProducto=$value[idproducto]\">
                                        <i class=\"glyphicon glyphicon-edit icon-white\"></i>
                                        Editar
                                    </a>
                                    <a val='$value[idproducto]' class=\"btn del btn-danger\" href=\"#\">
                                        <i class=\"glyphicon glyphicon-trash icon-white\"></i>
                                        Eliminar
                                    </a>
                                </td>
                            </tr>";
        }
        echo "</tbody>"
        . "</table>";
    }
   public function eliminarItemInventario($vectordata) {

      $this->_modelo->deleteStand("productos", "idproducto = $vectordata[id]");

    }

    public function productosBruto($query) {
        $tallas = $this->_modelo->selectPersonalizado($query);
        return $tallas->fetch(PDO::FETCH_ASSOC);
    }

    public function selectTallas($idproducto, $lang = "es") {
        $checks = "";
        $query = "SELECT tallas.* FROM "
                . "inventario inner join tallas on inventario.idtalla = tallas.idtallas "
                . "where inventario.idproducto = $idproducto and inventario.cantidad > 0 group by tallas.nombre order by tallas.orden asc";
        $tallas = $this->_modelo->selectPersonalizado($query);
        $n = 0;
        foreach ($tallas as $itemtallas) {
            if ($n == 0) {
                $checks .= "<span class ='label-content'>"
                        . "<span class ='label'>$itemtallas[nombre]</span>"
                        . "<input type ='radio' class ='tallas-check' checked name ='talla' value ='$itemtallas[idtallas]' />"
                        . "</span>";
                $n = $itemtallas['idtallas'];
            } else {
                $checks .= "<span class ='label-content'>"
                        . "<span class ='label'>$itemtallas[nombre]</span>"
                        . "<input type ='radio' class ='tallas-check'  name ='talla' value ='$itemtallas[idtallas]' />"
                        . "</span>";
            }
        }
        $dataquery = array("producto" => $idproducto, "talla" => $n, "idioma" => $lang);
        $colores = $this->selectColor($dataquery, $sw = 1);
        return $checks . "<div class ='tallas content-info'>" . $this->translate("Color", $lang) . ":<select id='colores' name = 'colores'><option value =\"0\">" . $this->translate("Seleccione", $lang) . " " . $this->translate("Color", $lang) . "</option>$colores</select>"
                . "</div>";
        ;
    }

    public function selectProductoSengle($idProducto, $lang) {
        $query = "select productos.*, "
                . "detallexproducto.* from detallexproducto "
                . "inner join productos on detallexproducto.idproducto = productos.idproductos "
                . "where detallexproducto.idioma = '$lang' and productos.idproductos = $idProducto";
        $productos = $this->_modelo->selectPersonalizado($query);
        return $productos->fetch(PDO::FETCH_ASSOC);
    }

    public function selectGenero($vector) {
        $colores_select = "";
        $query = "SELECT color.*, colorexidioma.nombreidioma,inventario.sexo FROM inventario 
        inner join color on inventario.idcolor = color.idcolor inner join colorexidioma on color.idcolor = colorexidioma.color 
        where inventario.idproducto =$vector[producto]  and inventario.idtalla = $vector[talla] and colorexidioma.idioma='$vector[idioma]' and inventario.idcolor = $vector[color]";
        $genero = $this->_modelo->selectPersonalizado($query);
        echo "<option value =\"0\">Seleccione Genero</option>";
        foreach ($genero as $itemgenero) {
            if ($itemgenero['sexo'] == 1) {
                echo "<option value ='1'>" . $this->translate("Hombre", $vector['idioma']) . "</option>";
            } else {
                if ($itemgenero['sexo'] == 2) {
                    echo "<option value ='2'>" . $this->translate("Mujer", $vector['idioma']) . "</option>";
                } else {
                    if ($itemgenero['sexo'] == 3) {
                        echo "<option value ='3'>" . $this->translate("Ambos", $vector['idioma']) . "</option>";
                    }
                }
            }
        }
    }

    public function consultarExistencia($vector) {

        $query = "SELECT color.*,inventario.sexo,inventario.cantidad,inventario.idtalla,inventario.idcolor  
        FROM inventario 
        inner join color on inventario.idcolor = color.idcolor  
        where inventario.idproducto =$vector[producto] 
        and inventario.idtalla = $vector[talla]  
        and inventario.idcolor = $vector[color] 
        and inventario.sexo = $vector[sexo]";
        $existencia = $this->_modelo->selectPersonalizado($query);
        $vectorValor = $existencia->fetch(PDO::FETCH_ASSOC);
        $num_rows = $existencia->rowCount();
        if ($num_rows >= 0) {
            echo $this->selectCantidad($vectorValor['cantidad'], $vector['idioma']);
        } else {
            echo "Error";
        }
    }

    public function selectCategorias($idProducto, $lang) {
        $query = "SELECT categoriaxidioma.nombre from categorias 
        inner join categoriaxidioma on categorias.idcategorias = categoriaxidioma.categoria
        inner join categoriaxproducto on categorias.idcategorias = categoriaxproducto.categoria
        where categoriaxidioma.idioma = '$lang' and categoriaxproducto.idproducto = $idProducto";
        $categorias = $this->_modelo->selectPersonalizado($query);
        return $categorias;
    }

    public function agregarProductos($vector) {
        $respuesta = $this->insertarTablaproducto($vector);
        print_r($respuesta);
        if ($respuesta['apro'] ==1) {
            $vector['idproducto'] = $respuesta['id'];
            if($this->insertarDetalleproducto($vector)){
                 $this->agregarCategorias($vector);
                 echo "full";
            }else{
                echo "no categorias";
            }
        }else{
            echo "no detalles";
        }
    }

    public function insertarTablaproducto($vector) {
        $valores = array();
        $fiels = $this->getFieldsTable('productos');
        $valores[] = "null";
        $valores[] = "'".$vector['txtnombre']."'";
        $valores[] = "'1'";
        $valores[] = "'".$vector['txtimagenuno']."'";
        $valores[] = "'".$vector['txtimagendos']."'";
        $valores[] = "'".$vector['txtimagentres']."'";
        $valores[] = "'".$vector['txtimagencuatro']."'";
        $valores[] = $vector['txtcosto'];
        $valores[] = $vector['txtcostotachado'];
        $valores[] = "'".$vector['txtseo']."'";
        $valores[] = "'".$vector['txtorden']."'";
        $valores[] = "'".$vector['txtref']."'";
        try {
            $respuesta = $this->_modelo->insertStand($fiels, $valores, 'productos');
            $queryid ="SELECT MAX(idproductos) as id FROM productos";
            $vectorid = $this->_modelo->selectPersonalizado($queryid);
            $queryid = $vectorid->fetch(PDO::FETCH_ASSOC);
            $vectorRes['apro'] = 1;
            $vectorRes['id'] = $queryid ['id'];

            return $vectorRes;
        } catch (Exception $e) {
            return false;
        }
    }

    public function insertarDetalleproducto($vector) {
        $query = "INSERT INTO detallexproducto(nombre, descripcion,idioma,idproducto)VALUES  
         (\"$vector[txtnamespa]\",\"$vector[descripes]\",\"es\",$vector[idproducto]),
         (\"$vector[txtnamesen]\",\"$vector[descripen]\",\"en\",$vector[idproducto]),
         (\"$vector[txtnombreita]\",\"$vector[descripit]\",\"it\",$vector[idproducto])";
        try {
            $respuesta = $this->_modelo->insertPersonalizado($query);
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function agregarCategorias($vector){
        $query = "INSERT INTO categoriaxproducto(idproducto, categoria) VALUES";
        $converVector = explode(",",$vector['categorias']);
        $n=0;
        foreach ($converVector as $value) {
            if($n != (count($converVector)-1)){
                $query .=" ($vector[idproducto],$value),";
            }else{
                $query .=" ($vector[idproducto],$value)";
            }
            $n++;
        }
         try {
            $respuesta = $this->_modelo->insertPersonalizado($query);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function selecccionarProducto($informacio){
        $query ="SELECT * from productos where idproducto = $informacio[idProducto]";
        $existencia = $this->_modelo->selectPersonalizado($query);
       
        $num_rows = $existencia->rowCount();
        if($num_rows > 0){
             $vectorValor = $existencia->fetch(PDO::FETCH_ASSOC);
             return $vectorValor;

        }else{
            return false;
        }
    }
    public function guardarCambiosProducto($informacio){
        $fields ="
        img = '$informacio[txtimagenuno]',
        nombre = '$informacio[txtnombre]',
        descripcion = '$informacio[descripcion]',
        orden = '$informacio[txtorden]', 
        costo = $informacio[txtcosto],
        cantidad = $informacio[txcantidad],
        estado = $informacio[estado],
        seo = '$informacio[txtseo]',
        categoria = $informacio[categorias],
        imgnutricional = '$informacio[imagenNutricional]',
        descripcionnutricional = '$informacio[descripcionNutricional]'
        ";
        $where ="idproducto = $informacio[idproducto]";
        try {
             $this->_modelo->updateStand($fields,$where,"productos",0);
             echo "Los datos del producto se han cambiado correctamente";
        } catch (Exception $e) {
            echo $e;
        }
       
    }
    public function insertarProductoTienda($vector){
        $valores = array();
        $fiels = $this->getFieldsTable('productos');
        $valores[] = "null";
        $valores[] = "'".$vector['txtimagenuno']."'";
        $valores[] = "'".$vector['txtnombre']."'";
        $valores[] = "'".$vector['descripcion']."'";
        $valores[] = "'".$vector['txtorden']."'";
        $valores[] = "".$vector['txtcosto']."";
        $valores[] = "".$vector['txcantidad']."";
        $valores[] = 1;
        $valores[] =  "'".$vector['txtseo']."'";
        $valores[] = "".$vector['categorias']."";
        $valores[] = "'".$vector['imagenNutricional']."'";
        $valores[] = "'".$vector['imagenNutricional']."'";
        $valores[] = "'".$vector['descripcionNutricional']."'";
        try {
            $respuesta = $this->_modelo->insertStand($fiels, $valores, 'productos');
            echo "El producto se ha insertado correctamente";
            
        } catch (Exception $e) {
            echo $e;
        }
    }
   
}
