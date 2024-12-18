<?php
// Soporte.php

// Incluir la interfaz Resumible
require_once 'Resumible.php';  // Asegúrate de que la ruta sea correcta

// Declaración de la clase abstracta Soporte que implementa Resumible
abstract class Soporte implements Resumible
{
    // Propiedades de la clase
    public string $titulo;
    protected int $numero;
    private float $precio;
    private static int $iva = 21;

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
        return $this->precio * (1 + self::$iva / 100);    }

    // Método público para obtener el numero del soporte.
    public function getNumero()
    {
        return $this->numero;
    }

    // Método abstracto para mostrar el resumen, debe ser implementado en las clases hijas.
    abstract public function muestraResumen(): void;
}
?>
