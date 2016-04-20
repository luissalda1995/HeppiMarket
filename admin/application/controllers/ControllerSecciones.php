<?php

Class ControllerSecciones extends ControllerMain {

    private $_modelo;
    private $msg_error;
    private $msg_good;

    public function __construct() {
        $this->_modelo = new ModelMain();
    }
    public function secciones(){
        $query = "SELECT * from secciones";
        $secciones = $this->_modelo->selectPersonalizado($query);
        
         echo "   <table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
        foreach ($secciones as $value) {
            if ($value['estado'] == 0) {
                $estado = "<span class=\"label-default label label-danger\">Desactivada</span>";
            } else {
               
                    $estado = "<span class=\"label-success label label-default\">Activa</span>";
                
            }
 
            echo "
                                <td class=\"center\">$value[id]</td>
                                <td class=\"center\">$value[nombre]</td>
                                <td class = \"center\"> $estado</td>
                                <td class=\"center\">



                                    <a data-toggle=\"modal\" class=\"btn btn-info\" data-target=\"#myModal\" href=\"index.php?fancy=addSecciones&seccion=$value[id]&nobrese=$value[nombre]\" data-toggle=\"modal\">
                                        <i class=\"glyphicon glyphicon-eye-close icon-white\"></i>
                                        Ver
                                    </a>
                                   <!-- <a class=\"btn btn-danger\" href=\"#\">
                                        <i class=\"glyphicon glyphicon-trash icon-white\"></i>
                                        Eliminar-->
                                    </a>
                                </td>
                            </tr>";
        }
        echo "</tbody>"
        . "</table>";
    }

    public function selectdetallesXSecciones($idsccione=4) {
        $query = "SELECT seccionxidioma.*,  idioma.nombre as nidioma, secciones.id as idseccion,secciones.nombre as nseccion FROM seccionxidioma inner join secciones on  secciones.id = seccionxidioma.seccion "
                . "inner join idioma on idioma.abrevitura =  seccionxidioma.idioma where  secciones.id = $idsccione";
//        echo $query;
        $secciones = $this->_modelo->selectPersonalizado($query);
        return  $secciones;
         
    }

    public function selectTalla($lang = "es") {
        $query = "SELECT * FROM tallas order by orden asc";
        $tallas = $this->_modelo->selectPersonalizado($query);
        return $this->crearSelect("idtallas", "nombre", "slttallas", $tallas, 1, "data-rel='chosen'");
    }

    public function selectSexo($lang = "es") {
        $query = "SELECT * FROM sexo order by sexo asc";
        $sexo = $this->_modelo->selectPersonalizado($query);
        return $this->crearSelect("idSexo", "sexo", "sltsexo", $sexo, 1, "data-rel='chosen'");
    }

    public function selectColor($lang = "es") {
        $query = "SELECT * FROM color order by nombre asc";
        $color = $this->_modelo->selectPersonalizado($query);
        return $this->crearSelect("idcolor", "nombre", "sltcolor", $color, 1, "data-rel='chosen'");
    }

    public function seletIdioma($lang = "es") {
        $query = "SELECT * FROM idioma order by nombre asc";
        $idioma = $this->_modelo->selectPersonalizado($query);
        return $this->crearSelect("abrevitura", "nombre", "sltidioma", $idioma, 1, "data-rel='chosen'");
    }

    public function seletCategorias($lang = "es") {
        $query = "SELECT * FROM categorias order by nombre asc";
        $categorias = $this->_modelo->selectPersonalizado($query);
        return $this->crearSelect("idcategorias", "nombre", "sltcategorias", $categorias, 1, "data-rel='chosen'", "class='selectpicker' multiple");
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

    public function cargarInventarioProducto() {
        $query = "SELECT productos.nombrem, inventario.cantidad, tallas.nombre, color.nombre, sexo.sexo FROM inventario 
        inner join tallas on tallas.idtallas = inventario.idtalla 
        inner join color on color.idcolor = inventario.idcolor 
        inner join sexo on sexo.idSexo = inventario.sexo
        inner join productos on productos.idproductos = inventario.idproducto order by productos.idproductos, tallas.orden asc";
        $inventario = $this->_modelo->selectPersonalizado($query);
        echo "   <table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Talla</th>
                                <th>Color</th>
                                <th>Sexo</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
        foreach ($inventario as $value) {
            if ($value[1] == 0 || $value[1] < 0) {
                $estado = "<span class=\"label-default label label-danger\">No hay</span>";
            } else {
                if ($value[1] > 0 && $value[1] <= 5) {
                    $estado = "<span class=\"label-warning label label-default\">Alerta</span>";
                } else {
                    $estado = "<span class=\"label-success label label-default\">Full</span>";
                }
            }
            echo "<td>$value[0]</td>
                                <td class=\"center\">$value[1]</td>
                                <td class=\"center\">$value[2]</td>
                                <td class=\"center\">
                                   $value[3]
                                </td>
                                <td class=\"center\">
                                    $value[4]
                                </td>
                               
                                 <td class=\"center\">
                                    $estado
                                </td>
                                <td class=\"center\">
                                    <a class=\"btn btn-info\" href=\"index.php?operation=&Controller=\">
                                        <i class=\"glyphicon glyphicon-edit icon-white\"></i>
                                        Editar
                                    </a>
                                    <a class=\"btn btn-danger\" href=\"#\">
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

        if ($this->_modelo->deleteStand("inventario", "idinventerio = $vectordata[id]"))
            echo 1;
        else
            echo "Se ha presentado un problema intentelo nuevamente";
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
    public function modificarSecciones($vector){
        //INGLES SECCION
        $titulouno = str_replace("\\", "\\\"", $vector['titulo1English']);
        $contenidouno = str_replace("\\", "\\\"", $vector['editor1']);
        $titulodos=str_replace("\\", "\\\"", $vector['titulo2English']);
        $contenidodos =str_replace("\\", "\\\"", $vector['editor2']);
        $imagenes = $vector['imgEnglish'];
        $table ="seccionxidioma";
        $campos = "titulouno= '$titulouno',"
                . " contenidouno =  '$contenidouno',"
                . " titulodos ='$titulodos',"
                . " contenidodos = '$contenidodos',"
                . "img = '$imagenes'";
        $where = "seccion = $vector[idregistro] and  idioma = 'en'";
        $this->_modelo->updateStand($campos,$where,$table,0);
        //ITALIANO SECCION
        $titulounoit = str_replace("\\", "\\\"", $vector['titulo1Italy']);
        $contenidounoit = str_replace("\\", "\\\"", $vector['editor5']);
        $titulodosit=str_replace("\\", "\\\"", $vector['titulo2Italy']);
        $contenidodosit =str_replace("\\", "\\\"", $vector['editor6']);
        $imagenesit = $vector['imgItaly'];
        $tableit ="seccionxidioma";
        $camposit = "titulouno= '$titulounoit',"
                . " contenidouno =  '$contenidounoit',"
                . " titulodos = '$titulodosit',"
                . " contenidodos = '$contenidodosit',"
                . "img = '$imagenesit'";
        $whereit = "seccion = $vector[idregistro] and  idioma = 'it'";
        
        //ESPAÑOL SECCION
        $titulounoes = str_replace("\\", "\\\"", $vector['titulo1Spanish']);
        $contenidounoes = str_replace("\\", "\\\"", $vector['editor3']);
        $titulodoses=str_replace("\\", "\\\"", $vector['titulo2Spanish']);
        $contenidodoses =str_replace("\\", "\\\"", $vector['editor4']);
        $imageneses = $vector['imgSpanish'];
        $tablees ="seccionxidioma";
        $camposes = "titulouno= '$titulounoes',"
                . " contenidouno =  '$contenidounoes',"
                . " titulodos = '$titulodoses',"
                . " contenidodos = '$contenidodoses',"
                . "img = '$imageneses'";
        $wherees = "seccion = $vector[idregistro] and  idioma = 'es'";
        try{
            $this->_modelo->updateStand($campos,$where,$table,0);
            $this->_modelo->updateStand($camposit,$whereit,$tableit,0);
            $this->_modelo->updateStand($camposes,$wherees,$tablees,0);
            echo "Registro actualizado exitosamente";
        }catch (Exception $e){
            echo $e;
        }
        
        
    }
}
