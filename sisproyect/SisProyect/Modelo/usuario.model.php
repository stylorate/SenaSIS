<?php

	class UsuarioModel{

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
				$stm = $this->pdo->prepare("SELECT * FROM usuario ");
				$stm->execute();
				foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
					$alm = new Usuario();
					$alm->__SET('id', $r->id_usuario);
					$alm->__SET('nombre', $r->nombre);
					$alm->__SET('apellido', $r->apellido);
					$alm->__SET('tipoDocumento', $r->id_tipo_documento);
					$alm->__SET('documento', $r->documento);
					$alm->__SET('sexo', $r->sexo);
					$alm->__SET('edad', $r->edad);
					$alm->__SET('telefono', $r->telefono);
					$alm->__SET('username', $r->username);
					$alm->__SET('password', $r->password);
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
				$stm = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
				$stm->execute(array($id));
				$r = $stm->fetch(PDO::FETCH_OBJ);
				$alm = new Usuario();
				$alm->__SET('id', $r->id_usuario);
					$alm->__SET('nombre', $r->nombre);
					$alm->__SET('apellido', $r->apellido);
					$alm->__SET('tipoDocumento', $r->id_tipo_documento);
					$alm->__SET('documento', $r->documento);
					$alm->__SET('sexo', $r->sexo);
					$alm->__SET('edad', $r->edad);
					$alm->__SET('telefono', $r->telefono);
					$alm->__SET('username', $r->username);
					$alm->__SET('password', $r->password);
				return $alm;
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

		public function Eliminar($id){
			try	{
				$stm = $this->pdo
				->prepare("DELETE FROM usuario WHERE id_usuario = ?");
				$stm->execute(array($id));
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}
		
		public function Actualizar(Usuario $data){
			try	{
				$sql = "UPDATE usuario SET
				nombre = ?,
				apellido = ?,
				edad = ?,
				telefono = ?,
				documento = ?,
				username = ?,
				password = ?,
				sexo = ?,
				id_tipo_documento = ?
				WHERE id_usuario = ?";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('apellido'),
					$data->__GET('edad'),
					$data->__GET('telefono'),
					$data->__GET('documento'),
					$data->__GET('username'),
					$data->__GET('password'),
					$data->__GET('sexo'),
					$data->__GET('tipoDocumento'),
					$data->__GET('id')
					)
				);
			} catch (Exception $e)	{
				die($e->getMessage());
			}
		}

			public function Registrar(Usuario $data){
				try{
				$sql = "INSERT INTO usuario (nombre,apellido,edad,telefono,documento,username,password,sexo,id_tipo_documento)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$this->pdo->prepare($sql)
				->execute(
					array(
					$data->__GET('nombre'),
					$data->__GET('apellido'),
					$data->__GET('edad'),
					$data->__GET('telefono'),
					$data->__GET('documento'),
					$data->__GET('username'),
					$data->__GET('password'),
					$data->__GET('sexo'),
					$data->__GET('tipoDocumento'),
					)
				);
				} catch (Exception $e){
				die($e->getMessage());
				}
			}
}
?>