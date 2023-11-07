<?php
require_once __DIR__ . '/libs/functions.php';
$err = "none";

if ( !empty($_POST["user_cd"]) ) {
	$user_cd = $_POST["user_cd"];

	$req_his= getAPIReqHis($user_cd);
	if ( empty($req_his) ){
		$err = "block";
		goto Err;
	}
	
	$res     = calculatorTax($req_his["req_his"][0]["req_his_d"]);
	if ( empty($res) ){
		$err = "block";
		goto Err;
	}
	$price = setPrice($res["sum_spectify"]);
}

//============================================================+
// File name   : example_007.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 007 for TCPDF class
//               Two independent columns with WriteHTMLCell()
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
 * @abstract TCPDF - Example: Two independent columns with WriteHTMLCell()
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
define("DEBUG", 0);
$fontname = TCPDF_FONTS::addTTFfont('meiryo_bold.ttf', 'TrueTypeUnicode', '', 32);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

function createRowsEmpty($number, $color = 1)
{
	$td     = '';
	$colors = [ "white", "#fafff0" ];
	for ( $i = 0; $i < $number; $i++ ) {
		$color = $colors[$i % 2];
		$td .=
			"<tr>
				<td class=\"last solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-right\"></td>
				<td class=\"table__row-1 solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-right\"></td>
			</tr>";
	}
	return $td;
}

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 007');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 007', PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetMargins(PDF_MARGIN_LEFT - 10, 2, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// $pdf->setCellHeightRatio(2);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if ( @file_exists(dirname(__FILE__) . '/lang/eng.php') ) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('times', '', 12);
// $pdf->SetFont('meiryo', '', 9, '', false);
// $pdf->SetFont('meiryo_b', 'b', 9);
// $pdf->SetFont('times', 'B', 16);

// add a page
$pdf->AddPage();
$user_nm = @$req_his["req_his"][0]["users"]["user_nm"] ? $req_his["req_his"][0]["users"]["user_nm"] . "　様" : "";
$kai_nm  = @$req_his["req_his"][0]["users"]["kai_nm"];
$kai_nm  = empty($user_nm) ? $kai_nm . "　御中" : $kai_nm;
$user_cd = @$req_his["req_his"][0]["user_cd"];
$user_cd = insertHyphen($user_cd);
// create columns content
$left_column = '<p><br/><br/><span>' . $kai_nm . '</span>';

if ( !empty($user_nm) )
	$left_column .= '<br/><span>' . $user_nm . '</span>';

$left_column .= '<br/>[お客様コード: ' . $user_cd . ' ] </p>';


$left_column2 = '
<table>
	<tr>
		<td style="border-bottom: 1px solid black;" align="left" class="solid-left solid-right"><b>合計金額</b></td>
	</tr>
</table>
';


$left_column3 = '<p>' . numberFormat(@$req_his["req_his"][0]["seikyu"]) . ' 円 (税込)</p>';

// $left_column = '<b>LEFT COLUMN</b> left column left column left column left column left column left column left column left column left ';
$right_column = '
<p>納品書 請求書
<br/>2023年6月20日
<br/>IMG
<br/>代表收箱校長秀樹
<br/>東京本社/〒100-0004
<br/>TELOS-8773-7 7530 WEB/T940-0071 -
<br/>4-24 RITA TEL0258-33-4435
<br/>西会 299
<br/>お客様コード: 1001-989749-10
<br/>お客様コード: 1001-989749-10
</p>';

$right_column1 = '
<p>納品書 請求書</p>
';

$right_column2 = '<br/>事業者登録: T1234567890123';
$right_column3 = '<p>2023年6月20日</p>';

$right_column2 = '<br/>事業者登録: T1234567890123';
$right_column4 = "<img src=\"images/sorimachi_kabu_logo.png\" alt=\"test alt attribute\" width=\"160\" border=\"0\"/><span>登録番号:T1234567890123</span>";

$table = '
<style>

table th {
	background-color: #D9D9D9;
	border-top: 1px solid black; 
	border-left: 1px solid black; 
	border-right: 1px solid black; 
	border-bottom: 1px solid black;
}

.solid-bottom {
	border-bottom: 1px solid black;
}

.solid-left {
	border-left: 1px solid black; 
}

.solid-right {
	border-right: 1px solid black; 
}

.dotted-right {
	border-right: 0.1px dotted #98FB98; 
}


</style>
<table border="0" width="100%" cellpadding="4">
    <tr>
		<th style="width:11%;" align="center"><span style="" >入金日</span></th>
		<th style="width:12%;" align="center"><span style="" >伝票番号</span></th>
		<th style="width:46%;" align="center"><span style="" >商品</span></th>
		<th style="width:5%;" align="center"><span style="" >数量</span></th>
		<th style="width:13%;" align="center"><span style="" >単価</span></th>
		<th style="width:13%;" align="center"><span style="" >お買上額</span></th>
    </tr>
	';
$table .= !empty($_POST["user_cd"]) ? createRow($req_his["req_his"][0]["req_his_d"]) : "";
$table .= createRowsEmpty(7, 1);

$table .= '
    <tr>
        <td class="solid-bottom solid-left solid-right" ></td>
        <td class="solid-bottom solid-right"></td>
        <td class="solid-bottom solid-left solid-right"></td>
        <td class="solid-bottom solid-left solid-right"></td>
        <td class="solid-bottom solid-left solid-right"></td>
        <td class="solid-bottom solid-right"></td>
    </tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class="solid-bottom"><span style="font-family:' . $fontname . ';font-weight:bold">本体価格小計</span></td>
		<td align="right" class="solid-bottom">' . numberFormat(@$res["sum_hon_kin"]) . ' 円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class="solid-bottom"><span style="font-family:' . $fontname . ';font-weight:bold">消費税</span></td>
		<td align="right" class="solid-bottom">' . numberFormat(@$res["sum_zei_kin"]) . ' 円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class="solid-bottom"><span style="font-family:' . $fontname . ';font-weight:bold">合計</span></td>
		<td align="right" class="solid-bottom">' . numberFormat(@$req_his["req_his"][0]["seikyu"]) . ' 円</td>
	</tr>

	<tr>
		<td style="" colspan="4"></td>
		<td class="solid-bottom"></td>
		<td class="solid-bottom"></td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class=""><span style="font-family:' . $fontname . ';font-weight:bold">本体価格</span></td>
		<td align="right" class="">' . numberFormat(@$res["sum_hon_kin"]) . ' 円</td>
	</tr>';


$table .= !empty($_POST["user_cd"]) ? setPrice($res["sum_spectify"]) : "";

$table .= '
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" class="solid-bottom"></td>
		<td class="solid-bottom"></td>
	</tr>

	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class=""><span style="font-family:' . $fontname . ';font-weight:bold">消費税額</span></td>
		<td align="right" class="">' . numberFormat(@$res["sum_zei_kin"]) . ' 円</td>
	</tr>';

$table .= !empty($_POST["user_cd"]) ? setTax($res["sum_spectify"]) : "";

$table .= '
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" class="solid-bottom"></td>
		<td class="solid-bottom"></td>
	</tr>
</table>';

// get current vertical position
$y = $pdf->getY();

// set color for text
// $pdf->SetTextColor(0, 63, 127);
$pdf->SetLineStyle(array( 'width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array( 0, 0, 0 ) ));
// $pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);


$pdf->SetFont('meiryo_b', 'b', 15);

$pdf->Cell(0, 10, '請求明細', 1, $ln = 1, 'C', true, '', 0, false, 'C', 'C');

$pdf->SetFont('meiryo', '', 9, '', false);
$pdf->SetFillColor(215, 235, 255);
$pdf->SetTextColor(0, 0, 0);

$pdf->writeHTMLCell(90, '', '', '', $left_column, DEBUG, 0, 0, true, 'J', true);
// write the first column

$pdf->Ln(3);
$pdf->SetFont('meiryo', '', 8, '', false);
$pdf->writeHTMLCell('', '', '', '', $right_column3, DEBUG, 1, 0, true, 'R', true);
$pdf->Ln(2);

$pdf->SetFont('meiryo_b', '', 8, '', false);
$pdf->writeHTMLCell('', '', '140', '', $right_column4, DEBUG, 1, 0, true, 'L', true);

$pdf->Ln(10);
$pdf->SetFont('meiryo_b', '', 11, '', false);
$pdf->writeHTMLCell(90, '', '', '', $left_column2, DEBUG, 0, 0, true, 'J', true);

$pdf->SetFont('meiryo', '', 11, '', false);
$pdf->writeHTMLCell(45, '', '60', '', $left_column3, DEBUG, 0, 0, true, 'R', true);


$pdf->SetFont('meiryo', '', 7, '', false);
// reset pointer to the last page
// $pdf->lastPage();
$pdf->Ln(12);
$y = $pdf->getY();

$pdf->writeHTMLCell('', '', '', '', $table, 0, 0, 0, true, 'J', true);
// $pdf->Ln(4);

//Close and output PDF document
if ( !empty($_POST["user_cd"]) )
	$pdf->Output('example_007.pdf', 'I');
// $pdf->Output('example_007.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
Err:
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Download PDF</title>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		font-family: "Inter", sans-serif;
	}

	.formbold-main-wrapper {
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 48px;
	}

	.formbold-form-wrapper {
		margin: 0 auto;
		max-width: 550px;
		width: 100%;
		background: white;
	}

	.formbold-form-title {
		margin-bottom: 40px;
	}

	.formbold-form-title h3 {
		color: #07074D;
		font-weight: 700;
		font-size: 28px;
		line-height: 35px;
		width: 100%;
		text-align: center;
		margin-bottom: 20px;
	}

	.formbold-form-title p {
		font-size: 16px;
		line-height: 24px;
		color: #536387;
		width: 70%;
	}

	.formbold-form-input {
		text-align: center;
		width: 100%;
		padding: 14px 22px;
		border-radius: 6px;
		border: 1px solid #DDE3EC;
		background: #FAFAFA;
		font-weight: 500;
		font-size: 16px;
		color: #536387;
		outline: none;
		resize: none;
	}

	.formbold-form-input:focus {
		border-color: #6a64f1;
		box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
	}

	.formbold-btn {
		text-align: center;
		width: 100%;
		font-size: 16px;
		border-radius: 5px;
		padding: 14px 25px;
		border: none;
		font-weight: 500;
		background-color: #6A64F1;
		color: white;
		cursor: pointer;
		margin-top: 15px;
	}

	.formbold-btn:hover {
		box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
	}
</style>

<body>
	<form action="" method="post">
		<div class="formbold-main-wrapper">
			<!-- Author: FormBold Team -->
			<!-- Learn More: https://formbold.com -->
			<div class="formbold-form-wrapper">
				<div class="formbold-form-title">
					<h3>TOOLS DOWNLOAD PDF</h3>
				</div>
				<form action="https://formbold.com/s/FORM_ID" method="POST">
					<input type="text" name="user_cd" id="user_cd" placeholder="user_cd" class="formbold-form-input" />
					<input type="submit" class="formbold-btn" value="確認してダウンロード"></input>
					<p style="text-align: center; display: <?=$err;?>">Not found</p>
				</form>
			</div>
		</div>
	</form>
</body>
</html>