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

if ($opcion === "mostrarTodos") {
    mostrarTodos();
}

if ($opcion === "getCliente") {
    getCliente();
}

function registrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $documento = $_POST['numDoc'];
    $cod_tipo_documento = (int) $_POST['tipoDoc'];
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $cod_ciudad = (int) $_POST['ciudad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $mensaje = "";

    $sql = "INSERT INTO `cliente`(`documento`, `cod_tipo_documento`, `nombres`, `apellidos`, `direccion`, `cod_ciudad`, `telefono`, `correo`) "
            . "VALUES ('$documento','$cod_tipo_documento','$nombres','$apellidos','$direccion','$cod_ciudad','$telefono','$correo');";

    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = ("Usuario registrado con éxito");
    } else {
        $mensaje = ("Error al registrar usuario: Usuario ya existe en el sistema");
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
    $sql = "SELECT td.descripcion,c.documento, c.nombres, c.apellidos, c.direccion, ci.nombre_ciudad, c.telefono,"
            ." c.correo FROM cliente c,tipo_de_documento td, ciudad ci WHERE c.documento COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "AND c.cod_tipo_documento=td.cod_tipo_documento AND ci.codigo_ciudad=c.cod_ciudad";
    
    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ningún usuario con ese número de documento</p>";
    } else {
        $mensaje = '<table id="busquedaCliente" class="highlight centered responsive-table"> 
                <thead>
                    <tr>                        
                        <th data-field="idTipo">Tipo Doc.</th>
                        <th data-field="id">No. Identificación</th>                        
                        <th data-field="nombres">Nombre del cliente</th>
                        <th data-field="apellidos">Apellidos</th>                        
                        <th data-field="direccion">Dirección</th>
                        <th data-field="idCiudad">Ciudad</th>
                        <th data-field="telefono">Teléfono</th>
                        <th data-field="correo">correo</th>                   
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
                        <td><a id="modCli" class="waves-effect waves-red btn-flat hoverable" onclick="modificarCliente()">Modificar</a></td>
                    </tr>'; //Output
        }$mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function listar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $mensaje = "";
    $sql = "SELECT c.nombres, c.apellidos, td.descripcion, c.documento, c.direccion, ci.nombre_ciudad, c.telefono,c.correo "
            . "FROM cliente c,tipo_de_documento td, ciudad ci "
            . "WHERE c.cod_tipo_documento=td.cod_tipo_documento "
            . "AND ci.codigo_ciudad=c.cod_ciudad "
            . "AND c.documento COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "OR c.nombres COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "OR c.apellidos COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "OR concat(c.nombres,' ',c.apellidos) COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%' "
            . "ORDER BY c.nombres ASC ";
    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay clientes en la base de datos</p>";
    } else {
        $mensaje = '<table id="busquedaCliente" class="pagination highlight centered responsive-table"> 
                <thead>
                    <tr>                        
                        <th data-field="nombres">Nombre del cliente</th>
                        <th data-field="apellidos">Apellidos</th>
                        <th data-field="idTipo">Tipo Doc.</th>
                        <th data-field="id">No. Identificación</th> 
                        <th data-field="direccion">Dirección</th>
                        <th data-field="idCiudad">Ciudad</th>
                        <th data-field="telefono">Teléfono</th>
                        <th data-field="correo">correo</th>                   
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
                    </tr>'; //Output
        }$mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function mostrar() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $consultaBusqueda = $_POST['valorBusqueda'];
    $mensaje='';
    $sql = "SELECT c.nombres, c.apellidos ,c.documento, td.descripcion, c.direccion, c.telefono "
            . "FROM cliente c, tipo_de_documento td WHERE c.cod_tipo_documento=td.id_tipo_documento "
            . "AND (c.documento COLLATE latin1_swedish_ci LIKE '%$consultaBusqueda%' "
            . "OR c.nombres COLLATE latin1_swedish_ci LIKE '%$consultaBusqueda%' "
            . "OR c.apellidos COLLATE latin1_swedish_ci LIKE '%$consultaBusqueda%' "
            . "OR CONCAT(c.nombres,' ',c.apellidos) COLLATE latin1_swedish_ci LIKE '%$consultaBusqueda%' )"
            . "ORDER BY c.nombres ASC;";
    
    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje= "<p>No hay ningún cliente registrado con el número de documento: '$consultaBusqueda'</p>";
    } else {        
        while ($resultados = mysqli_fetch_array($consulta)) {
            $cliente= new cliente($resultados);
            $nombre=$resultados[0];
            $apellido=$resultados[1];
            $documento=$resultados[2];            
            $tipo=$resultados[3];            
            $direccion=$resultados[4];            
            $telefono=$resultados[5];
            
            $mensaje.='<option id="'.$documento.'" onclick="set_item_cliente('.$documento.')">'.$documento.'. '.$nombre.', '.$apellido.'</option>'; //Output
        }
    }
    mysqli_close($conexion);
    echo($mensaje);
}

