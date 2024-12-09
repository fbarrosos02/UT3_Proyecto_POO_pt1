<?php
namespace Dwes\ProyectoVideoclub;

// Declaración de la clase Dvd que hereda de la clase Soporte.
Class Dvd extends Soporte{
    
// Propiedades específicas de la clase Dvd.
public string $idiomas;
private string $formatPantalla;

// Constructor para inicializar las propiedades del DVD y las heredadas de Soporte.
public function __construct(string $titulo, int $numero, float $precio, string $idiomas, string $formatPantalla)
{
    parent::__construct($titulo, $numero, $precio);
    $this->idiomas = $idiomas;
    $this->formatPantalla = $formatPantalla;
}
// Sobrescritura del método muestraResumen para incluir detalles específicos del DVD.
public function muestraResumen(): void
{
    echo "Película en DVD:<br>";
    echo "Idiomas: {$this->idiomas}<br>";
    echo "Formato de pantalla: {$this->formatPantalla}<br>";
}
}
?>