<?php
    require_once '../Modelo/tipoProducto.entidad.php';
    require_once '../Modelo/tipoProducto.model.php';
	// Logica de negocio
	$alm = new TipoProducto();
	$model = new TipoProductoModel();
    //echo $_REQUEST['action'];
	if(isset($_REQUEST['action']))	{
		switch($_REQUEST['action'])	{
			case 'actualizar':
                $alm->__SET('id' , $_REQUEST['id']);
				$alm->__SET('nombre', $_REQUEST['nombre']);
				$model->Actualizar($alm);
				header('Location: indexTipoProducto.php');
				break;
			case 'registrar':
				$alm->__SET('nombre', $_REQUEST['nombre']);
				$model->Registrar($alm);
				header('Location: indexTipoProducto.php');
				break;
			case 'eliminar':
				$model->Eliminar($_REQUEST['id']);
				header('Location: indexTipoProducto.php');
				break;
			case 'editar':
				$alm = $model->Obtener($_REQUEST['id']);
				break;
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <h1>FORMULARIO DE ENTRADA...</h1><h1>Tipo Producto</h1><br><br>
    <title>Anexsoft</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
</head>
<body style="padding:15px;">
    <div class="pure-g">
        <div class="pure-u-1-12">
            <form action="?action=<?php echo $alm->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                <input type="hidden" name="id" value="<?php echo $alm->__GET('id'); ?>" />
                <table style="width:500px;">
                    <tr>
                        <th style="text-align:left;">Tipo Producto</th>
                        <td><input type="text" name="nombre" placeholder="Tipo Producto" required="" value="<?php echo $alm->__GET('nombre'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                        </td>
                    </tr>
                </table>
            </form>
            <table class="pure-table pure-table-horizontal">
                <thead>
                    <tr>
                        <th style="text-align:left;">Tipo Producto</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach($model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('nombre'); ?></td>
                    <td>
                        <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                    </td>
                    <td>
                        <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <a href="menuDesplegable.html" >Volver</a>
        </div>
    </div>
</body>
</html>