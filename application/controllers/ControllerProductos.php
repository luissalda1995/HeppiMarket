<?php

Class ControllerProductos extends ControllerMain {
    private $_modelNoticias;
    private $table;
    private $msg_error;
    private $msg_good;

    public function __construct() {
        $this->_modelo = new ModelMain();
        $this->table = "producto";
        $this->msg_error = "Error. Intente nuevamente, si el problema pesiste contáctenos";
        $this->msg_good = "La Operación se realiazo con exito";
    }
    public function verificarCantidadAnular($info){
        $query ="SELECT * FROM productos WHERE idproducto = $info[producto]";
        $productos = $this->_modelo->selectPersonalizado($query);
        if($productos->rowCount()>0){
            $arrayPro = $productos->fetch(PDO::FETCH_ASSOC);
            echo $arrayPro['cantidad'];
        }
    }
    public function verificarCantidad($info){
        $query ="SELECT * FROM productos WHERE idproducto = $info[producto]";
        $productos = $this->_modelo->selectPersonalizado($query);
        if($productos->rowCount()>0){
            $arrayPro = $productos->fetch(PDO::FETCH_ASSOC);
            if($arrayPro['cantidad']>= $info['cantidad']){
                echo 1;
            }else{
                echo "En este momento la cantidad de producto es de $arrayPro[cantidad] unidades, pronto tendremos más unidades disponibles!.";
            }
        }
    }
    public function selectProducto($vector) {

        if($vector['categoria']==0 || $vector['categoria']==""){
             $query ="SELECT * FROM productos  WHERE estado = 1 order by nombre, orden asc";
        }else{
             $query ="SELECT * FROM productos WHERE  estado = 1 AND  categoria = $vector[categoria] order by nombre, orden asc";
        }
        $productos = $this->_modelo->selectPersonalizado($query);
        $n = 0;
        if($productos && $productos->rowCount()>0){
            foreach ($productos as $value) {
            echo "<div class=\"content-producto\">
                        <img width='250' class='imagenes' src=\"public/productos/$value[img]\" /><br />
                        <h3 class =\"titulo-producto\">$value[nombre]</h3><br />
                        <p class =\"desp-producto\">$value[descripcion]</p>
                        <div class=\"delay-informacion\">
                            <span>Valor <br />
                                $ $value[costo] COP</span>
                            <span><a class = 'addcart' valpro= '$value[idproducto]' href =\"#\"><img  src=\"".RECURSOS."img".DS."add-cart.png\" /></a></span>
                        </div>
                </div>
          
                ";
            }
        }else{
            echo "Actualmente no hay inventario cargado";
        }
        
    }
    public function productosBruto($query) {
        $tallas = $this->_modelo->selectPersonalizado($query);
        return $tallas->fetch(PDO::FETCH_ASSOC);
    }
    public function selectProductoSengle($idproducto){
        $query ="SELECT * FROM productos WHERE cantidad > 0 and idproducto = $idproducto";
        $productos = $this->_modelo->selectPersonalizado($query);
       
        if($productos && $productos->rowCount()>0){
           $array =  $productos->fetch(PDO::FETCH_ASSOC);
           return $array;
        }
    }
    public function selectCategorias() {

        $query ="SELECT * FROM categorias WHERE estado = 1";
        $categorias = $this->_modelo->selectPersonalizado($query);
        $n = 0;
        if($categorias && $categorias->rowCount()>0){
            echo "<ul  id ='categorias'>";
            echo "<li>
            <a  id ='actual' href='index.php?operation=selectProducto&controller=Productos&categoria=0' class ='btncategorias' >
            Todas las categorías</a></li>";
            foreach ($categorias as $value) {
                echo "<li><a  href='index.php?operation=selectProducto&controller=Productos&categoria=$value[idcategoria]' class ='btncategorias'>Categoría $value[categoria]</a></li> ";
            }
            echo "</ul>
           ";
        }else{
            echo "Actualmente no hay inventario cargado";
        }
        
    }
  public function selectCantidad($cantidad,  $sw = 1, $cantOr = false) {
        $select ="";
        if ($sw == 1) {
            $select = "<option value ='0'>Cant .</option>";
            for ($index = 1; $index <= $cantidad; $index++) {
                $select .= "<option value ='$index'>$index</option>";
            }
        } else if ($sw == 2) {
            $select = "";
            if ($cantOr != false) {
                for ($index = 1; $index <= $cantOr; $index++) {
                    if ($cantidad == $index) {
                        $select .= "<option selected='' value ='$index'>$index</option>";
                    } else {
                        $select .= "<option value ='$index'>$index</option>";
                    }
                }
            } else {
                for ($index = 1; $index <= $cantidad; $index++) {
                    if ($cantidad == $index) {
                        $select .= "<option selected='' value ='$index'>$index</option>";
                    } else {
                        $select .= "<option value ='$index'>$index</option>";
                    }
                }
            }
        }
        return $select;
    }   
 
}
