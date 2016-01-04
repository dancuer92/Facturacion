<form class="s12 m4" id="formRegCli "method="post"> 
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">add</i> Registrar factura</h3>
        <div>
            <div class="row">                
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="numDocCli" name="numDocC" type="text" maxlength="15" class="validate" onkeyup="clientesFac();">
                    <ul id="list_clientes"></ul>
                    <label for="numDocCli">Cliente a buscar</label>                                                      
                </div>                               
            </div>

        </div> 

        <!--<input id="opcion" name="opcion" type="hidden" value="registrar">-->
        <a id="registroCliente" class="btn waves-effect waves-light hoverable" onclick="registrarC()">Registrar
            <i class="material-icons right">send</i>
        </a>           
        <a class="waves-effect waves-red btn-flat hoverable" onclick="limpiar()">Limpiar
            <i class="material-icons right">cancel</i></a>        
    </div>
</form>
<!--<form  class="s12 m4" method="POST">
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">search</i> Seleccionar cliente</h3>
        <div class="input-field col s12 m6 l3">
            <i class="material-icons prefix">person_pin</i>
            <input type="hidden" name="opcion" id="opcion" value="buscar">
            <input type="text" name="busCliente" id="busCliente" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="busCli();"/> 
            <label for="busCliente">Número de identificación del proveedor a buscar</label>                                                      
        </div> 
    </div>
</form>-->
<div id="registrarFactura">
    

</div>

<script>
    $('#regFac').click(function () {
        $('.contenido').hide();
        $('#registrarFactura').show();
        limpiar();
    });

    function registrarC() {
        var numDoc = $('#numDoc').val();
        var tipoDoc = $('#tipoDoc').val();
        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        var direccion = $('#direccion').val();
        var ciudad = $('#ciudadC').val();
        var telefono = $('#telefono').val();
        var correo = $('#correo').val();
        if (numDoc != "" && tipoDoc != "" && nombre != "" && ciudad != "") {
            $.post("controlador/control_cliente.php", {numDoc: numDoc, tipoDoc: tipoDoc, nombre: nombre, apellido: apellido,
                direccion: direccion, ciudad: ciudad, telefono: telefono, correo: correo, opcion: "registrar"},
            function (mensaje) {
//                $('#formRegCli.input').val("");
                Materialize.toast(mensaje, 3000, 'rounded');
                limpiar();
            });
        } else {
            Materialize.toast('Favor digitar los campos', 3000, 'rounded');
            Materialize.toast(ciudad, 3000, 'rounded');
        }
    }
    ;

    function clientesFac() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#numDocCli').val();
        if (keyword.length >= min_length && keyword !== "") {
            $.post("controlador/control_cliente.php", {valorBusqueda: keyword, opcion: "getCliente"},
            function (mensaje) {
                $('#list_clientes').show();
                $('#list_clientes').html(mensaje);
//                Materialize.toast(mensaje,3000,'rounded');
            });
        } else {
            $('#list_clientes').html('');
            $("#resultadoCatalogo").hide();
            $('#mostrarCatalogo').hide();
            Materialize.toast("Error seleccionando un cliente", 3000, 'rounded');
        }
    }
    
//    function set_item_clientes(item) {
//        $("#nunmDocCli").val(item);
//        $("#list_clientes").hide();       
//    }

</script>