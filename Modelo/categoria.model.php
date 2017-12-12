<?php

	class CategoriaModel{

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
				$stm = $this->pdo->prepare("SELECT * FROM categoria ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new Categoria();
					$alm->__SET('id', $r->id_categoria);
					$alm->__SET('nombre', $r->nombre_categoria);
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
				$stm = $this->pdo->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new Categoria();
				$alm->__SET('id', $r->id_categoria);
				$alm->__SET('nombre', $r->nombre_categoria);
				$alm->__SET('descripcion', $r->descripcion);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM categoria WHERE id_categoria = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(Categoria $data){
			try	{
				$sql = "UPDATE categoria SET
				nombre_categoria = UPPER(?),
				descripcion = ? 
				WHERE id_categoria = ?";
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

			public function Registrar(Categoria $data){
				try{
				$sql = "INSERT INTO categoria (nombre_categoria, descripcion)
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