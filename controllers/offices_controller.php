<? 
	class OfficesController {
	
		public function OfficesController($params){
			foreach($params as $key => $value) eval("$"."this->$key = $value;");
		}
		
		public function execute(){
			if(!empty($this->id)){
				$this->show();
			}
		}
		
		public function show(){			
			switch ($this->format){
				case "pdf":			
					render_partial("offices", "show.pdf.html", array("id" => $this->id));
				break;
				default:
					"";
			}
		}
	}
?>