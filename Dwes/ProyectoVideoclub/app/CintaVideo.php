<?php
namespace Dwes\ProyectoVideoclub;
class CintaVideo extends Soporte{
    public function __construct(string $titulo,int $numero,float $precio, private float $duracion){
        parent::__construct($titulo,$numero,$precio);
    }
    
    function muestraResumen():void {
        parent::muestraResumen();
        echo "Duración: $this->duracion minutos<br>";
     }
}
?>