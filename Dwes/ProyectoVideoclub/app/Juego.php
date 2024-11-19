<?php

namespace Dwes\ProyectoVideoclub;

class Juego extends Soporte{
    public function __construct(string $titulo,int $numero,float $precio, public string $consola, private int $minNumJugadores,private int $maxNumJugadores){
        parent::__construct($titulo,$numero,$precio);
    }
    public function muestraJugadoresPosibles():void{
        if($this->maxNumJugadores>1){
        echo "Multijugador";
    }else{
        echo "Para un jugador";
    }
    }
    function muestraResumen():void {
        echo "<br>Juego para: $this->consola";
        parent::muestraResumen();
        echo $this->muestraJugadoresPosibles()."<br>";
        
     }
}