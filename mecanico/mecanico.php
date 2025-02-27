<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad MECANICO</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="mecanico_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="cedula" class="form-label">Cédula</label>
            <input type="number" class="form-control" id="cedula" name="cedula" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="salario" class="form-label">Salario</label>
            <input type="salario" class="form-control" id="salario" name="salario" required>
        </div>

        <div class="mb-3">
            <label for="HojadeVida" class="form-label">Hoja de Vida</label>
            <input type="HojadeVida" class="form-control" id="HojadeVida" name="HojadeVida" required>
        </div>

                <!-- Consultar la lista de empresas y desplegarlos -->
        <div class="mb-3">
            <label for="tallerAds" class="form-label">Taller</label>
            <select name="tallerAds" id="tallerAds" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../taller/taller_select.php");
                
                // Verificar si llegan datos
                if($resultadoTaller):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoTaller as $fila):
                ?>

                <!-- Opción que se genera MODIFICAR -->
                <option value="<?= $fila["codigo"]; ?>"> nombre: <?=$fila["nombre"]; ?> - codigo: <?= $fila["codigo"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("mecanico_select.php");

// Verificar si llegan datos
if($resultadoMecanico and $resultadoMecanico->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Cédula</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">salario</th>
                <th scope="col" class="text-center">Hoja de Vida</th>
                <th scope="col" class="text-center">Taller Adscrito</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoMecanico as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["cedula"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
                <td class="text-center"><?= $fila["salario"]; ?></td>
                <td class="text-center"><?= $fila["hojadevida"]; ?></td>
                <td class="text-center"><?= $fila["tallerAds"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="mecanico_delete.php" method="post">
                        <input hidden type="text" name="cedulaEliminar" value="<?= $fila["cedula"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>