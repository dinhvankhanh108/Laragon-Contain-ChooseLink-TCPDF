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
		$this->SetFont('cid0jp', '', 10);

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
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// $pdf = new MYPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);


// convert TTF font to TCPDF format and store it on the fonts folder
// $fontname = TCPDF_FONTS::addTTFfont('meiryo.ttf', 'TrueTypeUnicode', '', 96);
// $fontname = TCPDF_FONTS::addTTFfont('meiryo_bold.ttf', 'TrueTypeUnicode', '', 96);
// use the font
// $pdf->SetFont($fontname, '', 14, '', false);


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
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetMargins(20, 30, 20);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
$pdf->SetFont('meiryo', '', 9, '', false);


// add a page
$pdf->AddPage();

// set some text to print
$txt = '
<style>
p {
	line-height: 5px;
}
</style>
<p>336-0004</p>
<p>埼玉県さいたま市大崎</p>
<p>１ー２ー３</p>
<p>株式会社オリエント技研商事様</p>
';

$pdf->writeHTML($txt, true, true, true, true, 'L');

//content
$left_column = '<hr><b>金額</b>';

$left_column2 = '<h1>¥645, 150ー</h1>';
$left_column1 = '<hr>';
$left_column3 = '
<style>
p {
	line-height: 5px;
}
</style>					
<p>但し、</p>
<p>上記の通り正に領収致しました。</p>
';


$right_column = '<b>RIGHT COLUMN</b> right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column right column';

$right_column = '
<style>
table, th, td {
	border: 1px solid black;
}

.content__table--spacing {
	width:40px;
	text-align: center; 
}

.content__table--auto {
	width:auto;
}

</style>
<table class="content__table" style="width:100%">
							<tr>
								<th colspan="2">
									<p style="float: left;padding-left: 20px;">他の場所に</p>
									<p style="clear: both;padding-left: 100px;">&nbsp;</p>
								</th>
							</tr>
							<tr>
								<td class="content__table--spacing">現金</td>
								<td class="content__table--auto">　</td>
							</tr>
							<tr>
								<td style="border-bottom-style: hidden;" class="content__table--spacing">現金</td>
								<td class="content__table--auto">　</td>
							</tr>
							<tr>
								<td style="border-top-style: hidden;" class="content__table--spacing">&nbsp;11</td>
								<td class="content__table--auto">&nbsp;</td>
							</tr>
						</table>';

$right_column1 = "58,650";

// get current vertical position
$y = $pdf->getY();

// set color for background
// $pdf->SetFillColor(255, 255, 200);

// set color for text
// $pdf->SetTextColor(0, 63, 127);

// write the first column
$pdf->writeHTMLCell(130, '', '', $y + 10, $left_column, 0, 0, 0, true, 'J', true);

// set color for background
// $pdf->SetFillColor(215, 235, 255);

// set color for text
// $pdf->SetTextColor(127, 31, 0);

// write the second column
$pdf->writeHTMLCell('', '', '', '', $right_column, 0, 1, 0, true, 'J', true);
$pdf->writeHTMLCell('20', '', 170, 62, $right_column1, 0, 0, 0, true, 'C', true);

// print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$pdf->writeHTMLCell(130, '', '', 75, $left_column1, 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(130, '', -20, 65, $left_column2, 0, 0, 0, true, 'R', true);
$pdf->writeHTMLCell(130, '', 20, 80, $left_column3, 0, 0, 0, true, 'L', true);


$footer1 = "";
// $pdf->writeHTMLCell(25, 25, 10, 100, $footer1, 1, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(25, 25, 10, 100, $footer1, 1, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(20, '', 15, 110, "<p>取入印紙</p>", 0, 0, 0, true, 'J', true);
// ---------------------------------------------------------

// $footer21_img = '<img src="./images/sorimachi_kabu_logo.png" width="60%"/>';
$footer21_img = "<img src=\"images/sorimachi_kabu_logo.png\" alt=\"test alt attribute\" width=\"150\" height=\"20\" border=\"0\"/>";

$footer21 = "
<style>
p {
	line-height: 1px;
}
</style>
<p style=\"font-family: meiryo_b;\">東京本社</p>
<p>〒100-0004　東京都千代田区大手町1丁目9-7</p>
<p>大手町フィナンシャルシティサウスタワー 東京金融ビレッジ5階</p>
<p>TEL.03-6773-7530　FAX.03-6685-4470</p>";

$footer22 = '
<style>
p {
	line-height: 1px;
}
</style>
<p class="spacing">サンプルビル2F </p>
<p class="spacing">TEL:03-9876-5432 FAX: 03-9876-1234 </p>
<p class="spacing">担当者: 長谷川 国男</p>
';
// $pdf->SetFont('meiryo_bold', '', 10, '', false);

$pdf->writeHTMLCell('', '', 60, 100, $footer21_img, 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell('', '', 60, 110, $footer21, 0, 0, 0, true, 'L', true);
// $pdf->writeHTMLCell('', '', 70, 125, $footer22, 0, 0, 0, true, 'L', true);


$footer3 = "footer3";
$pdf->writeHTMLCell(20, 20, 160, 100, $footer3, 1, 0, 0, true, 'R', true);

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');
// $pdf->Output('example_003.pdf', 'D');