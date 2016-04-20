<?php

//Llamada al script fpdf
require('fpdf.php');
$vector[]= array('Producto' =>"Camiseta rigo pro talla xs colo unico" ,
'Cantidad' =>1 ,
'Valor' =>150000);
$vector[] =  array('Producto' =>"Camiseta rigo clasci talla s color azul" ,
'Cantidad' =>2 ,
'Valor' =>20000);
$vector[] =  array('Producto' =>"Pantoleta rigo clasci talla l color unico" ,
'Cantidad' =>10 ,
'Valor' =>175000);

if ($_POST["generar_factura"] == "true")
{

//Recibir detalles de factura
$id_factura = $_POST["id_factura"];
$fecha_factura = $_POST["fecha_factura"];

//Recibir los datos de la empresa
$nombre_tienda = $_POST["nombre_tienda"];
$direccion_tienda = $_POST["direccion_tienda"];
$poblacion_tienda = $_POST["poblacion_tienda"];
$provincia_tienda = $_POST["provincia_tienda"];
$codigo_postal_tienda = $_POST["codigo_postal_tienda"];
$telefono_tienda = $_POST["telefono_tienda"];
$fax_tienda = $_POST["fax_tienda"];
$identificacion_fiscal_tienda = $_POST["identificacion_fiscal_tienda"];

//Recibir los datos del cliente
$nombre_cliente = $_POST["nombre_cliente"];
$apellidos_cliente = $_POST["apellidos_cliente"];
$direccion_cliente = $_POST["direccion_cliente"];
$poblacion_cliente = $_POST["poblacion_cliente"];
$provincia_cliente = $_POST["provincia_cliente"];
$codigo_postal_cliente = $_POST["codigo_postal_cliente"];
$identificacion_fiscal_cliente = $_POST["identificacion_fiscal_cliente"];

//Recibir los datos de los productos
$iva = $_POST["iva"];
$gastos_de_envio = $_POST["gastos_de_envio"];
$unidades = $_POST["unidades"];
$productos = $_POST["productos"];
$precio_unidad = $_POST["precio_unidad"];

//variable que guarda el nombre del archivo PDF
$archivo="factura-$id_factura.pdf";



$archivo_de_salida=$archivo;

$pdf=new FPDF();  //crea el objeto
$pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.


//logo de la tienda


// Encabezado de la factura
$pdf->SetFont('Arial','B',14);
$pdf->Cell(50, 45, $pdf->Image('../empresa.jpg' , 5 ,4, 40 , 40,'JPG', 'http://200.116.1.182/framework_v2/') ,0, 0, "C");
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