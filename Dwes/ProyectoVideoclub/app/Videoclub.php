<?php
namespace Dwes\ProyectoVideoclub;

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

    public function alquilaSocioProducto($numeroCliente, $numeroSoporte): Videoclub {
        $cliente = $this->socios[$numeroCliente - 1] ?? null;
        $producto = $this->productos[$numeroSoporte - 1] ?? null;
    
        if ($cliente && $producto) {
            $cliente->alquilar($producto);
        } else {
            echo "Cliente o producto no encontrado.<br>";
        }
        return $this; // Permite el encadenamiento
    }
    
     
}