<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$codigo = $_POST["codigo"];
$fechacreacion = $_POST["fechacreacion"];
$valor = $_POST["valor"];
$mecanico = $_POST["mecanico"];
$reparacion = $_POST["reparacion"];


// Si viene vacío, guardar como NULL
if ($reparacion == "NULL"):
	$reparacion = NULL;
     // Lo ponemos como cadena para que se interprete como NULL en la consulta
else:
    $reparacion = $reparacion; // Si viene algo, se guarda con comillas
endif;

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `reparacion`(`codigo`,`fecha`, `valor`, `mecanico`, `reparacion_garantia`) VALUES ('$codigo', '$fechacreacion', '$valor', '$mecanico', '$reparacion')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: reparacion.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);