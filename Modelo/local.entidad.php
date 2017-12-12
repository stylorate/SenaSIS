<?php
 	class Local{
 		private $id;
 		private $nombre;
 		private $direccion;
 		private $idUsuario;



 		public function __GET($k){ 
			return $this->$k;

		}
		public function __SET($k,$v){	
			return $this->$k = $v;
		}

	}


?>