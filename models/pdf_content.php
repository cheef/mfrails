<?php
	require_once(CODE_DIR."tcpdf/tcpdf.php");
		
	class PdfContent {
		public $pdf = NULL;
		
		public function PdfContent(){
			$this->pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true);
		}
				
		public function with_params($options){
			$this->pdf->SetHeaderData('', 0, $options['head'], $options['subhead']);		
			$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));		
			$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));		
			$this->pdf->SetMargins(7, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);		
			$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);		
			$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);	
			$this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);		
			$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$this->pdf->AliasNbPages();		
			$this->pdf->AddPage();		
			$this->pdf->SetFont((empty($options['font-name']) ? "helvetica" : $options['font-name']), "", (empty($options['font-size']) ? 13 : $options['font-size']));
		}
		
		public function render_with($content, $filename = "test.pdf"){			
			$this->pdf->writeHTML($content, true, 0, true, 0);
			$this->pdf->lastPage();
			$this->pdf->Output($filename, "I");
		}
	}
?>