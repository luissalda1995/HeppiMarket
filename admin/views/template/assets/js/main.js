var vector = [];
var globaldata;
$(document).ready(function(){
   $("#form-login").submit(function(e){
        e.preventDefault();
     
       if(validarLogin()){
           var data =  $("#form-login").serialize();
          
           entrarAlpanel(data);
       }

   })
   $("#form-agregar-inventario").submit(function(e){
       e.preventDefault();
       if(validarInventario()){
            var data =  $("#form-agregar-inventario").serialize();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.

            agregarInventario(data);
       }
   })
    $("#form-agregar-inventario").submit(function(e){
       e.preventDefault();
       if(validarInventario()){
            var data =  $("#form-agregar-inventario").serialize();
            agregarInventario(data);
       }
   })
   $("#form-agregar-productos").submit(function(e){
        e.preventDefault();
        var data = $("#form-agregar-productos").serialize(); 
        var select =    $('#sltcategorias');
        select=   separarMultiselect(select);
        data = data+"&categorias="+select;
        agregarProducto(data);
   })
 
    $('.modal').on('hidden.bs.modal', function(e){ 
        $(this).removeData();
    }) ;
    $("#myModal").delegate("#formulario-seccion","submit",function(e){
        e.preventDefault();
        var stringData = $("#formulario-seccion").serialize();
         modificarSecciones(stringData)
       
    })
    $("#cargartodo").click(function(e){
        location.href ="index.php?vista=informe_ventas";
    })
    $("#cargartodo-dos").click(function(e){
        location.href ="index.php?vista=informe_ventas";
    })
    $(".gestion").click(function(e){
      e.preventDefault();
      location.href = "index.php?vista=gestionar_entregas&codigopago="+$(this).attr("val");
    })
    $("#btn-guardar-estado").click(function(e){
      e.preventDefault();
      var dataString = $("#cambiar_estado_pedido").serialize();
      cambiarEstadoPedido(dataString);
    })

 $("#btn-gurdarcambios-producto").click(function(e){
      
        var data = $("#form-editar-productos").serialize();
        guardarCambios(data);
    })

$("#btn-insertar-producto").click(function(e){
        var data = $("#form-insertar-productos").serialize();
        insertarProducto(data);
    })

  $(".del").click(function(e){
    var id = $(this).attr("val");
    dataString = "id="+id;
    var urlc = construirRuta("Productos", "eliminarItemInventario");
        var msgc = "Producto eliminado correctamente";
        ejecutarFuncion(dataString, urlc, false,msgc);
        console.log(globaldata);
        alert("Producto eliminado correctamente");
        location.reload();
        
  })
  
})