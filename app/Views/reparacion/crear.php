
<?php 
echo count($detalles);
?>

<style>
    .div-veh {
        display: flex;
        flex-direction: row;
        justify-content: center;
        width: 100%;
        padding: 30px;

    }

    label {
        padding: 0px 10px 0px 10px;
    }

    .textArea {
        width: 100px;
    }
</style>

<script>
    function loadPrice() {
        const btnPrecio = document.getElementById('btnPrecio');
        btnPrecio.click();
    }

</script>

<form method="POST" action='<?= base_url(); ?>/index.php/reparaciones/crear'>
    <div class="row">


        <div class="div-veh">
            <label for="exampleFormControlSelect1">Vehiculo:</label>

            <select class="form-control form-select" id="vehiculo" name="vehiculo">
                <option <?php echo $vehiculoId=="" ? "selected" : "" ?>></option>
                <?php 
                    foreach ($vehiculos as $vehiculo) {
                        echo "<option value=".$vehiculo['id']." ". ($vehiculo['id']== $vehiculoId ? "selected" : "") ." >".$vehiculo['placa']."</option>";
                    }
                ?>
            </select>
            <label for="">Fecha:</label>
            <input type="date" class="input-group date" value="<?= $fecha ?>" id="fecha" name="fecha">
        </div>
        <div class="div-veh">
            <label for="">Observacion:</label>
            <textarea class="form-control " placeholder="Escriba aqui la observacion" id="observacion" name="observacion" rows="5"><?= $observacion ?></textarea>
        </div>
        <div class="div-veh">
            <label for="">Servicio:</label>
            <select class="form-control form-select" id="servicio" onchange="loadPrice()" name="servicio">
                <option <?php echo $servicioId=="" ? "selected" : "" ?>></option>
                <?php 
                    foreach ($servicios as $servicio) {
                        echo "<option value=".$servicio['id']." ". ($servicio['id']== $servicioId ? "selected" : "") ." >".$servicio['descripcion']."</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Add" name="btnAdd" class="btn btn-primary" name="btnAdd" id="btnAdd">
            <label for="">Cantidad:</label>
            <input type="number" class="form-control number" onchange="loadPrice()" name="cantidad" min="1" value='<?= $cantidad ? $cantidad : 1 ?>' max="100">
            <label> Precio:</label>
            <input type="text" disabled class="form-control" name="precio" value="<?= $precio ?>">
            <input type="submit" value="btnPrecio" id="btnPrecio" name="btnPrecio" style="display: none;"/>
        </div>
    </div>

    <br />
    <div class="div-table">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>SERVICIO</th>
                    <th>PRECIO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>

            <tbody>

                <?php 
                    foreach ($detalles as $detalle) {
                        echo "
                        <tr>
                        <td>".$detalle['id']."</td>
                        <td>".$detalle['servicio']."</td>
                        <td>".$detalle['precio']."</td>
                        <td>".$detalle['cantidad']."</td>
                        </tr>
                        ";
                    }
                ?>

            </tbody>
        </table>
    </div>
    <div class="div-veh">
        <label> Costo:</label>
        <input type="text" disabled class="form-control" value="<?= $total?>">
    </div>
    <div class="div-veh">

        <input type="submit" name="btnEnviar" value="Enviar" class="btn btn-success">
        <input type="submit" value="cancelar" name="btnCancelar" class="btn btn-danger">
    </div>
</form>