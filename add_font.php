<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_example.jpg';
		// $this->SetFont('cid0jp', '', 10);

        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        // $this->SetFont('helvetica', 'B', 20);

		//No
        // $this->Cell(0, 15, 'No: 139', 1, false, 'R', 0, '', 0, false, 'M', 'M');
		
        // Title
        // $this->Cell(0, 15, '<< TCPDF Example 003 >> \n', 1, false, 'C', 0, '', 0, false, 'M', 'M');
		// $this->MultiCell(0, 0, '<< TCPDF Example 005 >>', 0, 'J', false, 1, '', '', true, 0, false, true, 0, 'T', false);
		// $this->writeHTMLCell(50, 0, 0, 0, '123123', 1, 2, 1, true, 'L', true);
		// $this->writeHTML(50, 0, 0, 0, '123123', 1, 2, 1, true, 'L', true);
		// $this->writeHTML("yyyyy", false, false, true, false, '');
		// $this->writeHTML("xxxx", false, false, true, false, '');
		$this->writeHTML('<strong style= "text-decoration: underline;">No: 139&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>', true, true, true, true, 'R');
		$this->writeHTML('<strong style="font-size:25px">領 収 証</strong>', 1, 1, 1, 1, 'C');
		$this->writeHTML("2023年 9月 26日", 1, 1, 1, 1, 'C');

		// $this->writeHTMLCell(0, 0, 0, 14, 'xxxx', 1, false, 0, 1, 'C', true);
		// $this->writeHTMLCell(0, 0, 0, 14, 'yyyy', 1, false, 0, 1, 'C', true);
		// $this->writeHTMLCell(0, 0, 0, 14, '123123', 1, false, 0, 1, 'C', true);
		// $this->writeHTML("zzzz", false, false, true, false, '');


        // $this->Cell(0, 15, '<< TCPDF Example 005 >>', 1, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Page footer
    // public function Footer() {
    //     // Position at 15 mm from bottom
    //     $this->SetY(-15);
    //     // Set font
    //     $this->SetFont('helvetica', 'I', 8);
    //     // Page number
    //     $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // }
}



// create new PDF document
// $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);


// convert TTF font to TCPDF format and store it on the fonts folder
// $fontname = TCPDF_FONTS::addTTFfont('meiryo.ttf', 'TrueTypeUnicode', '', 96);
$fontname = TCPDF_FONTS::addTTFfont('meiryo_bold.ttf', 'TrueTypeUnicode', '', 96);
// use the font
$pdf->SetFont($fontname, '', 14, '', false);


// set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 003');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// remove default header/footer
// $pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(20, 30, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('times', 'BI', 12);
// $pdf->SetFont('cid0jp', '', 10);
// $pdf->SetFont('meiryo', '', 10, '', false);


// add a page
$pdf->AddPage();

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');
// $pdf->Output('example_003.pdf', 'D');