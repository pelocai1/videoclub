<?php
namespace Dwes\ProyectoVideoclub;
class Videoclub{
    
    private string $nombre;
    private array $productos = [];
    private int $numProductos = 0;
    private array $socios = [];
    private int $numSocios = 0;
    private int $numProductosAlquilados = 0;
    private int $numTotalAlquileres = 0;

    public function __construct($nombre) {
        $this-> nombre = $nombre;
    }

    function getNumProductosAlquilados(){
        return $this->numProductosAlquilados;
    }
    function getNumTotalAlquileres(){
        return $this->numTotalAlquileres;
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
    
        try {
            if ($cliente && $producto) {
                // Intentamos alquilar el producto
                $cliente->alquilar($producto);
                echo "Alquiler realizado con éxito. El cliente " . $cliente->nombre . " ha alquilado el producto: " . $producto->titulo . ".<br>";
                $this->numTotalAlquileres++;
            } else {
                echo "Cliente o producto no encontrado.<br>";
            }
        } catch (\Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException $e) {
            // Captura si el cliente ya ha alquilado este soporte
            echo  $e->getMessage() . "<br>";
        } catch (\Dwes\ProyectoVideoclub\Util\CupoSuperadoException $e) {
            // Captura si el cliente ha alcanzado el límite de alquileres
            echo $e->getMessage() . "<br>";
        } catch (\Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException $e) {
            // Captura si el producto no se encuentra en el videoclub
            echo $e->getMessage() . "<br>";
        } catch (\Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException $e) {
            // Captura si el cliente no se encuentra en el sistema
            echo $e->getMessage() . "<br>";
        } catch (\Exception $e) {
            // Captura cualquier otro tipo de excepción
            echo  $e->getMessage() . "<br>";
        }
        return $this; // Permite el encadenamiento
    }

    public function alquilarSocioProductos(int $numCliente, array $numerosProductos){
        // Obtener el cliente
        $cliente = $this->socios[$numCliente - 1] ?? null;
        if (!$cliente) {
            // Lanzar excepción personalizada si el cliente no se encuentra
            throw new \Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException("Cliente no encontrado.<br>");
        }
    
        // Primero verificamos si todos los productos están disponibles
        $productosValidos = [];  // Este array guardará los productos válidos para alquilar
        foreach ($numerosProductos as $productoIndex) {
            // Obtener el producto
            $producto = $this->productos[$productoIndex - 1] ?? null;
            if (!$producto) {
                // Si el producto no se encuentra, lanzamos excepción y cancelamos el alquiler
                throw new \Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException("Producto con el número $productoIndex no encontrado.<br>");
            }
    
            // Si el producto está alquilado, no lo agregamos a los productos válidos
            if ($producto->alquilado) {
                throw new \Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException("El producto: {$producto->titulo} ya está alquilado.<br>");
            }
    
            // Si pasa todas las validaciones, lo añadimos al array de productos válidos
            $productosValidos[] = $producto;
        }
    
        // Ahora que todos los productos son válidos, los alquilamos
        foreach ($productosValidos as $producto) {
            try {
                // Intentamos alquilar el producto
                $cliente->alquilar($producto);
                echo "Alquiler realizado con éxito. El cliente " . $cliente->nombre . " ha alquilado el producto: " . $producto->titulo . ".<br>";
                $this->numTotalAlquileres++;
            } catch (\Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException $e) {
                // Captura si el cliente ya ha alquilado este soporte
                echo $e->getMessage() . "<br>";
            } catch (\Dwes\ProyectoVideoclub\Util\CupoSuperadoException $e) {
                // Captura si el cliente ha alcanzado el límite de alquileres
                echo $e->getMessage() . "<br>";
            } catch (\Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException $e) {
                // Captura si el producto no se encuentra en el videoclub
                echo $e->getMessage() . "<br>";
            } catch (\Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException $e) {
                // Captura si el cliente no se encuentra en el sistema
                echo $e->getMessage() . "<br>";
            } catch (\Exception $e) {
                // Captura cualquier otro tipo de excepción
                echo $e->getMessage() . "<br>";
            }
        }
    
        return $this; // Permite el encadenamiento después de procesar todos los productos
    }
    
    public function devolverSocioProducto($numeroCliente, $numeroSoporte): Videoclub {
        // Obtener el cliente y el producto
        $cliente = $this->socios[$numeroCliente - 1] ?? null;
        $producto = $this->productos[$numeroSoporte - 1] ?? null;
    
        try {
            if ($cliente && $producto) {
                // Intentamos devolver el producto
                $cliente->devolver($numeroSoporte);
                $this->numProductosAlquilados--;
                echo "Devolución realizada con éxito. El cliente " . $cliente->nombre . " ha devuelto el producto: " . $producto->titulo . ".<br>";
            } else {
                throw new \Exception("Cliente o producto no encontrado.<br>");
            }
        } catch (\Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException $e) {
            // Captura si el producto no estaba alquilado
            echo $e->getMessage() . "<br>";
        } catch (\Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException $e) {
            // Captura si el cliente no se encuentra en el sistema
            echo $e->getMessage() . "<br>";
        } catch (\Exception $e) {
            // Captura cualquier otro tipo de excepción
            echo $e->getMessage() . "<br>";
        }
    
        return $this; // Permite el encadenamiento
    }
    
    public function devolverSocioProductos(int $numCliente, array $numerosProductos): Videoclub {
        // Obtener el cliente
        $cliente = $this->socios[$numCliente - 1] ?? null;
        if (!$cliente) {
            // Lanzar excepción personalizada si el cliente no se encuentra
            throw new \Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException("Cliente no encontrado.<br>");
        }
    
        // Primero verificamos si todos los productos son válidos para devolver
        $productosValidos = [];
        foreach ($numerosProductos as $productoIndex) {
            // Obtener el producto
            $producto = $this->productos[$productoIndex - 1] ?? null;
            if (!$producto) {
                // Si el producto no se encuentra, lanzamos excepción y cancelamos la devolución
                throw new \Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException("Producto con el número $productoIndex no encontrado.<br>");
            }
    
            // Si el cliente no tiene alquilado el producto, lanzamos excepción
            if (!$cliente->tieneAlquilado($producto)) {
                throw new \Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException("El cliente no tiene alquilado el producto: {$producto->titulo}.<br>");
            }
    
            // Si pasa todas las validaciones, lo añadimos al array de productos válidos
            $productosValidos[] = $producto;
        }
    
        // Ahora que todos los productos son válidos, los devolvemos
        foreach ($productosValidos as $producto) {
            try {
                // Intentamos devolver el producto
                $cliente->devolver($producto->getNumero());
                $this->numProductosAlquilados--;
                echo "Devolución realizada con éxito. El cliente " . $cliente->nombre . " ha devuelto el producto: " . $producto->titulo . ".<br>";
            } catch (\Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException $e) {
                // Captura si el producto no estaba alquilado
                echo $e->getMessage() . "<br>";
            } catch (\Exception $e) {
                // Captura cualquier otro tipo de excepción
                echo $e->getMessage() . "<br>";
            }
        }
    
        return $this; // Permite el encadenamiento
    }
    
    
    
    
     
}