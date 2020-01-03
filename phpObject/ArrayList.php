<?php
	class arraylist{
		private $data=array();
		
		function __construct(){}
		public function add($value){array_push($this->data,$value);}
		public function remove($key){
			 if(array_key_exists($key, $this->data)){
        		unset($this->data[$key]);
    		 }
		}
		public function isEmpty(){return empty($this->data);}
		public function get($key){
			if($this->data==NULL){
				return NULL;
			}else{return $this->data[$key];}
		}
		public function printData($key){echo $this->data[$key];}
		public function size(){return count($this->data);}
	}
?>