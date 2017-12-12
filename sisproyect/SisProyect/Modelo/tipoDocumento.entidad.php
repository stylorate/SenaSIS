<?php
 	class TipoDocumento{
 		private $id_tipo_documento;
 		private $nombre_tipo;



 		public function __GET($k){ 
			return $this->$k;

		}
		public function __SET($k,$v){	
			return $this->$k = $v;
		}

	}


?>