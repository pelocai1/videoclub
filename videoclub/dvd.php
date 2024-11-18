<?php
include_once("Soporte.php");
class Dvd extends Soporte{
    public function __construct(string $titulo,int $numero,float $precio, public string $idioma, private string $formatPantalla){
        parent::__construct($titulo,$numero,$precio);
    }
    function muestraResumen():void {
        parent::muestraResumen();
        echo "Idiomas: $this->idioma <br> Formato Pantalla: $this->formatPantalla <br><br>";
     }
}