<?php
namespace Dwes\ProyectoVideoclub;

// Soporte.php

// Incluir la interfaz Resumible
require_once 'Resumible.php';  

// Declaración de la clase abstracta Soporte que implementa Resumible
abstract class Soporte implements Resumible
{
    // Propiedades de la clase
    public string $titulo;
    protected int $numero;
    private float $precio;
    private static int $iva = 21;
    public bool $alquilado = false;

    // Constructor para inicializar los valores de una instancia de Soporte.
    public function __construct(string $titulo, int $numero, float $precio){
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    // Método público para obtener el precio base del soporte.
    public function getPrecio(){
        return $this->precio;
    }

    // Método público para obtener el precio con IVA.
    public function getPrecioConIva(){
        return $this->precio * 21;
    }

    // Método público para obtener el numero del soporte.
    public function getNumero()
    {
        return $this->numero;
    }

    // Método abstracto para mostrar el resumen, debe ser implementado en las clases hijas.
    abstract public function muestraResumen(): void;
}
?>
