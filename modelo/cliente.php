<?php

class cliente {

    var $tipoDoc;
    var $numDoc;
    var $nombre;
    var $apellido;
    var $id_ciudad;
    var $direccion;
    var $telefono;
    var $correo;

    function __construct($datos) {
        $this->tipoDoc= $datos[0];
        $this->numDoc= $datos[1];
        $this->nombre = $datos[2];
        $this->apellido= $datos[3];
        $this->id_ciudad= $datos[4];
        $this->direccion= $datos[5];
        $this->telefono= $datos[6];
        $this->correo=$datos[7];
    }
    
   

}
