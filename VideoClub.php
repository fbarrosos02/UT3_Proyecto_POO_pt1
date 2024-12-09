<?php
require_once 'Soporte.php';
require_once 'CintaVideo.php';
require_once 'Dvd.php';
require_once 'Juego.php';
require_once 'Cliente.php';
require_once 'Resumible.php';

class Videoclub
{

    // Propiedades de la clase
    public string $nombre;
    private array $productos;
    private array $socios;
    private int $numProductos;
    private int $numSocios;

    // Constructor para inicializar el Videoclub
    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
    }

    // Método privado para incluir un producto al array de productos 
    private function incluirProducto(Soporte $producto): void
    {
        $this->productos[] = $producto;
        echo "Incluido soporte {$this->numProductos}<br>";
        $this->numProductos++;
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
        echo "Incluido socio {$this->numSocios}<br>";
        $this->numSocios++;
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
    // Método público para alquilar productos a socios
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

        if ($socio === null) {
            echo "Socio con número {$numeroCliente} no encontrado.<br>";
            return;
        }

        if ($soporte === null) {
            echo "Soporte con número {$numeroSoporte} no encontrado.<br>";
            return;
        }

        // Alquilar el soporte al socio
        echo "<br>";
        $socio->alquilar($soporte);
    }
}
