<form  class="s12 m4" method="POST">
    <div class="center" >
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">search</i> Consultar producto</h3>
        <div class="input-field col s12 m6 l3">            
            <div id="resultadoBusquedaProducto"></div>
        </div> 
    </div>
</form>

<script>
    $('#conProd').click(function () {
        $('.contenido').hide();
        $('#consultarProducto').show();
        cargarProd();
    });
    
    function cargarProd(){
        $.post("controlador/control_producto.php", {opcion: "listar"},
        function (mensaje) {
            $("#resultadoBusquedaProducto").html(mensaje);
        });
    }
    ;
</script>