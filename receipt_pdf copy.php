<?php
require_once('TCPDF-main/tcpdf.php'); // Ensure TCPDF is loaded

$pdf = new TCPDF();
$pdf->AddPage();

// Set the font
$pdf->SetFont('helvetica', '', 12);

// Reference number
$ref_no = '1717492491'; // Example reference number
$pdf->Cell(0, 10, 'Reference Number: ' . $ref_no, 0, 1);

// Set barcode parameters
$x = ''; // Auto position
$y = $pdf->GetY(); // Current Y position
$w = 0; // Auto width
$h = 18; // Height of the barcode

// Set barcode parameters
$x = ''; // Auto position
$y = $pdf->GetY(); // Current Y position
$w = 0; // Auto width
$h = 18; // Height of the barcode

// Initialize the style array with correct structure
$style = array(
    'position' => 'S',
    'align' => 'C',
    'border' => false,
    'vpadding' => 0,
    'hpadding' => 0,
    'fgcolor' => array(0, 0, 0), 
    'bgcolor' => array(255, 255, 255), 
    'text' => true, 
    'textalign' => 'C', 
    'stretch' => false,
);

try {
    // Write the barcode
    $pdf->write1DBarcode($ref_no, 'C39+', '', '', '', 18, 0.4, $style, 'N');
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Output the PDF
$pdf->Output('receipt.pdf', 'I');
?>