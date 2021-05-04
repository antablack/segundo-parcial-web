<?php 

$vehiculoId = "";

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


<div class="row">

    <form method="GET">
        <div class="div-veh">
            <label for="exampleFormControlSelect1">Vehiculo:</label>

            <select class="form-control form-select" id="vehiculo" name="vehiculo">
                <option <?php echo $vehiculoId=="" ? "selected" : "" ?> value=""></option>
                <?php 
                    foreach ($vehiculos as $vehiculo) {
                        echo "<option value=".$vehiculo['id']." ". ($vehiculo['id']== $vehiculoId ? "selected" : "") ." >".$vehiculo['placa']."</option>";
                    }
                ?>
            </select>
            <label for="">Fecha:</label>
            <input type="date" class="input-group date" id="">
        </div>
        <div class="div-veh">
            <label for="">Observacion:</label>
            <textarea class="form-control " placeholder="Escriba aqui la observacion" cols="" rows="5"></textarea>
        </div>
        <div class="div-veh">
            <label for="">Servicio:</label>
            <select class="form-control form-select" id="vehiculo" name="vehiculo">
                <option selected value=""></option>
                <?php 
                    foreach ($servicios as $servicio) {
                        echo "<option value=".$servicio['id'].">".$servicio['descripcion']."</option>";
                    }
                ?>
            </select>
            <input type="button" value="Add" class="btn btn-primary">
            <label for="">Cantidad:</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>Seleccione servicio</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>

            <label> Precio:</label>
            <input type="text" class="form-control">

        </div>
    </form>

</div>
<br />


<table class="table table-hover">
    <thead class="thead-dark">
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>


    </tbody>

    <tfoot class="thead-dark">
        <tr>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>CONDUCTOR</th>
        </tr>
    </tfoot>
</table>