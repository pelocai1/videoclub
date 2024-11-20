<?php
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
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
    // Si el cliente ya tiene alquilado el soporte, lanzamos una excepción
    if ($this->tieneAlquilado($s)) {
        throw new SoporteYaAlquiladoException("El cliente ya tiene alquilado el soporte: " . $s->titulo);
    }

    // Si se supera el cupo máximo de alquileres, lanzamos otra excepción
    if ($this->getSoportesAlquilados() >= $this->numSoportesAlquilados) {
        throw new CupoSuperadoException("Este cliente ha alcanzado el máximo de alquileres permitidos: " . $this->numSoportesAlquilados);
    }

    // Añadimos el soporte a los alquilados y actualizamos el contador
    $this->soportesAlquilados[] = $s;
    $this->numSoportesAlquilados++;

    // Mostramos el soporte alquilado
    echo "Soporte alquilado con éxito a " . $this->nombre . ":<br>";
    $s->muestraResumen();

    // Permitimos el encadenamiento
    return $this;
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