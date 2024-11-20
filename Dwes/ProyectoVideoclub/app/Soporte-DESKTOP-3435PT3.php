<?php
namespace Dwes\ProyectoVideoclub;
define("IVA", 1.21);
abstract class Soporte implements Resumible   {
    
    public function __construct(public string $titulo,protected int $numero, private float $precio) {

    }
    function getPrecio(): float {
         return $this->precio; }
    function getPrecioConIVA(): float {
         return round(($this->precio * IVA),2); }
    function getNumero(): int {
         return $this->numero; }
    function muestraResumen():void {
       echo "<br>".$this->titulo."<br> Precio ". $this->precio. "€ (IVA no incluido)<br>";
    }
}
?>