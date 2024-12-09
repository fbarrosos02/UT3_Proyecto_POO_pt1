<?php
namespace Dwes\ProyectoVideoclub;

// Declaración de la clase CintaVideo que hereda de la clase Soporte.
Class CintaVideo extends Soporte {
    
    // Propiedad específica de la clase CintaVideo.
    private float $duracion;

    // Constructor de la clase CintaVideo que incluye duración y los atributos heredados.
    public function __construct (string $titulo, int $numero, float $precio, float $duracion){
        parent::__construct($titulo, $numero, $precio);
        $this->duracion = $duracion;
    }

    // Metodo que sobrescribe el método muestraResumen de la clase Soporte.
    public function muestraResumen(): void {
        echo "Película en VHS:<br>";
        echo "Duración: {$this->duracion} minutos<br>";
    }
}
?>
