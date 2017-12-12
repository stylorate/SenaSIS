<?php

	class TipoProductoModel{

		private $pdo;

		public function __CONSTRUCT(){

			try{

				$this->pdo = new PDO('pgsql:user=postgres dbname=database_tiendavideos password=Admin123');
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			}
			catch(Exception $e)
			{
			die($e->getMessage());
			}
		}

		public function Listar(){
			try	{
				$result = array();
				$stm = $this->pdo->prepare("SELECT * FROM tipo_producto ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new TipoProducto();
					$alm->__SET('id', $r->id_tipo_producto);
					$alm->__SET('nombre', $r->nombre_tipo_producto);
					$result[] = $alm;
				}
				//var_dump($result);
				return $result;
			}
			catch(Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Obtener($id){
			try	{
				$stm = $this->pdo->prepare("SELECT * FROM tipo_producto WHERE id_tipo_producto = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new TipoProducto();
				$alm->__SET('id', $r->id_tipo_producto);
				$alm->__SET('nombre', $r->nombre_tipo_producto);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM tipo_producto WHERE id_tipo_producto = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(TipoProducto $data){
			try	{
				$sql = "UPDATE tipo_producto SET
				nombre_tipo_producto = UPPER(?)
				WHERE id_tipo_producto = ?";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('id')
					)
				);
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

			public function Registrar(TipoProducto $data){
				try{
				$sql = "INSERT INTO tipo_producto (nombre_tipo_producto)
				VALUES (UPPER(?))";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre')
					)
				);
				} catch (Exception $e){
				die($e->getMessage());
				}
			}
}
?>