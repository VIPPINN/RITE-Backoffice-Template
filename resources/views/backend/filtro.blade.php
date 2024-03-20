<div class="row">
    <?php 
    $urlOrder = explode("/","$_SERVER[REQUEST_URI]");
    $activo = 'checked'; $inactivo = ''; $todos = '';
    if(isset($urlOrder[4])){
        switch ($urlOrder[4]) {
            case 1:
                $activo = "checked";
                break;
            case 0:
                $inactivo = "checked";
                $activo = '';
                break;
            default:
                $todos = "checked";
                $activo = '';
                break;
        }
    }
    ?>
    <form>
        <div class="form-check form-check-inline">
            <label class="form-check-label">FILTROS</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" class="form-check-input" 
                name="rbFilter" id="rbActivo" 
                onclick="orderFunction(1)" <?php echo $activo; ?>>
            <label class="form-check-label" for="rbActivo">Activos</label>
        </div>
        <div class="form-check form-check-inline ms-4">
            <input type="radio" class="form-check-input" 
                name="rbFilter" id="rbInactivo"
                onclick="orderFunction(0)"<?php echo $inactivo; ?>>
            <label class="form-check-label" for="rbInactivo">Inactivos</label>
        </div>
        <div class="form-check form-check-inline ms-4">
            <input type="radio" class="form-check-input" 
                name="rbFilter" id="rbTodos"
                onclick="orderFunction(9)" <?php echo $todos; ?>>
            <label class="form-check-label" for="rbTodos">Todos</label>
        </div>
    </form>
</div>