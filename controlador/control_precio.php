<?php
require_once('config.php');

$opcion = $_POST['opcion'];

if ($opcion === "registrar") {
    registrar();
}

if ($opcion === "mostrar") {
    mostrar();
}

function registrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }    
    $cod=$_POST['cod'];
    $nombre = $_POST['nombre'];    
    $peso = (int) $_POST['peso'];
    $cant = (int) $_POST['unid'];    
    $precio = (int) $_POST['precio'];   
    
    $mensaje = "";

    $sql = "INSERT INTO precio(cod_cliente, producto_nombre, producto_peso, producto_cantidad_chorizos, precio) "
            . "VALUES ('$cod','$nombre','$peso','$cant','$precio')"
            . "ON DUPLICATE KEY UPDATE precio='$precio';";
    if (mysqli_query($conexion, $sql)) {
        $mensaje = ("Precio actualizado con éxito");
    } else {
        $mensaje = ("Error al registrar precio, vuelva a intentarlo");
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function mostrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }    
    
    $nombre = $_POST['valorBusqueda']; 
    $mensaje = "";

    $sql = "SELECT p.producto_nombre, p.producto_peso, p.producto_cantidad_chorizos, p.precio "
            . "FROM precio p "
            . "WHERE p.cod_cliente='$nombre';";
    
    $consulta = mysqli_query($conexion, $sql);
    $filas = mysqli_num_rows($consulta);
    
    if ($filas === 0) {
        $mensaje = "<p>No hay productos asociados al cliente</p>";
    } else {
        $mensaje = '<h5><i class="material-icons prefix" >info</i>Catálogo actual</h5> 
            <table id="catalogoCliente" class="highlight centered responsive-table"> 
                <thead>
                    <tr>                        
                        <th data-field="paqueteCliente">Paquete de producto</th>                       
                        <th data-field="precioCatalogo">Precio al cliente</th>                 
                    </tr>
                </thead>
                <tbody>';
        $index=0;

        while ($resultados = mysqli_fetch_array($consulta)) {
            $paquete=$resultados[0].' '.$resultados[1].' gr. '.$resultados[2].' unidades';
            $cadena=$resultados[0].'-'.$resultados[1].'-'.$resultados[2].'-precio'.$index;
            $mensaje.='<tr>
                        <td>' . $paquete . '</td>                        
                        <td><input id="precio'.$index.'" value="'.$resultados[3].'" maxlength="11" disabled="true"></td>
                        </tr>'; //Output            
            $index++;
        }
        $mensaje.='</tbody></table>';
    }
    $mensaje2=  str_replace("&", "'", $mensaje);
    mysqli_close($conexion);
    echo $mensaje2;
}

