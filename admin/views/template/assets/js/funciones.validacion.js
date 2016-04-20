function validarLogin(){
    var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9]$/;
    var valor = $("#usuario").val();
    if (valor =="") {
        alert("El valor ingresado en usuario no es valido");
        $("#usuario").focus();
        return false;
    }else{
      
        var valor = $("#password").val();
        if (valor =="") {
            alert("la contraseña ingresada es valida");
            $("#password").focus();
            return false;
        }else{
            return true;
        }
    }
}
function validarInventario(){
    var valor = $("#sltproductos option:selected").val();
    if (valor == 0) {
        alert("Seleccione un producto por favor");
        return false;
    }else{
      
        var valor = $("#txtcantidad").val();
        if (valor == "" || valor == 0) {
            alert("La cantidad ingresada no es valida");
            $("#txtcantidad").focus();
            return false;
        }else{
            var valor = $("#slttallas option:selected").val();
            if (valor == 0) {
                alert("Seleccione un valor para talla");
                return false;
            }else{
                var valor = $("#sltcolor option:selected").val();
                if (valor == 0) {
                    alert("Seleccione un valor para color");
                    return false;
                }else{
                    var valor = $("#sltsexo option:selected").val();
                    if (valor == 0) {
                        alert("Seleccione un valor para sexo");
                        return false;
                    }else{
                        return true;
                    }
                }
            }
        }
    }
}
