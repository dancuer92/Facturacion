<form  class="s12 m4" method="POST">
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">search</i> Buscar proveedor</h3>
        <div class="input-field col s12 m6 l3">
            <i class="material-icons prefix">person_pin</i>
            <!--<input type="hidden" name="opcion" id="opcion" value="buscar">-->
            <input type="text" name="busquedaProveedor" id="busquedaProveedor" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscarProveedor();"/> 
            <label for="busquedaProveedor">Número de identificación del proveedor a buscar</label>                                                      
        </div> 
    </div>
</form>
<div id="resultadoBusquedaProveedor"></div>
<script>
    $('#conPro').click(function () {
        $('.contenido').hide();
        $('#consultarProveedor').show();
        cargar();
    });

    function buscarProveedor() {
        var textoBusqueda = $("#busquedaProveedor").val();
        if (textoBusqueda != "") {
            $.post("controlador/control_proveedor.php", {valorBusqueda: textoBusqueda, opcion: "buscar"},
            function (mensaje) {
                $("#resultadoBusquedaProveedor").html(mensaje);
            });
        }else{
            Materialize.toast('Favor digitar el número de documento de un proveedor a buscar',3000,'rounded');
            cargar();
        }
    }
    function cargar(){
        $.post("controlador/control_proveedor.php", {opcion: "listar"},
        function (mensaje) {
            $("#resultadoBusquedaProveedor").html(mensaje);
        });
    }
    ;
</script>