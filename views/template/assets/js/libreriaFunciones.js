var sw;
var fancy;
  
function chequearColor(talla,producto,idioma){
    $.post('index.php?operation=selectColor&controller=Productos',{talla:talla,producto:producto,idioma:idioma}, function(data){
       $("#colores").html(data);
    });
}
function selccionarGenero(talla,producto,idioma,color){
    $.post('accion-selectGenero-Productos',{talla:talla,producto:producto,idioma:idioma,color:color}, function(data){
       $("#sltgenero").html(data);
    });
}
function asignar(val){
   if(val == "1"){
       return false;
   }else{
       return true;
   }
}
//function verificarExistencia(talla,producto,idioma,color,cantidad,sexo){
//    $.ajax({
//        url: 'accion-consultarExistencia-Productos',
//        async: false,   // this is the important line that makes the request sincronous
//        type: 'post',
//        data:{},
//        success: function(data) {
//            console.log(data);
//            if(data != 1){
//                $("#mensaje").html(data);
//                 setTimeout( "limpirMensaje('#mensaje')", 2000 );
//                sw = 1;
//            }else{
//                sw = 0;
//            }
//        },
//        error: function(data){
//            console.log(data);
//        }
//    });
//    if(sw==0){
//        return true
//    }else{
//        return false;
//    }
//
//}
function limpirMensaje(caja){
     $(caja).html("");
}
function traducir(text,idioma){
    $.post('accion-translateJava-Main',{text:text,idioma:idioma}, function(data){
       alert(data);
    });
}
function agregarCarrito(cantidad, producto){
    $.post('index.php?operation=verificarCantidad&controller=Productos',{producto:producto,cantidad:cantidad}, function(data){
        if(data == 1){
            $.post('index.php?operation=addCarrito&controller=Carrito',{cantidad:cantidad,producto:producto}, function(data){
              if(data == 0){
                  alert("Este producto ya se encuentra en su lista de pedido verique el carrito de compras");
              }else{
                  $("#cantidad-cart").html(data);
                  $.post('index.php?operation=totalCartjs&controller=Carrito', function(data){
                  
                      $("#costo-cart").html("COP "+data+" $");
                  });
              }
          });
        }else{
           alert(data);
        }
    });

    
}
function vaciarCarrito(){
    $.post('index.php?operation=vaciarCarrito&controller=Carrito', function(data){
      console.log(data);
     location.reload(); 
     // windows.location.reload(); 
    });
}
function eliminarItemcart(producto){
    $.post('index.php?operation=eliminarItem&controller=Carrito',{producto:producto}, function(data){
      alert("El producto ha sido eliminado");
      //console.log(data);
       location.reload(); 
    });
}
function cambiarCantidad(cantidad,registro,ref){
     $.post('index.php?operation=modificarCantidadCart&controller=Carrito',{cantidad:cantidad,registro:registro,ref:ref}, function(data){
  
     location.reload();
    });
}
function cargarExistencias(talla,producto,idioma,color,sexo){
    $.post('accion-consultarExistencia-Productos',{talla:talla,producto:producto,idioma:idioma,color:color,sexo:sexo}, function(data){
        $("#txtcantidad").html(data);
    });
}
function validarSession(idioma,objeto){
    $.ajax({
        url: 'index.php?operation=pagarProductos&controller=Carrito',
        async: false,   // this is the important line that makes the request sincronous
        type: 'post',
        data:{idioma:idioma},
        success: function(data) {
           if(data != 0){
               fancy = data;
            }else{
                fancy = 1;
            }
        },
        error: function(data){
            console.log(data);
        }
    });
    return fancy;
}


function marcarSelect(select,valor){
    var lista = document.getElementById(select);
    for (i = 0; i < lista.options.length; i++) {
        if (lista.options[i].value == valor) {
            lista.options[i].setAttribute("selected","");
        }
    }
}
function hacerCompra(dataString, idioma){
    alert("Procesando pedido");
    $.post('index.php?operation=conectarwebservices&controller=Pasarella',dataString, function(data){
       
      alert(data);
      location.href="index.php?vista=cart";
       
    });
}
function agregarNuevousuario(dataString){

    $.post('index.php?operation=registrarUsuario&controller=Usuarios',dataString, function(data){
       if(data == "11"){
           alert("Bienvenido a su tienda Heppi");
           location.reload();
       }else{
        alert(data);
       }
    });
}
function guardarPerfil(dataString){
    $.post('index.php?operation=guardarPerfil&controller=Usuarios',dataString, function(data){
       alert(data);
    });
}
function iniciarSession(dataString,idioma){

    $.post('index.php?operation=iniciarSession&controller=Usuarios',dataString, function(data){
       //console.log(data);
       if(data == 2){
           alert("Bienvenido a si tienda Heppi");
           parent.location.href = "index.php?vista=tramitar_pedido";
       }else if (data == 1){
           parent.location.reload();
       }else{
           alert(data);
       }
    });
}
function contactarCliente(dataString){
     $.post('accion-contactarCliente-Contacto',dataString, function(data){
       alert(data);
       location.reload();
    });
}
function contactarPrensa(dataString){
     $.post('accion-contactarPrensa-Contacto',dataString, function(data){
       alert(data);
       location.reload();
    });
}
function cargarprodutos(href){
     $.post(href,function(data){
      $("#contenedor-productos").html(data);
      
     
       //location.reload();
    });
}
function ejecutarFuncion(data,url,swreturn,msg){
 
        var dataFull = data;

        $.ajax({
            type:'post',
        data:data, 
        url: url,
        async: swreturn,
        dataType:'html',
     
        beforeSend: function (objeto) {
           // alert(msg);
        },
     
      
        dataType: "html",
        error: function (objeto, quepaso, otroobj) {
            alert("Estas viendo esto por que fallé");
            alert("Pasó lo siguiente: " + quepaso);
        },
        global: true,
        ifModified: false,
        processData: true,
        success: function (datos) {
            if(swreturn){
                 if(datos == 0){
                    ejecutarFuncion(dataFull,url,swreturn)
                }else{
                     console.log(datos);
                }
               
            } else {
                if(datos == 1){
                    //ejecutarFuncion(dataFull,url,swreturn)
                }else{
                    globaldata =  datos;
                }
                
            }
   
        },
        timeout: 3000,
        type: "GET"
    });

}
function construirRuta(controlador,accion){
  return "index.php?controller="+controlador+"&operation="+accion+"";
}