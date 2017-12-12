<?php
	class Usuario{
		private $id;
		private $nombre;
		private $apellido;
		private $tipoDocumento;
		private $documento;
		private $sexo;
		private $edad;
		private $telefono;
		private $username;
		private $password;


		public function __GET($k){ 
			return $this->$k;

		}
		public function __SET($k,$v){	
			return $this->$k = $v;
		}
	}



?>