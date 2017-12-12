<?php

	class TipoDocumentoModel{

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
				$stm = $this->pdo->prepare("SELECT * FROM tipo_documento ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new TipoDocumento();
					$alm->__SET('id_tipo_documento', $r->id_tipo_documento);
					$alm->__SET('nombre_tipo', $r->nombre_tipo);
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
				$stm = $this->pdo->prepare("SELECT * FROM tipo_documento WHERE id_tipo_documento = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new TipoDocumento();
				$alm->__SET('id_tipo_documento', $r->id_tipo_documento);
				$alm->__SET('nombre_tipo', $r->nombre_tipo);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM tipo_documento WHERE id_tipo_documento = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(TipoDocumento $data){
			try	{
				$sql = "UPDATE tipo_documento SET
				nombre_tipo = UPPER(?)
				WHERE id_tipo_documento = ?";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre_tipo'),
					$data->__GET('id_tipo_documento')
					)
				);
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

			public function Registrar(TipoDocumento $data){
				try{
				$sql = "INSERT INTO tipo_documento (nombre_tipo)
				VALUES (UPPER(?))";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre_tipo')
					)
				);
				} catch (Exception $e){
				die($e->getMessage());
				}
			}
}
?>