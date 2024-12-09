<?php
namespace Dwes\ProyectoVideoclub;

class CLiente
{
    // Propiedades públicas y privadas de la clase Cliente
    public string $nombre;
    private int $numero;
    private array $soportesAlquilados;
    private int $numSoportesAlquilados;
    private int $maxAlquilerConcurrente;

    // Constructor de la clase
    public function __construct(
        string $nombre,
        int $numero,
        int $maxAlquilerConcurrente = 3
    ) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        $this->soportesAlquilados = [];
        $this->numSoportesAlquilados = 0;
    }

    // Método getter para obtener el número del cliente
    public function getNumero()
    {
        return $this->numero;
    }

    // Método setter para modificar el número del cliente
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    // Método getter para obtener el número de soportes alquilados
    public function getNumSoportesAlquilados()
    {
        return $this->numSoportesAlquilados;
    }

    // Método que muestra un resumen del cliente con su número de alquileres
    public function muestraResumen()
    {
        return "Cliente: {$this->numero}: {$this->nombre}<br> Numero de alquileres: {$this->numSoportesAlquilados}<br>";
    }

    // Método para ver si el cliente ya tiene alquilado un soporte en concreto
    public function tieneAlquilado(Soporte $s): bool
    {
        return in_array($s, $this->soportesAlquilados, true);
    }

    // Método para alquilar un soporte
    public function alquilar(Soporte $s): bool
    {
        if ($this->tieneAlquilado($s)) {
            echo "<br>El cliente ya tiene alquilado el soporte {$s->titulo}.<br>";
            return false;
        }

        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            echo "<br>Este cliente tiene {$this->numSoportesAlquilados} elementos alquilados. No puede alquilar más en este videoclub hasta que no devuelva algo.<br>";
            return false;
        }

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        echo "<br>Alquilado soporte a: {$this->nombre}<br>";
        $s->muestraResumen();
        return true;
    }

    // Método para listar todos los alquileres del cliente
    public function listaAlquileres(): void
    {
        if (empty($this->soportesAlquilados)) {
            echo "<br>Este cliente no tiene alquilado ningún elemento.<br>";
            return;
        }
        echo "<br>El cliente tiene " .
            count($this->soportesAlquilados) .
            " soportes alquilados<br>";
        foreach ($this->soportesAlquilados as $soporte) {
            $soporte->muestraResumen();
        }
    }

    // Método para devolver un soporte alquilado
    public function devolver(int $numSoporte): bool
    {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                unset($this->soportesAlquilados[$key]);
                $this->soportesAlquilados = array_values(
                    $this->soportesAlquilados
                );
                $this->numSoportesAlquilados--;
                echo "<br>Soporte devuelto correctamente: {$soporte->titulo}.<br>";
                $soporte->muestraResumen();
                return true;
            }
        }
        echo "<br>No se encontró el soporte en los alquileres del cliente.<br>";
        return false;
    }
}
