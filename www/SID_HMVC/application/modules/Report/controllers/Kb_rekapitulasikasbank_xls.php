<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Kb_rekapitulasikasbank_xls extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('excel');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
		$this->report_model->excel_output = 1;
	}

	public function index() {		
		$objPHPExcel = $this->excel;// new excel();
		$recordobject = $this->report_model->get_infobukuharian();
		$caption='Rekapitulasi Kas-Bank'; //save our workbook as this file name

		 //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Report Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',FONT_SIZE,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");
        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:D2');

		//Loop Report Data Header
		if ($this->input->post('linkid') == 'undefined') {
			$recordHeader = $this->report_model->get_AccountHeader();
			$haslinkid = 0;
		} else {
			$account = $this->report_model->get_Accountby_id($this->input->post('linkid'));
			$parentkey = ($account->classacc == 0) ? $account->keyvalue :  $account->parentkey;
			$recordHeader = $this->report_model->get_Accountby_keyvalue($parentkey);
			$haslinkid = ($account->classacc == 0) ? 0 :  1;
		}
		
		$totHeader = count($recordHeader);
		$counter = 0;
		$row = 4;
		$rowheader = 5;
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        foreach($recordHeader as $valueH) {
        	$counter++;
			$saldoperGroupheader = 0;
			$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':D'.$row);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $valueH->description);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			

			$dataHeader = $this->report_model->get_RekapKasbankHeader($valueH->keyvalue, $haslinkid);
			$newGroup = '';
			$subtotalpertype = 0;
			$subtotalgroup = array('penambahan'=>0, 'pengurangan'=>0);
			$banktype = -1;
			$saldoawal = 0;
			$h = 5;
			$fill = 0;
			$row++;
			foreach ($dataHeader as $groupH) {
				//$pdf->SetFont('', '',8);
				$banktype = $subtotalpertype == 0 ? $groupH->kasbanktype : -1;
				$banktypedesc = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'PENERIMAAN' : 'PENGELUARAN';
				$banktypedesclower = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'Penerimaan' : 'Pengeluaran';
				$subtotal = 0;

				$dataDetil = $this->report_model->get_RekapKasbankDetil($groupH->rekid, $groupH->kasbanktype);
				$hasrecord = 0;
				foreach ($dataDetil as $value) {
					if ($hasrecord == 0) { //Header Group
						if ($banktype == $groupH->kasbanktype) {
							//$rowheader++;
							$saldoawal = $this->report_model->get_SaldoawalKB($groupH->rekid);
							$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':D'.$row);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '('.$groupH->accountno.') '.$groupH->description);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

							$row++;
							$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
							$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Saldo Awal');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $saldoawal);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
							
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getAlignment()
														->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->applyFromArray($objPHPExcel->setBorder('bottom','grey-light'));
							$row++;
						}
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $banktypedesc);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
						$row++;
					}
					$subtotal += $value->amount;
					$objPHPExcel->getActiveSheet()->fromArray(Array($value->accountno, $value->description, $value->amount), null, 'B'.$row);
					$row++;					
		    		$hasrecord = 1;
				}

				$subtotalpertype += $subtotal;
				if ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) {
					$subtotalgroup['penambahan'] +=  $subtotal;
				} else {
					$subtotalgroup['pengurangan'] += $subtotal;
				}

				if ($hasrecord == 1) {
					$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Total '.$banktypedesclower);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $subtotal);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->applyFromArray($objPHPExcel->setBorder('top','grey-light'));
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->applyFromArray($objPHPExcel->setBorder('bottom','grey-light'));

					$row++;
				}
				if ($subtotalpertype != 0 && $banktype != $groupH->kasbanktype) {
					$saldoperGroupheader += $saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan'];
					$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
					$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Saldo Akhir '.$groupH->description);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, ($saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan']));
					$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->applyFromArray($objPHPExcel->setBorder('top','grey-light'));
					
					//Border Detil
					$objPHPExcel->getActiveSheet()->getStyle('B'.$rowheader.':D'.$row)->applyFromArray($objPHPExcel->setBorder('outline'));
					$row=$row+2;
					$rowheader=$row;

					$subtotalpertype = 0;
				}
				$banktype = $groupH->kasbanktype;
			} //End of DataHeader
			//GRAND TOTAL
			$row--;
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':D'.$row);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $saldoperGroupheader);
			$objPHPExcel->setFontStyle('B'.$row,12,true,$saldoperGroupheader > 0 ? 'blue' : 'red');
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			// Add a page break
			$objPHPExcel->getActiveSheet()->setBreak( 'A' . $row, PHPExcel_Worksheet::BREAK_ROW );

			$row=$row+2;
			$rowheader=$row+1;
        } //End of $recordHeader

        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();

    	//get row count
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();

		//set number format
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		for ($i='D'; $i <= $highestColumm; $i++) { 
    		$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setWidth(20); //((int) $calculatedWidth * 1.05);
    	}

        //Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		

		//Seting Print Area
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('B1:'.$highestColumm.$highestRow);
        
        //seting Compress
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);

		$filename=$caption.'.xls'; //save our workbook as this file name
 
        //header('Content-Type: application/vnd.ms-excel'); //mime type
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save("php://output");
  	}
}
?>