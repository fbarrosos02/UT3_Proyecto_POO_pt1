<?php
namespace Dwes\ProyectoVideoclub;

require_once 'Soporte.php';
require_once 'CintaVideo.php';
require_once 'Dvd.php';
require_once 'Juego.php';
require_once 'Cliente.php';
require_once 'Resumible.php';

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;

class Videoclub
{

    // Propiedades de la clase
    public string $nombre;
    private array $productos;
    private array $socios;
    private int $numProductos;
    private int $numSocios;
    private int $numProductosAlquilados = 0;  
    private int $numTotalAlquileres = 0;

    // Constructor para inicializar el Videoclub
    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
    }

    //Metodos getter de las nuevas propiedades
    public function getNumProductosAlquilados(): int
    {
        return $this->numProductosAlquilados;
    }

    public function getNumTotalAlquileres(): int
    {
        return $this->numTotalAlquileres;
    }

    // Método privado para incluir un producto al array de productos 
    private function incluirProducto(Soporte $producto): void
    {
        $this->productos[] = $producto;
        $this->numProductos++;
        echo "Incluido soporte {$this->numProductos}<br>";

    }

    // Métodos públicos para incluir soportes en concreto
    public function incluirCintaVideo(string $titulo, float $precio, float $duracion): void
    {
        $cinta = new CintaVideo($titulo, $this->numProductos + 1, $precio, $duracion);
        $this->incluirProducto($cinta);
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): void
    {
        $dvd = new Dvd($titulo, $this->numProductos + 1, $precio, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $min, int $max): void
    {
        $juego = new Juego($titulo, $this->numProductos + 1, $precio, $consola, $min, $max);
        $this->incluirProducto($juego);
    }

    // Método público para incluir un socio
    public function incluirSocio(string $nombre, int $maxAlquileresConcurrentes = 3): void
    {
        $socio = new Cliente($nombre, $this->numSocios + 1, $maxAlquileresConcurrentes);
        $this->socios[] = $socio;
        $this->numSocios++;
        echo "Incluido socio {$this->numSocios}<br>";
    }

    // Método público para listar todos los productos
    public function listarProductos(): void
    {
        if (empty($this->productos)) {
            echo "No hay productos en el videoclub.<br>";
            return;
        }
        echo "<br><br>Listado de los {$this->numProductos} disponibles:<br>";
        foreach ($this->productos as $index => $producto) {
            echo ($index + 1) . ".- ";
            $producto->muestraResumen();
        }
    }

    // Método público para listar todos los socios
    public function listarSocios(): void
    {
        if (empty($this->socios)) {
            echo "<br>No hay socios registrados en el videoclub.<br>";
            return;
        }
        echo "<br>Listado de {$this->numSocios} del videoclub:<br>";
        foreach ($this->socios as $index => $socio) {
            echo ($index + 1) . ".- ";
            echo $socio->muestraResumen();
        }
    }

    // Método público para alquilar un productos a un socio
    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte): void
    {
        $socio = null;
        $soporte = null;

        // Buscar el socio
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numeroCliente) {
                $socio = $s;
                break;
            }
        }

        // Buscar el soporte
        foreach ($this->productos as $p) {
            if ($p->getNumero() === $numeroSoporte) {
                $soporte = $p;
                break;
            }
        }

        // Alquilar el soporte al socio
        echo "<br>";
    
        try {
        $socio->alquilar($soporte);
        $this->numProductosAlquilados++;
        $this->numTotalAlquileres++;
    } catch (SoporteYaAlquiladoException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (CupoSuperadoException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (SoporteNoEncontradoException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (ClienteNoEncontradoException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }

    }
    
    // Método público para devolver un producto a un socio
    public function devolverSocioProducto(int $numeroCliente, int $numeroSoporte): self 
    {
        $socio = null;
        $soporte = null;

        // Buscar el socio
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numeroCliente) {
                $socio = $s;
                break;
            }
        }

        // Buscar el soporte
        foreach ($this->productos as $p) {
            if ($p->getNumero() === $numeroSoporte) {
                $soporte = $p;
                break;
            }
        }

        // Devolver el soporte 
        if ($socio && $soporte) { 
            $socio->devolver($numeroSoporte);
            $this->numProductosAlquilados--;
         } 
         return $this;
    }

// Método público para devolver varios productos a un socio
    // Método para devolver varios productos alquilados por un socio
    public function devolverSocioProductos(int $numSocio, array $numerosProductos): self
    {
        $socio = null;

        // Buscar el socio
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numSocio) {
                $socio = $s;
                break;
            }
        }

        // Devolver cada soporte
        foreach ($numerosProductos as $numeroProducto) {
            $soporte = null;
            foreach ($this->productos as $p) {
                if ($p->getNumero() === $numeroProducto) {
                    $soporte = $p;
                    break;
                }
            }

            if ($socio && $soporte) {
                $socio->devolver($soporte);
                $this->numProductosAlquilados--;
            }
        }

        return $this;
    }

    // Método público para alquilar varios productos a un socio
public function alquilarSocioProductos(int $numeroCliente, array $numerosProductos): void
{
    $socio = null;
    $productos = [];

    // Buscar el socio
    foreach ($this->socios as $s) {
        if ($s->getNumero() === $numeroCliente) {
            $socio = $s;
            break;
        }
    }

    // Comprobar si todos los productos están disponibles
    foreach ($numerosProductos as $numero) {
        $soporte = null;
        foreach ($this->productos as $p) {
            if ($p->getNumero() === $numero) {
                if ($p->alquilado) {
                    echo "El producto {$p->getNumero()} ya está alquilado. No se puede alquilar ninguno.<br>";
                    return;
                }
                $productos[] = $p;
            }
        }
    }

    // Alquilar los productos al socio
    echo "<br>";
    foreach ($productos as $producto) {
        try {
            $socio->alquilar($producto);
            $this->numProductosAlquilados++;
            $this->numTotalAlquileres++;
        } catch (SoporteYaAlquiladoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (CupoSuperadoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (SoporteNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (ClienteNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}


}
