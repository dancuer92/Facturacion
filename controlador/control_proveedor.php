<?php

require_once('config.php');

$opcion = $_POST['opcion'];

if ($opcion === "registrar") {
    registrar();
}

if ($opcion === "buscar") {
    buscar();
}

if ($opcion === "listar") {
    listar();
}

function registrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $documento = $_POST['numDoc'];
    $cod_tipo_documento = (int) $_POST['tipoDoc'];
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $nombreCom = $_POST['nombreCom'];
    $direccion = $_POST['direccion'];
    $cod_ciudad = (int) $_POST['ciudad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $descripcion = $_POST['descripcion'];
    $mensaje = "";

    $sql = "INSERT INTO proveedor(`documento`, cod_tipo_documento, nombre, apellido, nombre_comercial, direccion, cod_ciudad, telefono, correo, descripcion) "
            . "VALUES ('$documento','$cod_tipo_documento','$nombres','$apellidos','$nombreCom','$direccion','$cod_ciudad','$telefono','$correo','$descripcion');";


    if (mysqli_query($conexion, $sql)) {
        $mensaje = ("Proveedor registrado con éxito");
    } else {
        $mensaje = ("Error al registrar proveedor, ya existe en el sistema");
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function buscar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $consultaBusqueda = $_POST['valorBusqueda'];
    $mensaje = "";
    $sql = "SELECT  td.descripcion, p.documento, p.nombre, p.apellido, p.nombre_comercial, c.nombre_ciudad, "
            . "p.direccion, p.telefono, p.correo, p.descripcion "
            . "FROM proveedor p, ciudad c, tipo_de_documento td "
            . "WHERE (p.cod_tipo_documento = td.cod_tipo_documento "
            . "AND c.codigo_ciudad=p.cod_ciudad )"
            . "AND (p.documento COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "OR p.nombre COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "OR p.apellido COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "OR CONCAT(p.nombre,' ',p.apellido) COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' );";

    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ningún proveedor con ese número de documento</p>";
    } else {
        $mensaje = '<table id="busquedaCliente" class="highlight centered responsive-table"> 
                <thead>
                    <tr>                                                                        
                        <th data-field="nombres">Nombre del cliente</th>
                        <th data-field="apellidos">Apellidos</th>                        
                        <th data-field="nombreCom">Nombre comercial</th>
                        <th data-field="idTipo">Tipo Doc.</th>
                        <th data-field="id">No. Identificación</th>
                        <th data-field="idCiudad">Ciudad</th>
                        <th data-field="direccion">Dirección</th>
                        <th data-field="telefono">Teléfono</th>
                        <th data-field="correo">correo</th>                   
                        <th data-field="descripcion">Descripción</th>                   
                        <th data-field="modificar"></th>                 
                    </tr>
                </thead>
                <tbody>';

        while ($resultados = mysqli_fetch_array($consulta)) {
            $mensaje.='<tr>                       
                        <td>' . $resultados[2] . '</td>
                        <td>' . $resultados[3] . '</td>
                        <td>' . $resultados[4] . '</td>
                        <td>' . $resultados[0] . '</td>
                        <td>' . $resultados[1] . '</td>
                        <td>' . $resultados[5] . '</td>
                        <td>' . $resultados[6] . '</td>
                        <td>' . $resultados[7] . '</td>
                        <td>' . $resultados[8] . '</td>
                        <td>' . $resultados[9] . '</td>
                        <td><a id="modPro" class="waves-effect waves-red btn-flat hoverable" onclick="modificarProveedor()">Modificar</a></td>
                    </tr>'; //Output
        }
        $mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function listar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $mensaje = "";
    $sql = "SELECT p.nombre, p.apellido, p.nombre_comercial, td.descripcion, p.documento, c.nombre_ciudad, p.direccion, p.telefono, p.correo, p.descripcion "
            . "FROM proveedor p, ciudad c, tipo_de_documento td "
            . "WHERE p.cod_tipo_documento=td.cod_tipo_documento AND c.codigo_ciudad=p.cod_ciudad "
            . "ORDER BY p.nombre ASC";

    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ningún proveedor con ese número de documento</p>";
    } else {
        $mensaje = '<table id="busquedaCliente" class="highlight centered responsive-table"> 
                <thead>
                    <tr> 
                        <th data-field="nombres">Nombre del cliente</th>
                        <th data-field="apellidos">Apellidos</th>                        
                        <th data-field="nombreCom">Nombre comercial</th>
                        <th data-field="idTipo">Tipo Doc.</th>
                        <th data-field="id">No. Identificación</th>  
                        <th data-field="idCiudad">Ciudad</th>
                        <th data-field="direccion">Dirección</th>
                        <th data-field="telefono">Teléfono</th>
                        <th data-field="correo">correo</th>                   
                        <th data-field="descripcion">Descripción</th>                   
                        <th data-field="modificar"></th>                 
                    </tr>
                </thead>
                <tbody>';

        while ($resultados = mysqli_fetch_array($consulta)) {
            $mensaje.='<tr>
                        <td>' . $resultados[0] . '</td>
                        <td>' . $resultados[1] . '</td>
                        <td>' . $resultados[2] . '</td>
                        <td>' . $resultados[3] . '</td>
                        <td>' . $resultados[4] . '</td>
                        <td>' . $resultados[5] . '</td>
                        <td>' . $resultados[6] . '</td>
                        <td>' . $resultados[7] . '</td>
                        <td>' . $resultados[8] . '</td>
                        <td>' . $resultados[9] . '</td>
                        <td><a id="modPro" class="waves-effect waves-red btn-flat hoverable" onclick="modificarProveedor()">Modificar</a></td>
                    </tr>'; //Output
        }
        $mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    echo $mensaje;
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
