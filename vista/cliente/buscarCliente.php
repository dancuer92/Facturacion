<form  class="s12 m4" method="POST">
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">search</i> Buscar cliente</h3>
        <div class="input-field col s12 m6 l3">
            <i class="material-icons prefix">person_pin</i>
            <!--<input type="hidden" name="opcion" id="opcion" value="buscar">-->
            <input type="number" name="busquedaCliente" id="busquedaCliente" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscarCliente();"/> 
            <label for="busquedaCliente">Número de identificación del cliente a buscar</label>                                                      
        </div> 
    </div>
</form>
<div id="resultadoBusquedaCliente"></div>
<script>
    $('#busCli').click(function(){
       $('.contenido').hide();
       $('#buscarCliente').show();
       $('#busquedaCliente').val('');
       $("#resultadoBusquedaCliente").html("");
    });
    
    function buscarCliente() {
        var textoBusqueda = $("#busquedaCliente").val();
        if (textoBusqueda != "") {
            $.post("controlador/control_cliente.php", {valorBusqueda: textoBusqueda, opcion: "buscar"},
            function (mensaje) {
                $("#resultadoBusquedaCliente").html(mensaje);
            });
        } else {
            $("#resultadoBusquedaCliente").html("");
            Materialize.toast('Favor digitar el número de documento',3000,'rounded');
        }
    };
</script>