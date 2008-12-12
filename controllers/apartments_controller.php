<? 
	class ApartmentsController {
	
		public function ApartmentsController($params){
			foreach($params as $key => $value) eval("\$this->$key = \$value;");
		}
		
		public function execute(){
			if(!empty($this->id)){
				$this->show();
			}
		}
		
		public function show(){
			#$apartment = Appartment::find($this->id);
			switch ($this->format){
				case "pdf":			
					render_partial("apartments", "show.pdf.html", array("id" => $this->id));
				break;
				case "ru-pdf":
					render_partial("apartments", "show.ru.pdf.html", array("id" => $this->id));
				break;
				default:
					render_partial("apartments", "show.html", array("apartment" => $this->id));
			}
		}
	}
?>