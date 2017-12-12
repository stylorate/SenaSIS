<?php
	require_once '../Modelo/cliente.entidad.php';
	require_once '../Modelo/cliente.model.php';
	// Logica de negocio
	$alm = new Cliente();
	$model = new ClienteModel();
    //echo $_REQUEST['action'];
	if(isset($_REQUEST['action']))	{
		switch($_REQUEST['action'])	{
			case 'actualizar':
				$alm->__SET('id', $_REQUEST['id']);
				$alm->__SET('nombre', $_REQUEST['nombre']);
				$alm->__SET('apellido', $_REQUEST['apellido']);
				$alm->__SET('aexo', $_REQUEST['sexo']);
				$alm->__SET('fecha_nacimiento', $_REQUEST['fecha_nacimiento']);
				$alm->__SET('correo', $_REQUEST['correo']);
				$alm->__SET('telefono', $_REQUEST['telefono']);
				$model->Actualizar($alm);
				header('Location: indexCliente.php');
				break;
			case 'registrar':
				$alm->__SET('nombre', $_REQUEST['nombre']);
				$alm->__SET('apellido', $_REQUEST['apellido']);
				$alm->__SET('sexo', $_REQUEST['sexo']);
				$alm->__SET('fecha_nacimiento', $_REQUEST['fecha_nacimiento']);
				$alm->__SET('correo', $_REQUEST['correo']);
				$alm->__SET('telefono', $_REQUEST['telefono']);
				$model->Registrar($alm);
				header('Location: indexCliente.php');
				break;
			case 'eliminar':
				$model->Eliminar($_REQUEST['id']);
				header('Location: indexCliente.php');
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
    <h1>FORMULARIO DE ENTRADA...</h1><h1>CLIENTES</h1><br><br>
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
                        <th style="text-align:left;">Nombre</th>
                        <td><input type="text" name="nombre" placeholder="Nombre Cliente" required="" value="<?php echo $alm->__GET('nombre'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Apellido</th>
                        <td><input type="text" name="apellido" placeholder="Apellidos Cliente" required="" value="<?php echo $alm->__GET('apellido'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Sexo</th>
                        <td>
                            <select name="sexo" style="width:100%;">
                                <option value="1" <?php echo $alm->__GET('sexo') == 1 ? 'selected' : ''; ?>>Masculino</option>
                                <option value="2" <?php echo $alm->__GET('sexo') == 2 ? 'selected' : ''; ?>>Femenino</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Fecha</th>
                        <td><input type="date" name="fecha_nacimiento" required value="<?php echo $alm->__GET('fecha_nacimiento'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Correo</th>
                        <td><input type="email" placeholder="Mail Cliente" required="" name="correo" value="<?php echo $alm->__GET('correo'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Telefono</th>
                        <td><input type="number" name="telefono" placeholder="Telefono Cliente" required="" value="<?php echo $alm->__GET('telefono'); ?>" style="width:100%;" /></td>
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
                        <th style="text-align:left;">Nombre</th>
                        <th style="text-align:left;">Apellido</th>
                        <th style="text-align:left;">Sexo</th>
                        <th style="text-align:left;">Nacimiento</th>
                        <th style="text-align:left;">Mail</th>
                        <th style="text-align:left;">Teléfono</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach($model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('nombre'); ?></td>
                    <td><?php echo $r->__GET('apellido'); ?></td>
                    <td><?php echo $r->__GET('sexo') == 1 ? 'H' : 'F'; ?></td>
                    <td><?php echo $r->__GET('fecha_nacimiento'); ?></td>
                    <td><?php echo $r->__GET('correo'); ?></td>
                    <td><?php echo $r->__GET('telefono'); ?></td>
                    <td>
                        <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                    </td>
                    <td>
                        <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div><a href="menuDesplegable.html">Volver</div>
</body>
</html>