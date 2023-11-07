<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require_once __DIR__ . '/libs/functions.php';
include __DIR__ . '/libs/datafake.php';

define("__ERR1__", "don't connect API");
define("__ERR2__", "haven't data in API");
$err	  = "";
$arr      = [];
$count    = 0;
$namefile = "SORIMACHI_invoice_%s.pdf";
try {
	if ( !empty($_POST["req_his_cd"]) ) {
		set_time_limit(0);
		$namefile = sprintf($namefile, @$_POST["req_his_cd"]);

		$req_his_cd = $_POST["req_his_cd"];
		$req_his    = getAPIReqHis($req_his_cd);

		// $req_his = $GLOBALS["req_his"];

		if ( empty($req_his) ) {
			$err = __ERR2__;
			goto Err;
		}

		$res = calculatorTax($req_his["req_his"][0]["req_his_d"]);
		if ( empty($res) ) {
			$err = __ERR2__;
			goto Err;
		}
		$price = setPrice($res["sum_spectify"]);

		GetYMD($req_his["req_his"][0]["req_his_d"], "hs_ymd", '', $count, $arr);
		MaxYMD($arr);
		$maxYMD = $arr[count($arr) - 1];

	}
} catch ( PDOException $e ) {
	// return $e->getMessage();
	$result = __ERR1__;
	goto Err;
} catch ( Exception $e ) {
	// return $e->getMessage();
	$result = __ERR1__;
	goto Err;
} catch ( \Throwable $th ) {
	// throw new Exception('');
	$result = __ERR1__;
	goto Err;
}


//============================================================+
// File name   : SORIMACHI_invoice_$req_his_cd.pdf.php
//
// Description : get data from API req_his to create invoice PDF
//
// Author: KhanhDinh
//
//============================================================+

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
// $pdf->SetTitle('TCPDF Example 007');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 007', PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
// add a page
$pdf->AddPage();

$user_nm    = @$req_his["req_his"][0]["users"]["user_nm"] ? $req_his["req_his"][0]["users"]["user_nm"] . "　様" : "";
$kai_nm     = @$req_his["req_his"][0]["users"]["kai_nm"];
$kai_nm     = empty($user_nm) ? $kai_nm . "　御中" : $kai_nm;
$req_his_cd = @$req_his["req_his"][0]["user_cd"];
$req_his_cd = insertHyphen($req_his_cd);

// create columns content
// left invoice
$left_column = '<p><br/><br/><span>' . $kai_nm . '</span>';

if ( !empty($user_nm) )
	$left_column .= '<br/><span>' . $user_nm . '</span>';

$left_column .= '<br/>[お客様コード: ' . $req_his_cd . ' ] </p>';

$left_column2 = '<table>
					<tr>
						<td style="border-bottom: 1px solid black;" align="left" class="solid-left solid-right"><b>合計金額</b></td>
					</tr>
				</table>';

$left_column3 = '<p>' . numberFormat(@$req_his["req_his"][0]["seikyu"]) . ' 円 (税込)</p>';


//right invoice
$right_column1 = '<p>納品書 請求書</p>';

$right_column3 = '<p>%s</p>';
$right_column3 = sprintf($right_column3, formatDate($maxYMD, "Y年m月d日", false));

$right_column4 = "<img src=\"images/sorimachi_kabu_logo.png\" alt=\"test alt attribute\" width=\"160\" border=\"0\"/><span>登録番号:T2110001022732</span>";

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
		<th style="width:11%;" align="center"><span style="" >請求日</span></th>
		<th style="width:12%;" align="center"><span style="" >伝票番号</span></th>
		<th style="width:46%;" align="center"><span style="" >商品</span></th>
		<th style="width:5%;" align="center"><span style="" >数量</span></th>
		<th style="width:13%;" align="center"><span style="" >単価</span></th>
		<th style="width:13%;" align="center"><span style="" >お買上額</span></th>
    </tr>
	';
$table .= !empty($_POST["req_his_cd"]) ? createRow($req_his["req_his"][0]["req_his_d"]) : "";
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


$table .= !empty($_POST["req_his_cd"]) ? setPrice($res["sum_spectify"]) : "";

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

$table .= !empty($_POST["req_his_cd"]) ? setTax($res["sum_spectify"]) : "";

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
$pdf->SetLineStyle(array( 'width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array( 0, 0, 0 ) ));
$pdf->SetTextColor(255, 255, 255);

$pdf->SetFont('meiryo_b', 'b', 15);

$pdf->Cell(0, 10, '請求明細', 1, $ln = 1, 'C', true, '', 0, false, 'C', 'C');

$pdf->SetFont('meiryo', '', 9, '', false);
$pdf->SetFillColor(215, 235, 255);
$pdf->SetTextColor(0, 0, 0);

$pdf->writeHTMLCell(90, '', '', '', $left_column, DEBUG, 0, 0, true, 'J', true);

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

$pdf->Ln(12);

$pdf->writeHTMLCell('', '', '', '', $table, 0, 0, 0, true, 'J', true);
// $pdf->Ln(4);

//Close and output PDF document
if ( !empty($_POST["req_his_cd"]) ) {
	// $pdf->Output($namefile, 'I');
	$pdf->Output($namefile, 'D');
}
//============================================================+
// END OF FILE
//============================================================+
Err:
echo $err;
?>