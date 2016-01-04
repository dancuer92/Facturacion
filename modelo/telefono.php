<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class telefono{
    
    var $num_telefono;
    var $id_persona;
    
    function crearTel($datos){
        $this->num_telefono=$datos['num_telefono'];
        $this->id_persona=$datos['id_persona'];        
    }
}
