<?php
require_once "autoload.php";

use Dwes\ProyectoVideoclub\Videoclub;

$vc = new Videoclub("Severo 8A");

// Agregar productos de prueba
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1);
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("Torrente", 4.5, "es", "16:9");
$vc->incluirDvd("Origen", 4.5, "es,en,fr", "16:9");
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9");
$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
$vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

// Listar productos
$vc->listarProductos();

// Agregar socios
$vc->incluirSocio("Amancio Ortega");
$vc->incluirSocio("Pablo Picasso", 2);

// Alquilar productos con el método alquilarSocioProductos
$vc->alquilarSocioProductos(1, [2, 3]);

// Intentar alquilar el soporte 2 nuevamente al socio 1 (no debe permitir)
$vc->alquilaSocioProducto(1, 2);

// Intentar alquilar el soporte 6 al socio 1 (supera el límite de alquileres)
$vc->alquilaSocioProducto(1, 6);

// Listar socios
$vc->listarSocios();
echo "Productos alquilados: " . $vc->getNumProductosAlquilados() . "<br>";
echo "Total de alquileres: " . $vc->getNumTotalAlquileres() . "<br>";

// Devolver productos alquilados
$vc->devolverSocioProducto(1, 2);

// Listar socios después de la devolución
$vc->listarSocios();
echo "Productos alquilados después de devolución: " . $vc->getNumProductosAlquilados() . "<br>";
echo "Total de alquileres después de devolución: " . $vc->getNumTotalAlquileres() . "<br>";
?>
