<?php
namespace Dwes\ProyectoVideoclub;
class Cliente{
    private $soportesAlquilados = [];
    private $numSoportesAlquilados = 0;
    public function __construct(public string $nombre, private int $numero, private int $maxAlquilerRecurrente=3){
        
    }
    public function getNumero  ():int{
        return $this->numero;
    }
    public function setNumero($num):void{
        $this->numero = $num;
    }
    public function getSoportesAlquilados(){
        return $this->numSoportesAlquilados;
    }
    public function muestraResumen():void{
        echo "$this->nombre tiene alquilados ". count( $this->soportesAlquilados ) ." soportes.<br><br>";
    }
    public function tieneAlquilado($s): bool{
        foreach( $this->soportesAlquilados as $soporte ){
            if( $soporte == $s ){
                return true;
            }
        }
        
        return false;
    }
    public function alquilar($s): Cliente {
        if ($this->tieneAlquilado($s)) {
            echo "<br>El cliente ya tiene alquilado el soporte: " . $s->titulo . "<br><br>";
        } else {
            if ($this->getSoportesAlquilados() >= 3) {
                echo "Este cliente tiene 3 elementos alquilados. No puede alquilar más en este videoclub hasta que no devuelva algo<br> <br>No se ha podido encontrar el soporte en los alquileres de este cliente<br><br>";
            } else {
                $this->soportesAlquilados[] = $s;
                echo "Alquilado soporte a " . $this->nombre . "<br><br>";
                $s->muestraResumen();
                $this->numSoportesAlquilados++;
            }
        }
        return $this; // Permite el encadenamiento
    }
    
    public function devolver(int $numSoporte): bool{
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                unset($this->soportesAlquilados[$key]);
                $this->numSoportesAlquilados--;
                echo "devolución realizada con éxito.<br>";
                return true;
            }
        }           
    echo "Este cliente no tiene alquilado este elemento<br><br>";
    return false;
        
    }
    public function listaAlquileres(): void{
       if(count($this->soportesAlquilados)> 0){echo "<br>El cliente tiene {$this->numSoportesAlquilados} soportes alquilado/s:<br>";
        foreach ($this->soportesAlquilados as $s) {
            $s->muestraResumen();
        }}else{
            echo "Este cliente no tiene soportes alquilados";
        }
    }
}