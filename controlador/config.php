<?php

function Conexion() {

    /* Si estas hacienda este
      tutorial desde tu PC con XampServer deja estos datos como estan */

    if (!($link = mysqli_connect("localhost", "root", ""))) {
        echo "Error conectando a la base de datos.";
        exit();
    }

    /* en nombre_BD va el nombre de la BD que creaste al principio */

    if (!mysqli_select_db($link, "pasantia")) {
        echo "Error seleccionando la base de datos.";
        exit();
    }
    return $link;
}

$link = Conexion();

mysqli_close($link); //cierra la conexion
?>