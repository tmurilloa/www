<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Consulta 1</h1>

<p class="mt-3">
i. El primer botón debe mostrar los datos de las tres reparaciones de mayor valor junto con los datos de los mecánicos asociados a cada una de estas reparaciones (en caso de empates, usted decide cómo proceder).
</p>

<p class="mt-3">
ii. El segundo botón debe mostrar el código y el nombre de los talleres de los dos talleres que tienen la mayor cantidad de reparaciones (en caso de empates, usted decide cómo proceder).
</p>

<!-- Formulario para los botones -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <form method="POST">
        <button type="submit" name="btn_3_reparaciones" class="btn btn-primary">3 reparaciones</button>
        <button type="submit" name="btn_2_talleres" class="btn btn-primary">2 talleres</button>
    </form>
</div>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Inicializar las variables de consulta
$query1 = "";
$query2 = "";
$resultadoC1 = null;
$resultadoC2 = null;

// Verificar si se ha presionado el botón "3 reparaciones"
if (isset($_POST['btn_3_reparaciones'])) {
    $query1 = "SELECT r.codigo, r.fecha, r.valor, r.reparacion_garantia, 
                     m.cedula, m.nombre, m.salario
              FROM reparacion r
              JOIN mecanico m ON r.mecanico = m.cedula
              ORDER BY r.valor DESC
              LIMIT 3;";
}

// Verificar si se ha presionado el botón "2 talleres"
if (isset($_POST['btn_2_talleres'])) {
    $query2 = "SELECT t.codigo, t.nombre, COUNT(r.codigo) AS total_reparaciones
                FROM taller t
                JOIN mecanico m ON t.codigo = m.tallerAds
                JOIN reparacion r ON m.cedula = r.mecanico
                GROUP BY t.codigo, t.nombre
                ORDER BY total_reparaciones DESC
                LIMIT 2;";
}

// Ejecutar consultas según corresponda
if (!empty($query1)) {
    $resultadoC1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
}

if (!empty($query2)) {
    $resultadoC2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
}

// Mostrar tabla de reparaciones si hay resultados
if ($resultadoC1 && $resultadoC1->num_rows > 0):
?>
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código Reparación</th>
                <th scope="col" class="text-center">Fecha Reparación</th>
                <th scope="col" class="text-center">Valor Reparación</th>
                <th scope="col" class="text-center">Cédula Mecánico</th>
                <th scope="col" class="text-center">Nombre Mecánico</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultadoC1)): ?>
            <tr>
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha"]; ?></td>
                <td class="text-center"><?= $fila["valor"]; ?></td>
                <td class="text-center"><?= $fila["cedula"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
elseif (!empty($query1)): // Mostrar error solo si la consulta fue ejecutada
?>
<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para la consulta de reparaciones.
</div>
<?php
endif;
?>

<!-- Mostrar tabla de talleres si hay resultados -->
<?php
if ($resultadoC2 && $resultadoC2->num_rows > 0):
?>
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código Taller</th>
                <th scope="col" class="text-center">Nombre Taller</th>
                <th scope="col" class="text-center">Total Reparaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultadoC2)): ?>
            <tr>
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
                <td class="text-center"><?= $fila["total_reparaciones"]; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
elseif (!empty($query2)): // Mostrar error solo si la consulta fue ejecutada
?>
<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para la consulta de talleres.
</div>
<?php
endif;

// Cerrar conexión con la BD
mysqli_close($conn);

include "../includes/footer.php";
?>
