<?php
namespace Dwes\ProyectoVideoclub;

// Declaración de la clase Juego que hereda de la clase Soporte.
class Juego extends Soporte
{       
    // Propiedades específicas de la clase Juego.
    public string $consola;
    public int $minNumJugadores;
    public int $maxNumJugadores;

    // Método para mostrar la cantidad de jugadores posibles.
    public function muestraJugadoresPosibles()
    {
        
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            echo "Para un jugador<br>";
        } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
            echo "Para {$this->minNumJugadores} jugadores<br>";
        } else {
            echo "De {$this->minNumJugadores} a {$this->maxNumJugadores} jugadores<br>";
        }
    }

    // Constructor de la clase Juego que inicializa las propiedades nuevas y heredadas
    public function __construct(string $titulo, int $numero, float $precio, string $consola, int $minNumJugadores, int $maxNumJugadores)
    {
        parent::__construct($titulo, $numero, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }
    // Sobrescribe el método muestraResumen de la clase Soporte para agregar información específica del juego.
    public function muestraResumen(): void
    {
        echo "Juego para: {$this->consola}<br>";
        echo "Consola: {$this->consola}<br>";
        $this->muestraJugadoresPosibles();
    }
}
