<?php
	require_once '../Modelo/usuario.entidad.php';
	require_once '../Modelo/usuario.model.php';
    require_once '../Modelo/tipoDocumento.entidad.php';
    require_once '../Modelo/tipoDocumento.model.php';
	// Logica de negocio
	$alm = new Usuario();
	$model = new UsuarioModel();
    //echo $_REQUEST['action'];
	if(isset($_REQUEST['action']))	{
		switch($_REQUEST['action'])	{
			case 'actualizar':
				$alm->__SET('id', $_REQUEST['id']);
				$alm->__SET('nombre', $_REQUEST['nombre']);
				$alm->__SET('apellido', $_REQUEST['apellido']);
                $alm->__SET('tipoDocumento', $_REQUEST['tipoDocumento']);
                $alm->__SET('documento', $_REQUEST['documento']);
                $alm->__SET('edad', $_REQUEST['edad']);
                $alm->__SET('telefono', $_REQUEST['telefono']);
                $alm->__SET('sexo', $_REQUEST['sexo']);
                $alm->__SET('username', $_REQUEST['username']);
                $alm->__SET('password', $_REQUEST['password']);
				$model->Actualizar($alm);
				header('Location: indexUsuario.php');
				break;
			case 'registrar':
				$alm->__SET('nombre', $_REQUEST['nombre']);
                $alm->__SET('apellido', $_REQUEST['apellido']);
                $alm->__SET('tipoDocumento', $_REQUEST['tipoDocumento']);
                $alm->__SET('documento', $_REQUEST['documento']);
                $alm->__SET('edad', $_REQUEST['edad']);
                $alm->__SET('telefono', $_REQUEST['telefono']);
                $alm->__SET('sexo', $_REQUEST['sexo']);
                $alm->__SET('username', $_REQUEST['username']);
                $alm->__SET('password', $_REQUEST['password']);
				$model->Registrar($alm);
				header('Location: indexUsuario.php');
				break;
			case 'eliminar':
				$model->Eliminar($_REQUEST['id']);
				header('Location: indexUsuario.php');
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
                        <th style="text-align:left;">Edad</th>
                        <td><input type="number" size="2" name="edad" required value="<?php echo $alm->__GET('edad'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Tipo Documento</th>
                        <td>
                            <select name="tipoDocumento" style="width:100%;">
                                <option value="0">--Seleccione--</option>
                                <?php
                                    $tp = new TipoDocumentoModel();
                                    foreach($tp->Listar() as $t):
                                ?>
                                <option value="<?php echo $t->__GET('id_tipo_documento') ?>" 
                                <?php echo $t->__GET('id_tipo_documento') == $alm->__GET('tipoDocumento') ? 'selected' : '' ?> >
                                <?php echo $t->__GET('nombre_tipo') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <th style="text-align:left;">Documento</th>
                        <td><input type="number" placeholder="Documento" required="" name="documento" value="<?php echo $alm->__GET('documento'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Telefono</th>
                        <td><input type="number" name="telefono" placeholder="Telefono Cliente" required="" value="<?php echo $alm->__GET('telefono'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Nombre de usuario</th>
                        <td><input type="text" name="username" placeholder="username" required="" value="<?php echo $alm->__GET('username'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Contraseña</th>
                        <td><input type="password" name="password" placeholder="password" required="" value="<?php echo $alm->__GET('password'); ?>" style="width:100%;" /></td>
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
                        <th style="text-align:left;">Edad</th>
                        <th style="text-align:left;">Tipo Documento</th>
                        <th style="text-align:left;">Documento</th>
                        <th style="text-align:left;">Telefono</th>
                        <th style="text-align:left;">Usuario</th>
                        <th style="text-align:left;">Contraseña</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach($model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('nombre'); ?></td>
                    <td><?php echo $r->__GET('apellido'); ?></td>
                    <td><?php echo $r->__GET('sexo') == 1 ? 'H' : 'F'; ?></td>
                    <td><?php echo $r->__GET('edad'); ?></td>
                    <td><?php 
                    	foreach($tp->Listar() as $t):
                    	echo $r->__GET('tipoDocumento') == $t->__GET('id_tipo_documento') ? $t->__GET('nombre_tipo') : ''; 
                    	endforeach;
                    	?></td>
                    <td><?php echo $r->__GET('documento'); ?></td>
                    <td><?php echo $r->__GET('telefono'); ?></td>
                    <td><?php echo $r->__GET('username'); ?></td>
                    <td><?php echo $r->__GET('password'); ?></td>
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