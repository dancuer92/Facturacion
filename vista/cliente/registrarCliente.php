<form class="s12 m4" id="formRegCli "method="post"> 
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">person_add</i> Registrar cliente</h3>
        <div>
            <div class="row">
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="nombre" name="nombre" type="text" maxlength="30" class="validate" required>
                    <label for="nombre">Nombre</label>                           
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="apellido" name="apellido" type="text" maxlength="30" class="validate" required>
                    <label for="apellido">Apellido</label>                                                      
                </div>
                <div class="input-field col s12 m6 l3">                     
                    <select id="tipoDoc" name="tipoDoc" class="validate" required >
                        <option value="1" >Cédula de ciudadanía</option>
                        <option value="2">Tarjeta de identidad</option>
                        <option value="3">Registro civil</option>
                        <option value="4">NIT</option>
                        <option value="5">Pasaporte</option>
                        <option value="6">Cédula de extranjería</option>
                        <option value="7">RUT</option>
                    </select>
                    <label for="tipoDoc">Tipo de documento</label>
                </div>                
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="numDoc" name="numDoc" type="number" maxlength="15" class="validate" required>
                    <label for="numDoc">Número de documento</label>                                                      
                </div>                
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">place</i>
                    <input id="direccion" name="direccion" type="text" maxlength="30" class="validate" required>
                    <label for="direccion">Dirección</label>                                                      
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">phone</i>
                    <input id="telefono" name="telefono" type="number" maxlength="20" class="validate" required>
                    <label for="telefono">Teléfono</label>                            
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">email</i>
                    <input id="correo" name="correo" type="email" maxlength="50" class="validate">
                    <label for="correo">Correo electrónico</label>                                                      
                </div>
                <div class="input-field col s12 m6 l3">
                    <i class="material-icons prefix">location_city</i>
                    <input type="text" id="ciudadC" name="ciudadC" class="validate" onkeyup="autocompletC()" required>
                    <ul id="city_list_id"></ul>
                    <label for="ciudadC">Ciudad</label>                     
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
<div id="resultadoRegistroCliente"></div>
<script>
    $('#regCli').click(function () {
        $('.contenido').hide();
        $('#registrarCliente').show();
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
        if (numDoc != "" && tipoDoc != "" && nombre != "" && apellido != "" && ciudad != "" && direccion != "" && telefono != "") {
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

    function autocompletC() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#ciudadC').val();
        if (keyword.length >= min_length && keyword != "") {
            $.post("controlador/control_ciudad.php", {valorBusqueda: keyword, opcion: "listar"},
            function (mensaje) {
                $('#city_list_id').show();
                $('#city_list_id').html(mensaje);
//                Materialize.toast(mensaje,3000,'rounded');
            });
        } else {
            set_item("");
            Materialize.toast("Error seleccionando la ciudad", 3000, 'rounded');
        }
    }
    ;

</script>