<?php
Class ControllerCarrito extends ControllerMain{
    private $_modelo;
    private $table;
    public function __construct(){
        $this->_modelo = new ModelMain();
    }
    public function eliminarItem($vector){

        $i = intval($vector['producto']);
        for($x = $i+1;$x <= $_SESSION['contador'];$x++){
            if(@$_SESSION['carrito'][$x]['id']-1<0){
                $ind = 0;
            }else{
                $ind = $_SESSION['carrito'][$x]['id']-1;
            }  
            $_SESSION['carrito'][$x]['id'] = $ind;
            echo   $_SESSION['carrito'][$x]['id'];
        }
        unset($_SESSION['carrito'][$i]);
       
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
        $_SESSION['contador'] = $_SESSION['contador']-1;
        if($_SESSION['contador']==0){
            $this->vaciarCarrito($vector);
        }
    }
    public function addCarrito($vector){ 
        if($this->verificarexistencia($vector['producto'])){
            //Construyo el producto

            $arrayProducto = array("id"=>$_SESSION['contador'],
                "producto"=>$vector['producto'],
                "cantidad"=>$vector['cantidad']
                );
            //El array lo asigno a la variable de session
            $_SESSION['carrito'][]=$arrayProducto;
            //Aumento el valor del contador
            $_SESSION['contador']++;
            //Devuelvo este valor para llevar el control de la cantidad de productos
            echo $_SESSION['contador'];
            // print_r( $_SESSION['carrito']);
       }else{
           echo 0; 
        }
    }
    public  function vaciarCarrito($vector){
        unset($_SESSION['carrito']);
        unset($_SESSION['contador']);
    }
    public function verificarexistencia($producto){
        for($i = 0;$i< $_SESSION['contador'];$i++){
            if($_SESSION['carrito'][$i]['producto']==$producto){
                return false;
                break;
            }
        }
        return true;
    }
    public function modificarCantidadCart($vector){
        $i = intval($vector['ref']);
    
        $objeProducto = ControllerMain::makeObjects("Productos",1);
        $query ="SELECT * FROM productos where idproducto = $vector[registro]";
        
        $camposInventario = $objeProducto->productosBruto($query);

        if($vector['cantidad']>$camposInventario['cantidad']){
            echo "No hay suficiente existencia de este producto, actualmente hay ".$camposInventario['cantidad'];
        }else{
            //echo $_SESSION['carrito'][$i]['cantidad'];
            //print_r($_SESSION['carrito']);
            $_SESSION['carrito'][$i]['cantidad'] = $vector['cantidad'];
        
            $objeProducto = ControllerMain::makeObjects("Productos",1);
              echo $objeProducto->selectCantidad($camposInventario['cantidad'],2,$vector['cantidad']);
            
        }   
    }
    public function mostrarCarrito($lang){
        $objeProducto = ControllerMain::makeObjects("Productos",1);
        
        for($i = 0;$i< $_SESSION['contador'];$i++){
            
        
            for ($index = 0; $index < count($_SESSION['carrito']); $index++) {
                if(count($_SESSION['carrito'][$index])<3){
                    unset($_SESSION['carrito'][$index]);
                  $_SESSION['carrito'] =  array_values($_SESSION['carrito']);
                }
               
            }
        

            $campos = $objeProducto->selectProductoSengle($_SESSION['carrito'][$i]['producto']);
            // // $tallacolorsexo =$this->getTallasSexo($_SESSION['carrito'][$i]['talla'],$lang,$_SESSION['carrito'][$i]['color']);
            $cantidad = $_SESSION['carrito'][$i]['cantidad'];
            $res = $_SESSION['carrito'][$i]['id'];
            $producto = $_SESSION['carrito'][$i]['producto'];
           
            $queryCantidadProducto = "SELECT cantidad FROM productos where idproducto = $producto";
       
            $cantidadProducto = $objeProducto->productosBruto($queryCantidadProducto);
            echo "<div class=\"producto-cart-block\">
                        <img src = 'public".DS."productos".DS."$campos[img]' alt='$campos[seo]' />
                        <div class ='nombre-producto'>
                            <span class =\"rosa-text detalle\">$campos[nombre]</span>
                        </div>
                        <div>
                            <strong>Cantidad: </strong><br />
                            <select id ='cant$producto'  pro ='$producto'  res = '$res'name = 'txtcantidadcart' class ='txtcantidad'>"
                                .$objeProducto->selectCantidad($cantidad,2,$cantidadProducto['cantidad'])
                            . "</select>
                        </div>
                        <div id ='msg$producto' class ='existencia-cart'></div>
                       
                        <div class =\"inline\">
                            <span class =\"rosa-text\"> $ ".  number_format($campos['costo']*$_SESSION['carrito'][$i]['cantidad'])." COP </span>
                        </div><br /><br />
                        <a href='' class ='botones-carro eliminar-item '  res = '$res' id=' $producto'>Eliminar</a>
                </div>";
        }   
    }
    public function totalCart($sw=0, $num= false){
        $valor =0;
        for($i = 0;$i< $_SESSION['contador'];$i++){
           //Consulto el producto para conocer su valor
           $objeProducto = ControllerMain::makeObjects("Productos",1);
           $campos = $objeProducto->selectProductoSengle(@$_SESSION['carrito'][$i]['producto']);
           $valor = $valor +  $campos['costo']*$_SESSION['carrito'][$i]['cantidad'];
        }
        if($num !=false){
            return $valor;
        }else{
            if($sw==0){
                echo @number_format($valor);
            }else{
                 return @number_format($valor);
            }
        }
       
        
    }
    public function totalCartShop($sw=0, $num= false){
        $valor =0;
        for($i = 0;$i< $_SESSION['contador'];$i++){
           //Consulto el producto para conocer su valor
           $objeProducto = ControllerMain::makeObjects("Productos",1);
           $campos = $objeProducto->selectProductoSengle(@$_SESSION['carrito'][$i]['producto']);
           $valor = $valor +  $campos['costo']*$_SESSION['carrito'][$i]['cantidad'];
        }
        if($num !=false){
            return $valor;
        }else{
            if($sw==0){
                echo @number_format($valor);
            }else{
                 return @number_format($valor+5000);
            }
        }
       
        
    }
    public function totalCartjs(){
        $valor ="";
        for($i = 0;$i< $_SESSION['contador'];$i++){
           //Consulto el producto para conocer su valor
           $objeProducto = ControllerMain::makeObjects("Productos",1);
           $campos = $objeProducto->selectProductoSengle($_SESSION['carrito'][$i]['producto']);
           $valor = $valor +  $campos['costo']*$_SESSION['carrito'][$i]['cantidad'];
        }
        echo number_format($valor);
    }
    public function cosotroBruto(){
        $valor ="";
        for($i = 0;$i< $_SESSION['contador'];$i++){
           //Consulto el producto para conocer su valor
           $objeProducto = ControllerMain::makeObjects("Productos",1);
           $campos = $objeProducto->selectProductoSengle($_SESSION['carrito'][$i]['producto']);
           $valor = $valor +  $campos['costo']*$_SESSION['carrito'][$i]['cantidad'];
        }
       return $valor;
    }
    public function  pagarProductos($vector){
        
        if(isset($_SESSION['usuario'])){
          echo 0;   
        }else{
           echo "index.php?fancy=loguin";
        }
    }
   
}
?>