<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Kb_bukuharian_xls extends MY_Controller {

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
		$header = array('No. Bukti', 'Tanggal','Uraian', 'Penerimaan', 'Pengeluaran');
		$caption='Laporan Buku Harian'; //save our workbook as this file name

		 //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Report Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',FONT_SIZE,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        //Print Group Title
        $col = 'B';
		$row = 4;
		$startrow = 4;
        $objPHPExcel->getActiveSheet()->mergeCells($col.$row.':F'.$row);
        $objPHPExcel->getActiveSheet()->setCellValue($col.$row, $this->input->post('item'));
        $row++;

        //Set Table Title Load from Array
		$objPHPExcel->getActiveSheet()->fromArray($header, null, $col.$row);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		
		//get column count
        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
		//Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);

        //Change Table Header Color
        $objPHPExcel->setFillColor($col.$row.':'.$highestColumm.($row),HEADER_COLOR);
        $objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.($row),FONT_SIZE,true,HEADER_TEXT_COLOR);

        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:'.$highestColumm.'1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');
		
		$row++;
    	$bukuharian = $this->report_model->get_lapbukuharianHeader($this->input->post('linkid'));
        $totalPenerimaan = 0;
    	$totalPengeluaran = 0;
        $total = array('totalharga'=>0, 'akumpenyusutan'=>0,'nilaibuku'=>0);
        foreach($bukuharian as $valueH) { 
        	$totalPenerimaan += $valueH->penerimaan;
    		$totalPengeluaran += $valueH->pengeluaran;
    		$recordHeader=array($valueH->nokasbank, date_format(date_create($valueH->tglentry), "d-M-Y"), $valueH->uraian, $valueH->penerimaan, $valueH->pengeluaran);
    		$objPHPExcel->getActiveSheet()->fromArray($recordHeader, null, $col.$row);
    		$objPHPExcel->getActiveSheet()->getStyle($col.$row.':'.$highestColumm.$row)->getFont()->setBold(true);
    		$row++;

            $bukuharianDetil = $this->report_model->get_lapbukuharianDetil($valueH->noid);
            $recorditem=array();
            $i=0;
		    foreach ($bukuharianDetil as $value) {
		    	$debet = ($valueH->kasbanktype == 0 || $valueH->kasbanktype == 2) ? $value->amount : 0;
		    	$kredit = ($valueH->kasbanktype == 1 || $valueH->kasbanktype == 3) ? $value->amount : 0;
				//$objPHPExcel->getActiveSheet()->mergeCells($col.($row+$i).':C'.($row+$i));
		    	$recorditem[]=array($value->accountno, $value->remark, $debet, $kredit);
		    	$i++;
		    }
		    $i--;
		    $objPHPExcel->getActiveSheet()->fromArray($recorditem, null, 'C'.$row);
		    $objPHPExcel->getActiveSheet()->getStyle('C'.$row.':C'.($row+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		    $objPHPExcel->getActiveSheet()->getStyle('B'.($row+$i).':'.$highestColumm.($row+$i))->applyFromArray($objPHPExcel->setBorder('bottom','grey-light'));
		    $row=$row+$i+1;

        }
        //$objPHPExcel->getActiveSheet()->getStyle('E'.($row).':'.$highestColumm.($row))->applyFromArray($objPHPExcel->setBorder('bottom'));
       
        //Total Mutasi
    	$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, 'JUMLAH MUTASI');
    	$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $totalPenerimaan);
    	$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $totalPengeluaran);
    	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
    	$objPHPExcel->setFontStyle('D'.$row.':'.$highestColumm.$row,FONT_SIZE,true,'blue');
    	$objPHPExcel->getActiveSheet()->getStyle('E'.($row).':'.$highestColumm.($row))->applyFromArray($objPHPExcel->setBorder('bottom','blue'));
    	$row++;

    	//Saldo Awal & saldo Akhir
        $saldoawal = $this->report_model->get_SaldoawalKB($this->input->post('linkid'));
    	$saldoakhir = $saldoawal + $totalPenerimaan - $totalPengeluaran;
    	$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, 'SALDO AWAL & SALDO AKHIR');
    	$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $saldoawal);
    	$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $saldoakhir);
    	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
    	$objPHPExcel->setFontStyle('D'.$row.':'.$highestColumm.$row,FONT_SIZE,true,TEXT_COLOR);

    	//get row count
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();

		//Penanda Tangan
		$parameter = $this->report_model->get_parameter();
		$row++;
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':'.$highestColumm.$row);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $parameter->city.', '.date_format(date_create(), "d-M-Y"));
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$row++;
		$startassign=$row;
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
		$objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':F'.$row);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Disetujui oleh,');
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, 'Diperiksa oleh,');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, 'Dibuat oleh,');
		$row=$row+4;
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
		$objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':F'.$row);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $parameter->pimpinan);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $parameter->accounting);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $parameter->kasir);
		$row++;
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
		$objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':F'.$row);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $parameter->pimpinantitle);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $parameter->accountingtitle);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $parameter->kasirtitle);

		$objPHPExcel->getActiveSheet()->getStyle('B'.$startassign.':'.$highestColumm.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//set number format
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        //Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$highestColumm.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Set Wrap Text
        $objPHPExcel->getActiveSheet()->getStyle('D4:'.$highestColumm.$highestRow)->getAlignment()->setWrapText(true);

		//Title Border
		$objPHPExcel->getActiveSheet()->getStyle('B'.($startrow+1).':'.$highestColumm.$startrow)->applyFromArray($objPHPExcel->setBorder('allborders'));
		
		//Border Detil
		$objPHPExcel->getActiveSheet()->getStyle('B'.($startrow+2).':'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));

		//Seting Print Area
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('B1:'.$highestColumm.$row);
        
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