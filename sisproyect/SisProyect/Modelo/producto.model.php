<?php

class ProductoModel {

    private $pdo;

    public function __CONSTRUCT() {

        try {

            $this->pdo = new PDO('pgsql:user=postgres dbname=database_tiendavideos password=Admin123');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Listar() {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT * FROM producto ");
            $stm->execute();
            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                $alm = new Producto();
                $alm->__SET('id', $r->id_producto);
                $alm->__SET('nombre', $r->nombre);
                $alm->__SET('descripcion', $r->descripcion);
                $alm->__SET('codigoBarras', $r->codigo_barras);
                $alm->__SET('version', $r->version_producto);
                $alm->__SET('formato', $r->formato);
                $alm->__SET('id_tipo', $r->id_tipo_producto);
                $alm->__SET('id_categoria', $r->id_categoria);
                $result[] = $alm;
            }
            //var_dump($result);
            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarById($id) {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT p.id_producto, p.nombre "
                    . " FROM producto AS p INNER JOIN transaccion_has_producto "
                    . " AS t ON p.id_producto = t.id_producto "
                    . " WHERE t.id_transaccion = ?");
            $stm->execute(array($id));
            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                $alm = new Producto();
                $alm->__SET('id', $r->id_producto);
                $alm->__SET('nombre', $r->nombre);
                $result[] = $alm;
            }
            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM producto WHERE id_producto = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $alm = new Producto();
            $alm->__SET('id', $r->id_producto);
            $alm->__SET('nombre', $r->nombre);
            $alm->__SET('descripcion', $r->descripcion);
            $alm->__SET('codigoBarras', $r->codigo_barras);
            $alm->__SET('version', $r->version_producto);
            $alm->__SET('formato', $r->formato);
            $alm->__SET('id_tipo', $r->id_tipo_producto);
            $alm->__SET('id_categoria', $r->id_categoria);
            return $alm;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id) {
        try {
            $stm = $this->pdo
                    ->prepare("DELETE FROM producto WHERE id_producto = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Actualizar(Producto $data) {
        try {
            $sql = "UPDATE producto SET
				nombre = ?,
				descripcion = ?,
				codigo_barras = ?,
				version_producto = ?,
				formato = ?,
				id_tipo_producto = ?,
				id_categoria = ? 
				WHERE id_producto = ?";
            $this->pdo->prepare($sql)
                    ->execute(
                            array(
                                $data->__GET('nombre'),
                                $data->__GET('descripcion'),
                                $data->__GET('codigoBarras'),
                                $data->__GET('version'),
                                $data->__GET('formato'),
                                $data->__GET('id_tipo'),
                                $data->__GET('id_categoria'),
                                $data->__GET('id')
                            )
            );
        } catch (Exception $e) {
            echo $sql;
            die($e->getMessage());
        }
    }

    public function Registrar(Producto $data) {
        try {
            $sql = "INSERT INTO producto (nombre,descripcion,codigo_barras,version_producto,formato,id_tipo_producto,id_categoria)
				VALUES (?, ?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                    ->execute(
                            array(
                                $data->__GET('nombre'),
                                $data->__GET('descripcion'),
                                $data->__GET('codigoBarras'),
                                $data->__GET('version'),
                                $data->__GET('formato'),
                                $data->__GET('id_tipo'),
                                $data->__GET('id_categoria')
                            )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}

?>