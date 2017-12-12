<?php

	class CargoModel{

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
				$stm = $this->pdo->prepare("SELECT * FROM cargo ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new Cargo();
					$alm->__SET('id', $r->id_cargo);
					$alm->__SET('nombre', $r->nombre_cargo);
					$alm->__SET('descripcion', $r->descripcion);
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
				$stm = $this->pdo->prepare("SELECT * FROM cargo WHERE id_cargo = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new Cargo();
				$alm->__SET('id', $r->id_cargo);
				$alm->__SET('nombre', $r->nombre_cargo);
				$alm->__SET('descripcion', $r->descripcion);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM cargo WHERE id_cargo = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(Cargo $data){
			try	{
				$sql = "UPDATE cargo SET
				nombre_cargo = UPPER(?),
				descripcion = ? 
				WHERE id_cargo = ?";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('descripcion'),
					$data->__GET('id')
					)
				);
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

			public function Registrar(Cargo $data){
				try{
				$sql = "INSERT INTO cargo (nombre_cargo, descripcion)
				VALUES (UPPER(?), ? )";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('descripcion')
					)
				);
				} catch (Exception $e){
				die($e->getMessage());
				}
			}
}
?>