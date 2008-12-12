<?php
	class OrderRender {
		public $default_order = "name";
		public $default_dimension = "desc";
		public $field, $label, $url, $html;
		public $matcher = array();
		
		public function OrderRender($field, $label){
			$this->field = $field;
			$this->lable = $label;
		}
		
		public function render(){			
			$this->detect_order();			
			$this->change_order();
									
			if ($this->is_selected_field($this->matcher['order'][1]) || $this->is_default_field($this->matcher['order'][1]))
				$this->html = $this->flags();
			else $this->html = $this->link();
					
			print $this->html;
		}
		
		private function flags(){
			if ($this->matcher['dimension'][1] == "asc") return ($this->asc(). $this->link() . $this->asc());
			else return ($this->desc(). $this->link() . $this->desc());
		}
		
		private function link(){
			return '<a href="'.$this->url.'">'.$this->lable.'</a>';
		}
		
		private function desc(){
			return '<img height="5" width="9" src="/pics/def/up.gif"/>';
		}
		
		private function asc(){
			return '<img height="5" width="9" src="/pics/def/down.gif"/>';
		}
		
		private function replace_order(){
			return $this->replace_tag_with("order", $this->field);			
		}
		
		private function replace_dimension(){
			return $this->replace_tag_with("order_d", $this->toggle_dimension(), $this->url);
		}
		
		private function replace_tag_with($tag, $value, $from = ""){
			if(empty($from)) $from = $_SERVER['REQUEST_URI'];			 
			return preg_replace("/($tag=)\w+/", "$1$value", $from);
		}
		
		private function toggle_dimension(){
			if ($this->matcher["dimension"][1] == "asc") return "desc";
			else return "asc";
		}
		
		private function add_order(){
			return $_SERVER['REQUEST_URI'].(empty($_SERVER['QUERY_STRING']) ? "?" : "") . "&order=$this->field";
		}
		
		private function add_dimension(){
			return "&order_d=$this->default_dimension";
		}
		
		private function change_order(){
			$this->change_order_field();
			$this->change_dimension();
		}
		
		private function change_order_field(){
			if (empty($this->matcher['order'])) $this->url = $this->add_order();
			else $this->url = $this->replace_order();
		}
		
		private function change_dimension(){
			if (empty($this->matcher['dimension'])) $this->url .= $this->add_dimension();
			else $this->url = $this->replace_dimension();
		}
		
		private function is_default_field($field){
			return (($this->field == $this->default_order) && empty($field));
		}
		
		private function is_selected_field($field){
			return ($field == $this->field);
		}
		
		private function detect_order(){			
			$this->matcher['order'] = $this->detect_order_field();
			$this->matcher['dimension'] = $this->detect_dimension();
		}
		
		private function detect_order_field(){			
			return $this->detect_tag("order");
		}
		
		private function detect_dimension(){
			return $this->detect_tag("order_d");
		}
		
		private function detect_tag($field){
			$match = array();
			preg_match("/$field=(\w+)/", $_SERVER['QUERY_STRING'], $match);
			return $match;
		}
	}
?>