function mostrarTodos() {
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    
    $mensaje = "";
    $sql = "SELECT td.descripcion,c.documento, c.nombres, c.apellidos, c.direccion, ci.nombre_ciudad, c.telefono,"
            ." c.correo FROM cliente c,tipo_de_documento td, ciudad ci WHERE "
            . " c.cod_tipo_documento=td.cod_tipo_documento AND ci.codigo_ciudad=c.cod_ciudad";
    
    $consulta = mysqli_query($conexion, $sql);

    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje = "<p>No hay ningún usuario con ese número de documento</p>";
    } else {
        $mensaje = '<table id="busquedaCliente" class="highlight centered responsive-table"> 
                <thead>
                    <tr>                        
                        <th data-field="idTipo">Tipo Doc.</th>
                        <th data-field="id">No. Identificación</th>                        
                        <th data-field="nombres">Nombre del cliente</th>
                        <th data-field="apellidos">Apellidos</th>                        
                        <th data-field="direccion">Dirección</th>
                        <th data-field="idCiudad">Ciudad</th>
                        <th data-field="telefono">Teléfono</th>
                        <th data-field="correo">correo</th>                   
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
                    </tr>'; //Output
        }$mensaje.='</tbody></table>';
    }
    mysqli_close($conexion);
    echo $mensaje;
}

function getCliente(){
    if (!$conexion = new mysqli("localhost", "root", "", "facturacion")) {
        die("Error al conectarse a la base de datos");
    }
    $consultaBusqueda = $_POST['valorBusqueda'];
    $mensaje='';
    $sql = "SELECT c.nombres, c.apellidos ,c.documento FROM cliente c WHERE c.documento COLLATE utf8_spanish_ci LIKE  '%$consultaBusqueda%' "
            . "OR c.nombres COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%'"
            . "OR c.apellidos COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%'"
            . "OR concat(c.nombres,' ',c.apellidos) COLLATE utf8_spanish_ci LIKE '%$consultaBusqueda%';";
    $consulta = mysqli_query($conexion, $sql);
    $filas = mysqli_num_rows($consulta);

    if ($filas === 0) {
        $mensaje= "<p>No hay ningún cliente registrado como: '$consultaBusqueda'</p>";
    } else {        
        while ($resultados = mysqli_fetch_array($consulta)) {
            $nombre=$resultados[0];
            $apellido=$resultados[1];
            $documento=$resultados[2];            
            $mensaje.='<li id="'.$documento.'" onclick="set_item_clientes('.$documento.')">'.$nombre.' '.$apellido.'</li>';
        }
    }
    mysqli_close($conexion);
    echo($mensaje);
}

//                '<div class="input-field col s12 m6 l6">
//                    <i class="material-icons prefix">person_pin</i>
//                    <input id="numDocC" name="numDocC" type="text" maxlength="15" class="validate" onkeyup="clientes();">
//                    <ul id="list_clientes"></ul>
//                    <label for="numDocC">Número de documento</label>                                                      
//                </div>
//                <div class="input-field col s12 m6 l6">  
//                    <i class="material-icons prefix">person_pin</i>
//                    <input id="tipoDocC" name="tipoDocC" type="text" class="validate"  required>
//                    <label for="tipoDocC">Tipo de documento</label>                    
//                </div>
//                <div class="input-field col s12 m6 l3">
//                    <i class="material-icons prefix">person_pin</i>
//                    <input id="nombreC" name="nombreC" type="text" maxlength="30" class="validate"  required>
//                    <label for="nombreC">Nombre del cliente</label>                           
//                </div>
//                <div class="input-field col s12 m6 l3">
//                    <i class="material-icons prefix">person_pin</i>
//                    <input id="apellidoC" name="apellidoC" type="text" maxlength="30" class="validate"  >
//                    <label for="apellidoC">Apellido</label>                                                      
//                </div>                  
//                <div class="input-field col s12 m6 l3">
//                    <i class="material-icons prefix">place</i>
//                    <input id="direccionC" name="direccionC" type="text" maxlength="30" class="validate" >
//                    <label for="direccionC">Dirección</label>                                                      
//                </div>
//                <div class="input-field col s12 m6 l3">
//                    <i class="material-icons prefix">phone</i>
//                    <input id="telefonoC" name="telefonoC" type="number" maxlength="20" class="validate" >
//                    <label for="telefonoC">Teléfono</label>                            
//                </div> ';