<?php

class PrestamoModel {

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
            $stm = $this->pdo->prepare("SELECT * FROM prestamo ");
            $stm->execute();
            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                $alm = new Prestamo();
                $alm->__SET('id', $r->id_transaccion);
                $alm->__SET('idLocal', $r->id_local);
                $alm->__SET('idUsuario', $r->id_usuario);
                $alm->__SET('fechaIni', $r->fecha_inicial);
                $alm->__SET('fechaFin', $r->fecha_final);
                $result[] = $alm;
            }
            //var_dump($result);
            /* $stm2 = $this->pdo->prepare("SELECT * FROM transaccion_has_producto WHERE id_transaccion = ?");
              $stm2->execute(array());
              foreach($stm2->fetchAll(PDO::FETCH_OBJ) as $s){ */
            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM prestamo WHERE id_transaccion = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $alm = new Prestamo();
            $alm->__SET('id', $r->id_transaccion);
            $alm->__SET('idLocal', $r->id_local);
            $alm->__SET('idUsuario', $r->id_usuario);
            $alm->__SET('fechaIni', $r->fecha_inicial);
            $alm->__SET('fechaFin', $r->fecha_final);

//            $stmIdP = $this->pdo->prepare("SELECT t.id_producto, p.nombre FROM  transaccion_has_producto AS t INNER JOIN producto AS p ON t.id_producto = p.id_producto where id_transaccion = ?;");
//            $stmIdP->execute(array($id));
//            $arrayProd = array();
//            foreach ($stmIdP->fetchAll(PDO::FETCH_OBJ) as $idP) {
//                $arrayProd[] = array($idP->id_producto, $idP->nombre);
//            }
//            $alm->__SET('listProducto', $arrayProd);

            return $alm;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id) {
        try {
            $stm2 = $this->pdo
                    ->prepare("DELETE FROM transaccion_has_producto WHERE id_transaccion = ?");
            $stm2->execute(array($id));
            $stm = $this->pdo
                    ->prepare("DELETE FROM prestamo WHERE id_transaccion = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function DeleteProducto($id_transaccion, $idProducto) {
        $stm = $this->pdo
                ->prepare("DELETE FROM transaccion_has_producto WHERE id_transaccion = ? AND id_producto = ?");
        $stm->execute(array($id_transaccion, $idProducto));
    }

    public function Actualizar(Prestamo $data) {
        try {
            $sql = "UPDATE prestamo SET
				id_local = ?,
				id_usuario = ?,
				fecha_inicial = ?,
				fecha_final = ? 
				WHERE id_transaccion = ?";
            $this->pdo->prepare($sql)
                    ->execute(
                            array(
                                $data->__GET('idLocal'),
                                $data->__GET('idUsuario'),
                                $data->__GET('fechaIni'),
                                $data->__GET('fechaFin'),
                                $data->__GET('id')
                            )
            );
        } catch (Exception $e) {
            echo $sql;
            die($e->getMessage());
        }
    }

    public function Registrar(Prestamo $data) {
        try {
            $sql = "INSERT INTO prestamo (id_local,id_usuario,fecha_inicial,fecha_final)
				VALUES (?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                    ->execute(
                            array(
                                $data->__GET('idLocal'),
                                $data->__GET('idUsuario'),
                                $data->__GET('fechaIni'),
                                $data->__GET('fechaFin')
                            )
            );
            //$stmSeq = $this->pdo->prepare("SELECT CURRVAL('transaccion_has_producto_id_transaccion_has_producto_seq') AS idTransaccion;" );
            $stmSeq = $this->pdo->prepare("SELECT id_transaccion FROM prestamo ORDER BY id_transaccion DESC LIMIT 1;");
            $stmSeq->execute();
            $seq = $stmSeq->fetch(PDO::FETCH_OBJ);
            $arr = explode(",", $data->__GET('listProducto'));
            for ($i = 0; $i < count($arr); $i ++) {
                $sql2 = "INSERT INTO transaccion_has_producto (id_producto, id_transaccion)
					VALUES (?, ?)";
                $this->pdo->prepare($sql2)->execute(
                        array(
                            $arr[$i],
                            $seq->id_transaccion
                        )
                );
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}

?>