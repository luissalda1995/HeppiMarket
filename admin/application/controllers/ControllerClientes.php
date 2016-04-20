<?php

Class ControllerClientes extends ControllerMain {
    public function __construct() {
        $this->_modelo = new ModelMain();
    }
    public function selectClientes() {
       
       $query = "SELECT * from clientescompra";
      
        $recursos = $this->_modelo->selectPersonalizado($query);
       
        if ($recursos && $recursos->rowCount() > 0) {
            echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">"
            . "  <thead>
                    <tr>
                        <th >Cédula</th>
                        <th >Nombre</th>
                        <th >Teléfono</th>
                        <th>E-mail</th>
                         <th>Login</th>
                        <th   >Pais</th>
                        <th   >Ciudad</th>
                        <th   >Departamento</th>
                        <th   >Dirección</th>
                        <th   >Registro</th>
                    </tr>
                    </thead>
                    <tbody>";
             $total = 0;
            foreach ($recursos as $value) {

                echo "<tr>
                            <td >$value[cedulacliente]</td>
                            <td>$value[nombrecliente] $value[apellidocliente]</td>
                            <td>$value[telefonocliente]</td>    
                           <td>$value[mailcliente]</td>
                           <td>$value[usuarologuin]</td>
                            <td>$value[pais]</td>
                             <td>$value[ciudad]</td>
                                 <td>$value[departamento]</td>
                                  <td>$value[direccionentrega]</td>
                                   <td>$value[fecharegistro]</td>
                    </tr>";
                
            }
            echo
            "</tbody>
                </table>";
               
        }else{
            echo "No existen CLientes por el momento";
        }
       
    }
    
}