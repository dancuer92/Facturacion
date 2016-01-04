<?php
require_once('config.php');

$opcion = $_POST['opcion'];

if ($opcion === "listar") {
    listar();
}

function listar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $consultaBusqueda = $_POST['valorBusqueda'];
    $mensaje = "";
    $sql = "SELECT c.codigo_ciudad, c.nombre_ciudad , d.nombre_departamento FROM ciudad c, departamento d "
            . "WHERE c.cod_departamento=d.cod_departamento AND c.nombre_ciudad COLLATE utf8_spanish_ci "
            . "LIKE '%$consultaBusqueda%' ORDER BY c.codigo_ciudad ASC LIMIT 0,20";
    
    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ninguna ciudad registrada con el nombre de: '$consultaBusqueda'</p>";
    } else {        
        while ($resultados = mysqli_fetch_array($consulta)) {
            $codigo_ciudad=$resultados['codigo_ciudad'];
            $nombre_ciudad=$resultados['nombre_ciudad'];
            $nombre_departamento=$resultados['nombre_departamento'];
            $mensaje.='<li id="'.$codigo_ciudad.'" onclick="set_item('.$codigo_ciudad.')">'.$codigo_ciudad.'. '.$nombre_ciudad.', '.$nombre_departamento.'</li>'; //Output
        }
    }
    mysqli_close($conexion);
    echo $mensaje;
}
