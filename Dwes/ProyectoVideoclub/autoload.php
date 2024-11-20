<?php
    spl_autoload_register(function ($nombreClase) {
        include_once "app/".$nombreClase.'.php';
        include_once "Util/".$nombreClase.'.php';
    });
    
    
    

