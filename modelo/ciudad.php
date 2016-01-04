<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ciudad{
    
    var $id_ciudad;
    var $id_departamento;
    var $nombre_ciudad;
    
    function crearCiudad($datos){
        $this->id_ciudad=$datos['id_ciudad'];
        $this->id_departamento=$datos['id_departamento'];        
        $this->nombre_ciudad=$datos['nombre_ciudad'];
    }
}