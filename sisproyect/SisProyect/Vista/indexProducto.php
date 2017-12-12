<?php
	require_once '../Modelo/producto.entidad.php';
	require_once '../Modelo/producto.model.php';
    require_once '../Modelo/tipoProducto.entidad.php';
    require_once '../Modelo/tipoProducto.model.php';
    require_once '../Modelo/categoria.entidad.php';
    require_once '../Modelo/categoria.model.php';
	// Logica de negocio
	$alm = new Producto();
	$model = new ProductoModel();
    //echo $_REQUEST['action'];
	if(isset($_REQUEST['action']))	{
		switch($_REQUEST['action'])	{
			case 'actualizar':
				$alm->__SET('id', $_REQUEST['id']);
				$alm->__SET('nombre', $_REQUEST['nombre']);
				$alm->__SET('descripcion', $_REQUEST['descripcion']);
                $alm->__SET('codigoBarras', $_REQUEST['codigo']);
                $alm->__SET('version', $_REQUEST['version']);
                $alm->__SET('formato', $_REQUEST['formato']);
                $alm->__SET('id_tipo', $_REQUEST['tipoProducto']);
                $alm->__SET('id_categoria', $_REQUEST['categoria']);
				$model->Actualizar($alm);
				header('Location: indexProducto.php');
				break;
			case 'registrar':
                $alm->__SET('nombre', $_REQUEST['nombre']);
                $alm->__SET('descripcion', $_REQUEST['descripcion']);
                $alm->__SET('codigoBarras', $_REQUEST['codigo']);
                $alm->__SET('version', $_REQUEST['version']);
                $alm->__SET('formato', $_REQUEST['formato']);
                $alm->__SET('id_tipo', $_REQUEST['tipoProducto']);
                $alm->__SET('id_categoria', intval($_REQUEST['categoria']));
				$model->Registrar($alm);
				header('Location: indexProducto.php');
				break;
			case 'eliminar':
				$model->Eliminar($_REQUEST['id']);
				header('Location: indexProducto.php');
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
    <h1>FORMULARIO DE ENTRADA...</h1><h1>PRODUCTOS</h1><br><br>
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
                        <th style="text-align:left;">Descripcion</th>
                        <td><input type="text" name="descripcion" placeholder="Descripcion" required="" value="<?php echo $alm->__GET('descripcion'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Codigo de Barras</th>
                        <td><input type="number" size="2" name="codigo" required value="<?php echo $alm->__GET('codigoBarras'); ?>" style="width:100%;" /></td>
                    </tr>                    
                    <tr>
                        <th style="text-align:left;">Version</th>
                        <td><input type="number" size="2" name="version" required value="<?php echo $alm->__GET('version'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Formato</th>
                        <td><input type="text" size="2" name="formato" required value="<?php echo $alm->__GET('formato'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Tipo Producto</th>
                        <td>
                            <select name="tipoProducto" style="width:100%;">
                                <option value="0">--Seleccione--</option>
                                <?php
                                    $tp = new TipoProductoModel();
                                    foreach($tp->Listar() as $t):
                                ?>
                                <option value="<?php echo $t->__GET('id') ?>"
                                <?php echo $t->__GET('id') ==  $alm->__GET('id_tipo') ? 'selected' : '' ?>>
                                <?php echo $t->__GET('nombre') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Categoria</th>
                        <td>
                            <select name="categoria" style="width:100%;">
                                <option value="0">--Seleccione--</option>
                                <?php
                                    $cat = new CategoriaModel();
                                    foreach($cat->Listar() as $c):
                                ?>
                                <option value="<?php echo $c->__GET('id') ?>"
                                <?php echo $c->__GET('id') ==  $alm->__GET('id_categoria') ? 'selected' : '' ?>>
                                <?php echo $c->__GET('nombre') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
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
                        <th style="text-align:left;">Descripcion</th>
                        <th style="text-align:left;">Codigo de Barras</th>
                        <th style="text-align:left;">Version</th>
                        <th style="text-align:left;">Formato</th>
                        <th style="text-align:left;">Tipo Producto</th>
                        <th style="text-align:left;">Categoria</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach($model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('nombre'); ?></td>
                    <td><?php echo $r->__GET('descripcion'); ?></td>
                    <td><?php echo $r->__GET('codigoBarras'); ?></td>
                    <td><?php echo $r->__GET('version'); ?></td>
                    <td><?php echo $r->__GET('formato'); ?></td>
                    <td><?php 
                        foreach($tp->Listar() as $t):
                        echo $r->__GET('id_tipo') == $t->__GET('id') ? $t->__GET('nombre') : ''; 
                        endforeach;
                        ?></td>
                    <td><?php 
                        foreach($cat->Listar() as $c):
                        echo $r->__GET('id_categoria') == $c->__GET('id') ? $c->__GET('nombre') : ''; 
                        endforeach;
                        ?></td>
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