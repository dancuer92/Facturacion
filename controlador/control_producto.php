<?php

require_once('config.php');

$opcion = $_POST['opcion'];

if ($opcion === "registrar") {
    registrar();
}

if ($opcion === "listar") {
    listar();
}

if($opcion==="getProductos"){
    getProductos();
}

if($opcion==="mostrar"){
    mostrar();
}

function registrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }    
    $nombre = $_POST['nombre'];    
    $peso = (int) $_POST['peso'];
    $cant = (int) $_POST['cant'];    
    $precio = (int) $_POST['precioPro'];    
    $inventario = (int) $_POST['inventario'];    
    $mensaje = "";

    $sql = "INSERT INTO producto(nombre, peso, num_chorizos, precio_publico, cant_inventario) "
            . "VALUES ('$nombre','$peso','$cant','$precio','$inventario');";
    if (mysqli_query($conexion, $sql)) {
        $mensaje = ("Producto registrado con éxito");
    } else {
        $mensaje = ("Error al registrar producto, ya existe en el sistema");
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function listar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $mensaje = "";    
    $sql = "SELECT * FROM producto p;";

    $consulta = mysqli_query($conexion, $sql);
    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ningún producto registrado'</p>";
    } else {        
        $mensaje.='<table id="productos" class="highlight centered responsive-table"> 
                <thead>
                    <tr>                        
                        <th data-field="descripcio">Nombre de producto</th>
                        <th data-field="peso">Peso del producto (gr)</th> 
                        <th data-field="unidades">Unidades por paquete</th> 
                        <th data-field="precio">Precio al público ($)</th> 
                        <th data-field="botMod"></th> 
                    </tr>
                </thead>
                <tbody>';
        while ($resultados = mysqli_fetch_array($consulta)) {            
            $mensaje.='<tr>                        
                        <td>'.$resultados[0].'</td>
                        <td>'.$resultados[1].'</td>
                        <td>'.$resultados[2].'</td>
                        <td>'.$resultados[3].'</td>
                        <td>Modificar</td>
                    </tr>
                </tr>';                   
        }
         $mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function getProductos() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $mensaje = "";
    $sql = "SELECT  p.nombre, p.peso, p.num_chorizos, p.precio_publico "
            . "FROM producto p ;";

    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay productos registrados</p>";
    } else {
        $mensaje = '<h5><i class="material-icons prefix">edit</i>Añadir productos al catálogo</h5>
            <table id="catalogo" class="highlight centered responsive-table"> 
                <thead>
                    <tr>                        
                        <th data-field="paqueteCat">Paquete de producto</th>
                        <th data-field="precioPub">Precio al público</th>                        
                        <th data-field="precioCat">Precio al cliente</th>                 
                    </tr>
                </thead>
                <tbody>';
        $index=0;

        while ($resultados = mysqli_fetch_array($consulta)) {
            $paquete=$resultados[0].' '.$resultados[1].' gr. '.$resultados[2].' unidades';
            $cadena=$resultados[0].'-'.$resultados[1].'-'.$resultados[2].'-precio'.$index;
            $mensaje.='<tr>
                        <td>' . $paquete . '</td>
                        <td> $' . $resultados[3] . '</td>
                        <td><input id="precio'.$index.'" maxlength="11" onblur="edit(&'.$cadena.'&)"></td>
                        </tr>'; //Output
            
            $index++;
        }
        $mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    $mensaje2=  str_replace("&", "'", $mensaje);
    echo $mensaje2;
}

function mostrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $mensaje = "";    
    $sql = "SELECT p.nombre FROM producto p GROUP BY p.nombre;";

    $consulta = mysqli_query($conexion, $sql);
    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ningún producto registrado'</p>";
    } else {
        while ($resultados = mysqli_fetch_array($consulta)) {
            $mensaje.='<li onclick="set_item_productos(&'.$resultados[0].'&)">'.$resultados[0].'</li>';        
        }
    }
    mysqli_close($conexion);
    $mensaje2=  str_replace("&", "'", $mensaje);
    echo $mensaje2;
}


