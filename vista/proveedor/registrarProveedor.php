<form class="s12 m4" id="formRegPro"method="post"> 
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">work</i> Registrar proveedor</h3>
        <div>
            <div class="row">
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="nombreP" name="nombreP" type="text" maxlength="30" class="validate" required>
                    <label for="nombreP">Nombre</label>                           
                </div>
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="apellidoP" name="apellidoP" type="text" maxlength="30" class="validate" >
                    <label for="apellidoP">Apellido</label>                                                      
                </div>
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">work</i>
                    <input id="nombreComP" name="nombreComP" type="text" maxlength="30" class="validate">
                    <label for="nombreComP">Nombre comercial</label>                           
                </div>                
                <div class="input-field col s12 m6 l4">                     
                    <select id="tipoDocP" name="tipoDocP" class="validate" required >
                        <option value="1" >Cédula de ciudadanía</option>
                        <option value="2">Tarjeta de identidad</option>
                        <option value="3">Registro civil</option>
                        <option value="4">NIT</option>
                        <option value="5">Pasaporte</option>
                        <option value="6">Cédula de extranjería</option>
                        <option value="7">RUT</option>
                    </select>
                    <label for="tipoDocP">Tipo de documento</label>
                </div>                
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="numDocP" name="numDocP" type="text" maxlength="15" class="validate" required>
                    <label for="numDocP">Número de documento</label>                                                      
                </div>
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">location_city</i>
<!--                    <input id="ciudadP" name="ciudadP" type="number" class="validate" required>-->
                    <input type="text" id="ciudadP" name="ciudadP" class="validate" required onkeyup="autocompletP()">
                    <ul id="city_list"></ul>
                    <label for="ciudadP">Ciudad</label>                     
                </div>
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">place</i>
                    <input id="direccionP" name="direccionP" type="text" maxlength="30" class="validate">
                    <label for="direccionP">Dirección</label>                                                      
                </div>
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">phone</i>
                    <input id="telefonoP" name="telefonoP" type="number" maxlength="20" class="validate">
                    <label for="telefonoP">Teléfono</label>                            
                </div>
                <div class="input-field col s12 m6 l4">
                    <i class="material-icons prefix">email</i>
                    <input id="correoP" name="correoP" type="email" maxlength="50" class="validate">
                    <label for="correoP">Correo electrónico</label>                                                      
                </div>
                <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">description</i>
                    <textarea id="descripcionP" name="descripcionP" class="validate materialize-textarea"></textarea>
                    <label for="descriptionP">Descripción de los productos que ofrece</label>                                                      
                </div>
            </div>

        </div> 

<!--<input id="opcion" name="opcion" type="hidden" value="registrar">-->
        <a id="registroProveedor" class="btn waves-effect waves-light hoverable" onclick="registrarP()">Registrar
            <i class="material-icons right">send</i>
        </a>           
        <a class="waves-effect waves-red btn-flat hoverable" onclick="limpiar()">Limpiar
            <i class="material-icons right">cancel</i></a>        
    </div>
</form>
<div id="resultadoRegistroProveedor"></div>

<script>
    $('#regPro').click(function () {
        $('.contenido').hide();
        $('#registrarProveedor').show();
        limpiar();
    });

    function registrarP() {
        var numDoc = $('#numDocP').val();
        var tipoDoc = $('#tipoDocP').val();
        var nombre = $('#nombreP').val();
        var apellido = $('#apellidoP').val();
        var nombreCom = $('#nombreComP').val();
        var ciudad = $('#ciudadP').val();
        var direccion = $('#direccionP').val();
        var telefono = $('#telefonoP').val();
        var correo = $('#correoP').val();
        var descripcion = $('#descripcionP').val();
        if (numDoc != "" && tipoDoc != "" && nombre != "" && ciudad != "" && direccion != "" && telefono != "") {
            $.post("controlador/control_proveedor.php", {numDoc: numDoc, tipoDoc: tipoDoc, nombre: nombre, apellido: apellido, nombreCom: nombreCom,
                direccion: direccion, ciudad: ciudad, telefono: telefono, correo: correo, descripcion: descripcion, opcion: "registrar"},
            function (mensaje) {
                limpiar();
                Materialize.toast(mensaje, 3000, 'rounded');
            });
        } else {
            Materialize.toast('Favor digitar los campos', 3000, 'rounded');
        }
    }
    ;

    function autocompletP() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#ciudadP').val();
        if (keyword.length >= min_length && keyword != "") {
            $.post("controlador/control_ciudad.php", {valorBusqueda: keyword, opcion: "listar"},
            function (mensaje) {
                $('#city_list').show();
                $('#city_list').html(mensaje);
//                Materialize.toast(mensaje,3000,'rounded');
            });
        } else {
            set_item("");
            $('#ciudadP').html("Error seleccionando la ciudad");
        }
    }
    ;
    

</script>