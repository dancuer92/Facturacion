<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <title>FACTURACIÓN</title>
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/materialize.js"></script>
        <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    </head>
    <body>
        <?php
        $logo = "images/corporativo/logo_ceramica.png";
        $home = "index.php";
        include 'vista/navBar.php';
        ?>

        <?php
        include 'vista/tabBar.php';
        ?>
        <?php
        include 'vista/dropdown.php';
        ?>
        <!--Clientes-->
        <div id="buscarCliente" class="contenido">
            <?php include_once 'vista/cliente/buscarCliente.php'; ?>
        </div>

        <div id="registrarCliente" class="contenido">
            <?php include_once 'vista/cliente/registrarCliente.php'; ?>
        </div>

        <div id="listarCliente" class="contenido">
            <?php include_once 'vista/cliente/listarCliente.php'; ?>
        </div>
        <!--Proveedor-->
        <div id="consultarProveedor" class="contenido">
            <?php include_once 'vista/proveedor/consultarProveedor.php'; ?>
        </div>

        <div id="registrarProveedor" class="contenido">
            <?php include_once 'vista/proveedor/registrarProveedor.php'; ?>
        </div>
        <!--Precios-->        
        <div id="registrarPrecios" class="contenido">
            <?php include_once 'vista/precio/catalogoCliente.php'; ?>
        </div>        
        <!--Productos-->
        <div id="registrarProducto" class="contenido">
            <?php include_once 'vista/producto/registrarProducto.php'; ?>
        </div>
        <div id="consultarProducto" class="contenido">
            <?php include_once 'vista/producto/consultarProducto.php'; ?>
        </div>

        <!--Factura-->
        <div id="registrarFactura" class="contenido">
            <?php include_once 'vista/facturacion/registrarFactura.php'; ?>
        </div>        

    </body>
    <script>
        $(document).ready(function () {
            $(".button-collapse").sideNav();
            $('ul.tabs').tabs();
            $(".dropdown-button").dropdown();
            $('select').material_select();
            $(".contenido").hide();
        });

        function limpiar() {
            $(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
        }
        function set_item(item) {
            // change input value
            $('#ciudadP').val(item);
            $('#ciudadC').val(item);
            $("#nombrePro").val(item);
//            $("#nombreCli").val(item);
            // hide proposition list
            $('#city_list').hide();
            $('#city_list_id').hide();
            $("#nombresProductos").hide();
//            $("#nombresClientes").hide();
        }

    </script>
</html>

