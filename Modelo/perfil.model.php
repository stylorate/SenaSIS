<?php

	class PerfilModel{

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
				$stm = $this->pdo->prepare("SELECT * FROM perfil ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new Perfil();
					$alm->__SET('id', $r->id_perfil);
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
				$stm = $this->pdo->prepare("SELECT * FROM perfil WHERE id_perfil = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new Perfil();
				$alm->__SET('id', $r->id_perfil);
				$alm->__SET('descripcion', $r->descripcion);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM perfil WHERE id_perfil = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(Perfil $data){
			try	{
				$sql = "UPDATE perfil SET
				descripcion = UPPER(?)
				WHERE id_perfil = ?";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('descripcion'),
					$data->__GET('id')
					)
				);
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

			public function Registrar(Perfil $data){
				try{
				$sql = "INSERT INTO perfil (descripcion)
				VALUES (UPPER(?))";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('descripcion')
					)
				);
				} catch (Exception $e){
				die($e->getMessage());
				}
			}
}
?>