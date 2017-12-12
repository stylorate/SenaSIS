<?php

	class LocalModel{

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
				$stm = $this->pdo->prepare("SELECT * FROM local ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new Local();
					$alm->__SET('id', $r->id_local);
					$alm->__SET('nombre', $r->nombre_local);
					$alm->__SET('direccion', $r->direccion);
					$alm->__SET('idUsuario', $r->id_usuario);
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
				$stm = $this->pdo->prepare("SELECT * FROM local WHERE id_local = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new Local();
				$alm->__SET('id', $r->id_local);
					$alm->__SET('nombre', $r->nombre_local);
					$alm->__SET('direccion', $r->direccion);
					$alm->__SET('idUsuario', $r->id_usuario);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM local WHERE id_local = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(Local $data){
			try	{
				$sql = "UPDATE local SET
				nombre_local = UPPER(?),
				direccion = ? ,
				id_usuario = ?
				WHERE id_local = ?";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('direccion'),
					$data->__GET('idUsuario'),
					$data->__GET('id')
					)
				);
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

			public function Registrar(Local $data){
				try{
				$sql = "INSERT INTO local (nombre_local, direccion, id_usuario)
				VALUES (UPPER(?), ? , ?)";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('direccion'),
					$data->__GET('idUsuario')
					)
				);
				} catch (Exception $e){
				die($e->getMessage());
				}
			}
}
?>