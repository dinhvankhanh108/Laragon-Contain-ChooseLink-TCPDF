<?php

//include library

require_once( 'tcpdf.php' ) ;
//make tcpdf object

$pdf = new TCPDF( 'P' , 'mm', 'A5',true, 'UTF-8',false) ;
//remove default header and footer
$pdf->setPrintHeader(false) ;
$pdf->setPrintFooter(false) ;

//add page

$pdf->AddPage();

//add content here
$pdf->SetFont('Helvetica', ' ',24);
$pdf->Cell(190, 10, "Unicode Test", 0, 1, 'C');

$pdf->SetFont('cid0jp', '', 16);
$pdf->Cell(190, 10, "日本語のテキスト", 0, 1, 'C');

//output

$pdf->Output();

