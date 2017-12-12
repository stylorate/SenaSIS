<?php
 	class Categoria{
 		private $id;
 		private $nombre;
 		private $descripcion;



 		public function __GET($k){ 
			return $this->$k;

		}
		public function __SET($k,$v){	
			return $this->$k = $v;
		}

	}


?>