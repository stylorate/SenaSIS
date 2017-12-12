<?php
require_once '../Modelo/prestamo.entidad.php';
require_once '../Modelo/prestamo.model.php';
require_once '../Modelo/usuario.entidad.php';
require_once '../Modelo/usuario.model.php';
require_once '../Modelo/local.entidad.php';
require_once '../Modelo/local.model.php';
require_once '../Modelo/producto.entidad.php';
require_once '../Modelo/producto.model.php';
// Logica de negocio
$alm = new Prestamo();
$model = new PrestamoModel();
$almProd = new Producto();
$objPro = new ProductoModel();
//echo $_REQUEST['action'];
if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'actualizar':
            $alm->__SET('id', $_REQUEST['id']);
            $alm->__SET('idUsuario', $_REQUEST['idUsuario']);
            $alm->__SET('idLocal', $_REQUEST['idLocal']);
            $alm->__SET('fechaIni', $_REQUEST['fechaIni']);
            $alm->__SET('fechaFin', $_REQUEST['fechaFin']);
            $model->Actualizar($alm);
            $almProd = null;
            header('Location: indexPrestamo.php');
            break;
        case 'registrar':
            $alm->__SET('idUsuario', $_REQUEST['idUsuario']);
            $alm->__SET('idLocal', $_REQUEST['idLocal']);
            $alm->__SET('fechaIni', $_REQUEST['fechaIni']);
            $alm->__SET('fechaFin', $_REQUEST['fechaFin']);
            $alm->__SET('listProducto', $_REQUEST['listId']);
            $model->Registrar($alm);
            $almProd = null;
            header('Location: indexPrestamo.php');
            break;
        case 'eliminar':
            $model->Eliminar($_REQUEST['id']);
            $almProd = null;
            header('Location: indexPrestamo.php');
            break;
        case 'editar':
            $alm = $model->Obtener($_REQUEST['id']);
            $almProd = $objPro->ListarById($_REQUEST['id']);
            var_dump($almProd);
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
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script>

        var k = 1;
        var id = [];
        function agregarProducto() {
            var i = 0;
            var camp = $("#campProducto");
            $.ajax({
                type: "POST",
                url: "../Controlador/productoHandler.php",
                success: function (resp) {
                    var data = JSON.parse(resp);
                    var optionArray = [];
                    var arr = [];
                    jQuery.each(data, function (iw, val) {
                        if (val[0] == "id") {
                            arr[0] = val[1];
                        }
                        if (val[0] == "nombre") {
                            arr[1] = val[1];
                        }
                        if (arr.length == 2) {
                            optionArray[i] = arr;
                            i++;
                            arr = [];
                        }
                    });
                    var htmlText = "<td><select id='idProdcto[" + k + "]'>";
                    for (var j = 0; j < optionArray.length; j++) {
                        htmlText += "<option value='" + optionArray[j][0] + "'>" + optionArray[j][1] + "</option>";
                    }
                    camp.append(htmlText + "</select><td>");
                    id.push(k);
                    k++;
                    document.getElementById("listId").value = id;
                }

            });
            //camp.html("<select>");

        }
        function eliminarProducto() {
            var camp = id[id.length - 1];
            document.getElementById("idProdcto[" + camp + "]").remove();
            id.pop();
            document.getElementById("listId").value = id;
        }


    </script>
</head>
<body style="padding:15px;">
    <div class="pure-g">
        <div class="pure-u-1-12">
            <form action="?action=<?php echo $alm->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                <input type="hidden" name="id" value="<?php echo $alm->__GET('id'); ?>" />
                <input type="hidden" name="listId" id="listId" value="<?php echo $alm->__GET('id'); ?>" />
                <table style="width:500px;">
                    <tr>
                        <th style="text-align:left;">Fecha Inicial</th>
                        <td><input type="date" name="fechaIni" required value="<?php echo $alm->__GET('fechaIni'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Fecha Final</th>
                        <td><input type="date" name="fechaFin" required value="<?php echo $alm->__GET('fechaFin'); ?>" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Local</th>
                        <td>
                            <select name="idLocal" style="width:100%;">
                                <option value="0">--Seleccione--</option>
                                <?php
                                $lo = new LocalModel();
                                foreach ($lo->Listar() as $l):
                                    ?>
                                    <option value="<?php echo $l->__GET('id'); ?>"
                                            <?php echo $l->__GET('id') == $alm->__GET('idLocal') ? 'selected' : ''; ?>>
                                        <?php echo $l->__GET('nombre'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Usuario</th>
                        <td>
                            <select name="idUsuario" style="width:100%;">
                                <option value="0">--Seleccione--</option>
                                <?php
                                $usu = new UsuarioModel();
                                foreach ($usu->Listar() as $u):
                                    ?>
                                    <option value="<?php echo $u->__GET('id') ?>"
                                            <?php echo $u->__GET('id') == $alm->__GET('idUsuario') ? 'selected' : '' ?>>
                                        <?php echo $u->__GET('nombre') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="campProducto">
                        <th style="text-align:left;">Producto</th>

                    </tr>
                    <tr></tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="agrega_producto" onclick="agregarProducto();" value="Agregar Producto"
                                   class="pure-button pure-button-primary"/>
                        </td>
                        <td colspan="2">
                            <input type="button" id="elimina_producto" onclick="eliminarProducto();" value="Eliminar Producto"
                                   class="pure-button pure-button-primary"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                        </td>
                    </tr>
                </table>
                <?php if ($almProd != null) { ?>
                    <table border="1">
                        <thead>
                        <th>Producto</th>
                        <th>Eliminar</th>
                        </thead>
                        <?php foreach ($almProd as $producto): ?>
                        <tr>
                            <td><?php echo $producto->__GET('nombre'); ?></td>
                            <td><a href="<?php $model->DeleteProducto($alm->__GET('id') ,$producto->__GET('id')); ?>"> Eliminar</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <?php } ?>
            </form>
            <table class="pure-table pure-table-horizontal">
                <thead>
                    <tr>
                        <th style="text-align:left;">Fecha Inicial</th>
                        <th style="text-align:left;">Fecha Final</th>
                        <th style="text-align:left;">Local</th>
                        <th style="text-align:left;">Usuario</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($model->Listar() as $r): ?>
                    <tr>
                        <td><?php echo $r->__GET('fechaIni'); ?></td>
                        <td><?php echo $r->__GET('fechaFin'); ?></td>
                        <td><?php
                            foreach ($lo->Listar() as $l):
                                echo $r->__GET('idLocal') == $l->__GET('id') ? $l->__GET('nombre') : '';
                            endforeach;
                            ?></td>
                        <td><?php
                            foreach ($usu->Listar() as $u):
                                echo $r->__GET('idUsuario') == $u->__GET('id') ? $u->__GET('nombre') : '';
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