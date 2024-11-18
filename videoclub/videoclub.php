<?php
include_once "juego.php";
include_once "dvd.php";
include_once "Soporte.php";
include_once "cintaVideo.php";
include_once "Cliente.php";

class Videoclub{

    private string $nombre;
    private array $productos = [];
    private int $numProductos = 0;
    private array $socios = [];
    private int $numSocios = 0;

    public function __construct($nombre) {
        $this-> nombre = $nombre;
    }

    public function incluirProducto(Soporte $soporte): void{
        array_push($this->productos, $soporte);
        $this->numProductos++;
    }
    public function incluirCintaVideo($titulo, $precio, $duracion): void{
        $this->numProductos++;
        $producto = new CintaVideo($titulo,$this->numProductos, $precio, $duracion);
        $this->incluirProducto($producto);
    }
    public function incluirDvd($titulo, $precio, $idioma, $pantalla): void{
        $this->numProductos++;
        $producto = new Dvd($titulo,$this->numProductos, $precio, $idioma, $pantalla);
        $this->incluirProducto( $producto);
    }
    public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ): void{
        $this->numProductos++;
        $producto = new Juego($titulo,$this->numProductos, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($producto);
    }
    public function incluirSocio($nombre, $maxAlquileresConcurrentes=3): void{
        $this->numSocios++;
        $socio = new Cliente($nombre,$this->numSocios,  $maxAlquileresConcurrentes);
        $this->socios[] = $socio;
    }
    public function listarProductos(): void{
        
        foreach ($this->productos as $s) {
            $s->muestraResumen();
            
        }
    }
    public function listarSocios(): void{
        foreach ($this->socios as $s) {
            $s->muestraResumen();
        }
    }

    public function alquilaSocioProducto($numeroCliente, $numeroSoporte) {
        // Buscar el cliente
        $cliente = null;
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() === $numeroCliente) {
                $cliente = $socio;
                break;
            }
        }
    
        if ($cliente === null) {
            echo "Cliente con número $numeroCliente no encontrado.<br>";
            return false;
        }
    
        // Buscar el soporte (producto)
        $soporte = null;
        foreach ($this->productos as $producto) {
            if ($producto->getNumero() === $numeroSoporte) {
                $soporte = $producto;
                break;
            }
        }
    
        if ($soporte === null) {
            echo "Soporte con número $numeroSoporte no encontrado.<br>";
            return false;
        }
    
        // Intentar alquilar el soporte al cliente
        if ($cliente->alquilar($soporte)) {
            echo "El cliente con número $numeroCliente ha alquilado el soporte $numeroSoporte exitosamente.<br>";
            return true;
        } else {
            echo "No se pudo completar el alquiler para el cliente $numeroCliente.<br>";
            return false;
        }
    }
    
     
}