//
//function listar() {
//    $link = Conectarse();
//    $sql = 'SELECT u.id, u.nombre, u.cedula, u.correo, u.clave, u.id_facultad, u.tipo, u.estado, f.nombre as nombre_facultad FROM usuarios u JOIN facultades f ON u.id_facultad = f.id where u.id != 1';
//    $result = mysql_query($sql, $link);
//    mysql_close($link);
//    $respuesta = array();
//
//    if (mysql_num_rows($result) != 0) {
//        $datos = array();
//        while ($row = mysql_fetch_array($result)) {
//            $usuario = new Usuario();
//            $usuario->crear($row);
//            array_push($datos, $usuario);
//        }
//        $respuesta['datos'] = $datos;
//        $respuesta['status'] = 'ok';
//        print_r(json_encode($respuesta));
//    } else {
//        $respuesta['status'] = 'not';
//        print_r(json_encode($respuesta));
//    }
//}

//function cargarUsuario() {
//
//    $id = $_POST['id'];
//    $link = Conectarse();
//    $sql = 'SELECT  FROM `usuarios` where id = ' . $id;
//    $sql = 'SELECT u.id, u.nombre, u.cedula, u.correo, u.tipo, u.estado, u.id_facultad, f.nombre as nombre_facultad FROM usuarios u LEFT JOIN facultades f ON u.id_facultad = f.id WHERE u.id = ' . $id;
//    $result = mysql_query($sql, $link);
//    mysql_close($link);
//
//    $respuesta = array();
//
//    if (mysql_num_rows($result) != 0) {
//
//        $row = mysql_fetch_array($result);
//        $usuario = new Usuario();
//        $usuario->crearEdicion($row);
//
//        $respuesta['usuario'] = $usuario;
//        $respuesta['status'] = 'ok';
//        print_r(json_encode($respuesta));
//    } else {
//        $respuesta['status'] = 'not';
//        print_r(json_encode($respuesta));
//    }
//}
//
//
//
//function buscarUsuario() {
//    $nombres = $_POST['nombres'];
//    $link = Conectarse();
//    $sql = 'Select u.id, u.nombre, u.cedula, u.correo, u.clave, u.id_facultad, u.tipo, u.estado, f.nombre as nombre_facultad from usuarios u JOIN facultades f ON u.id_facultad = f.id where u.nombre LIKE "%' . $nombres . '%"';
//    $result = mysql_query($sql, $link);
//    mysql_close($link);
//    $respuesta = array();
//
//    if (mysql_num_rows($result) != 0) {
//
//        $datos = array();
//        while ($row = mysql_fetch_array($result)) {
//            $usuario = new Usuario();
//            $usuario->crear($row);
//            array_push($datos, $usuario);
//        }
//        $respuesta['datos'] = $datos;
//        $respuesta['status'] = 'ok';
//        print_r(json_encode($respuesta));
//    } else {
//        $respuesta['status'] = 'not';
//        print_r(json_encode($respuesta));
//    }
//}
//
//function editar() {
//    $id = $_POST['id'];
//    $nombres = $_POST['nombres'];
//    $cedula = $_POST['cedula'];
//    $correo = $_POST['correo'];
//    $tipo = $_POST['tipo'];
//    $estado = $_POST['estado'];
//    $facultad = $_POST['facultad'];
//
//    $link = Conectarse();
//    $verificar = 'UPDATE `usuarios` SET `nombre`="' . $nombres . '",`cedula`="' . $cedula . '",`correo`="' . $correo . '",`tipo`=' . $tipo . ',`estado`=' . $estado . ',`id_facultad`= ' . $facultad . ' WHERE id = ' . $id;
//    $result = mysql_query($verificar, $link);
//    mysql_close($link);
//
//    if ($result) {
//        $respuesta['status'] = 'ok';
//        print_r(json_encode($respuesta));
//    } else {
//        $respuesta['status'] = 'not';
//        print_r(json_encode($respuesta));
//    }
//}
