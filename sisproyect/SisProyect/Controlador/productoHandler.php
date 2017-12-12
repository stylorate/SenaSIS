<?php
require_once("../Modelo/producto.model.php");
require_once("../Modelo/producto.entidad.php");
$obj = new ProductoModel();
$result = $obj->Listar();
//var_dump($result);
$res = array();
foreach ($obj->Listar() as $o):
$res[] = array("id",$o->__GET("id"));
$res[] = array("nombre",$o->__GET("nombre"));
endforeach;
echo json_encode($res);
?>
