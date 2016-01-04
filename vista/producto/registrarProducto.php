<form class="s12 m4" id="formRegCli "method="post"> 
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">add</i> Registrar paquete de chorizos</h3>
        <div>
            <div class="row">
                <div class="input-field col s12 m6 l12">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="nombrePro" name="nombrePro" type="text" maxlength="30" class="validate" required onkeyup="autocompletProd()">
                    <ul id="nombresProductos"></ul>
                    <label for="nombrePro">Nombre</label>                           
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="pesoPro" name="pesoPro" type="number" maxlength="11" class="validate">
                    <label for="pesoPro">Peso del paquete</label>                                                      
                </div>                               
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="cantUnidades" name="cantUnidades" type="number" maxlength="11" class="validate" required>
                    <label for="cantUnidades">Cantidad de chorizos</label>                                                      
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="precioPro" name="precioPro" type="number" maxlength="11" class="validate" required>
                    <label for="precioPro">Precio al público</label>                                                      
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="inventarioPro" name="inventarioPro" type="number" maxlength="11" class="validate" required>
                    <label for="inventarioPro">Inventario inicial</label>                                                      
                </div>
            </div>   
        </div> 

        <!--<input id="opcion" name="opcion" type="hidden" value="registrar">-->
        <a id="registroCliente" class="btn waves-effect waves-light hoverable" onclick="registrarProducto()">Registrar
            <i class="material-icons right">send</i>
        </a>           
        <a class="waves-effect waves-red btn-flat hoverable" onclick="limpiar()">Limpiar
            <i class="material-icons right">cancel</i></a>        
    </div>
</form>
<div id="resultadoRegistroProducto"></div>
<script>
    $('#regProd').click(function () {
        $('.contenido').hide();
        $('#registrarProducto').show();
        limpiar();
    });

    function registrarProducto() {
        var nombrePro = $('#nombrePro').val();
        var pesoPro = $('#pesoPro').val();
        var cantUnidades = $('#cantUnidades').val();
        var precioPro = $('#precioPro').val();
        var inventario = $('#inventarioPro').val();
        if (nombrePro != "" && pesoPro != "" && cantUnidades != "" && precioPro!="") {
            $.post("controlador/control_producto.php", {nombre: nombrePro, peso: pesoPro, cant: cantUnidades, precioPro:precioPro, inventario: inventario, opcion: "registrar"},
            function (mensaje) {
                $('#resultadoRegistroProducto').html(mensaje);
                Materialize.toast(mensaje, 3000, 'rounded');
                limpiar();
            });
        } else {
            Materialize.toast('Favor digitar los campos', 3000, 'rounded');
        }
    }
    ;

    function autocompletProd() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#nombrePro').val();
        if (keyword.length >= min_length && keyword !== "") {
            $.post("controlador/control_producto.php", {valorBusqueda: keyword, opcion: "listar"},
            function (mensaje) {
                $('#nombresProductos').show();
                $('#nombresProductos').html(mensaje);
//                Materialize.toast(mensaje,3000,'rounded');
            });
        } else {      
            $('#nombresProductos').html('');
            Materialize.toast("Error seleccionando un nombre",3000,'rounded');
        }
    };    
    

</script>