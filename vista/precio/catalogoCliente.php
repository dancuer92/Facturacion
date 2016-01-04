<form class="s12 m12" method="POST">
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">search</i> Buscar cliente</h3>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <i class="material-icons prefix">person_pin</i>
                <input id="nombreCli" name="nombreCli" type="text" maxlength="30" class="validate" required onkeyup="autocompletCli()">
                <ul id="nombresClientes"></ul>
                <label for="nombreCli">Buscar cliente</label>                           
            </div>            
        </div> 
    </div>    
</form>
<div class="row">
    <div class="col s12 m12 l7 hoverable"id="resultadoCatalogo"></div>
    <div class="col s12 m12 l5 hoverable"id="mostrarCatalogo"></div>        
</div>

<script>
    $('#regPre').click(function () {
        $('.contenido').hide();
        $('#registrarPrecios').show();
    });

    function autocompletCli() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#nombreCli').val();
        if (keyword.length >= min_length && keyword !== "") {
            $.post("controlador/control_cliente.php", {valorBusqueda: keyword, opcion: "getCliente"},
            function (mensaje) {
                $('#nombresClientes').show();
                $('#nombresClientes').html(mensaje);
//                Materialize.toast(mensaje,3000,'rounded');
            });
        } else {
            $('#nombresClientes').html('');
            $("#resultadoCatalogo").hide();
            $('#mostrarCatalogo').hide();
            Materialize.toast("Error seleccionando un cliente", 3000, 'rounded');
        }
    }
    ;

    function set_item_clientes(item) {
        $("#nombreCli").val(item);
        $("#nombresClientes").hide();
        mostrarCatalogo();
        editarCat();
    }
    ;

    function mostrarCatalogo() {
        var nom = $("#nombreCli").val();
        if (nom !== '') {
            $.post("controlador/control_precio.php", {valorBusqueda: nom, opcion: "mostrar"},
            function (mensaje2) {
                $('#mostrarCatalogo').show();
                $('#mostrarCatalogo').html(mensaje2);
//                Materialize.toast(mensaje,3000,'rounded');
            });
        }
    }

    function editarCat() {
        $.post("controlador/control_producto.php", {opcion: "getProductos"},
        function (mensaje) {
            $("#resultadoCatalogo").html(mensaje);
            $("#resultadoCatalogo").show();
        });
    }
    ;

    function edit(item) {
        var x = item.split("-");
        var nombre = x[0];
        var peso = x[1];
        var unid = x[2];
        var precio = $('#' + x[3]).val();
        var codigoCliente = $("#nombreCli").val();

        if (precio !== '') {
            $.post("controlador/control_precio.php", {cod: codigoCliente, nombre: nombre, peso: peso, unid: unid, precio: precio, opcion: "registrar"},
            function (mensaje) {
//                $('#mensaje').html(mensaje);
                Materialize.toast(mensaje, 3000, 'rounded');
                mostrarCatalogo();
                $('#' + x[3]).val('');
            });
        }
        else {
            $('#' + x[3]).focus();
            Materialize.toast('Favor diligenciar el campo', 3000, 'rounded');
        }
    }
    ;



</script>
