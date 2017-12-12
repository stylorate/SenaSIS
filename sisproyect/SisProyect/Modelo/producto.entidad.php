<?php

class Producto {

    private $id;
    private $nombre;
    private $descripcion;
    private $codigoBarras;
    private $version;
    private $formato;
    private $cantidad;
    private $id_tipo;
    private $id_categoria;

    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        return $this->$k = $v;
    }

}

?>