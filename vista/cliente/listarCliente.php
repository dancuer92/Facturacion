<form  class="s12 m4" method="POST">
    <div class="center" >        
        <h3><i class="material-icons prefix" style="font-size: 2.92rem">group</i> Clientes</h3>         
    </div>
</form>
<div id="resultadoListarCliente"></div>
<script>
    $('#lisCli').click(function () {
        $('.contenido').hide();
        $('#listarCliente').show();
        listarCliente();
    });

    function listarCliente() {
        $.post("controlador/control_cliente.php", {opcion: "listar"},
        function (mensaje) {
            $("#resultadoListarCliente").html(mensaje);
        });
    };
</script>