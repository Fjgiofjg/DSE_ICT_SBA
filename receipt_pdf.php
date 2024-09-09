<?php
// Database connection parameters
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed"); // Handle connection error
}

// Check if the user is logged in via cookie
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!'); window.location.href='login.html';</script>";
    exit; // Stop further execution
}

// Retrieve user ID from cookie
$uid = $_COOKIE["uid"];

require_once('TCPDF-main\tcpdf.php');

if (isset($_GET['ref_no'])) {
    $ref_no = $_GET['ref_no'];

    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {
        private $ref_no;

        // Set reference number
        public function setRefNo($ref_no) {
            $this->ref_no = $ref_no;
        }

        // Page header
        public function Header() {
            $image_file = 'imgs/Stella_Logo_Small.jpg'; // Use forward slashes
            if (!file_exists($image_file)) {
                error_log("Image file not found: " . $image_file);
            }
            // Make the image larger (width 50, height automatically calculated)
            $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            
            // Set font for the title
            $this->SetFont('helvetica', 'B', 20);
            // Change title to include reference number, aligned to the right
            $this->Cell(0, 15, 'Order Receipt ' . $this->ref_no, 0, false, 'R', 0, '', 0, false, 'M', 'M');
            
            // Generate and place the barcode in the header
            $style = array(
                'position' => 'R',
                'align' => 'R',
                'border' => false,
                'vpadding' => 0,
                'hpadding' => 0,
                'fgcolor' => array(0, 0, 0), 
                'text' => false, 
                'textalign' => 'C', 
                'stretch' => false,
                'fitwidth'=> false, // disable fitwidth
                'stretch' => false, // disable stretch
            );

            // Move down slightly after title
            $this->Ln(5);
            // Align barcode to the right and make it smaller
            $this->write1DBarcode($this->ref_no, 'C39', '', '', '', 10, 0.5, $style, 'N'); 
            $this->Ln(5); // Add space after barcode
            
            // Draw a line under the header
            $this->Line(10, 40, 200, 40);
        }

        // Page footer
        public function Footer() {
            $this->SetY(-20); // Adjusted to leave space for the barcode
            $this->SetFont('helvetica', 'I', 8);
            // Write the barcode again if needed or any footer info
        }
    }

    // Create PDF instance using your custom class
    $pdf = new MYPDF();
    $pdf->setRefNo($ref_no); // Set the reference number
    $pdf->AddPage();
    $pdf->SetAuthor('Stellar');
    $pdf->SetTitle('Order Receipt ' . $ref_no);
    $pdf->SetSubject('Order Receipt ' . $ref_no);

    // Convert TTF font to TCPDF format and store it in the fonts folder
    $fontname = TCPDF_FONTS::addTTFfont('font/NunitoSans.ttf', 'TrueType', '', 96);
    $pdf->SetFont($fontname, '', 14, '', false);
    $pdf->Ln(20); // New line

    // Fetch order details from the database
    $sql = "SELECT Product_id, Quantity FROM orders WHERE RefNo = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $ref_no);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Add headers for product details
        $pdf->Cell(30, 10, 'Product ID');
        $pdf->Cell(130, 10, 'Product Name', 0, 0, 'C'); // New column for product name
        $pdf->Cell(30, 10, 'Quantity', 0, 0, 'R'); // Right-aligned Quantity
        $pdf->Ln();

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['Product_id'];
            $quantity = $row['Quantity'];

            // Fetch product details based on product ID
            $product_sql = "SELECT Product_name FROM products WHERE Product_id = ?";
            $product_stmt = $link->prepare($product_sql);
            $product_stmt->bind_param("i", $product_id);
            $product_stmt->execute();
            $product_result = $product_stmt->get_result();
            
            $product_name = 'Unknown Product'; // Default value
            if ($product_result->num_rows > 0) {
                $product_data = $product_result->fetch_assoc();
                $product_name = $product_data['Product_name'];
            }

            // Output the details with Quantity aligned right
            $pdf->Cell(30, 10, $product_id);
            $pdf->Cell(130, 10, $product_name, 0, 0, 'C');
            $pdf->Cell(30, 10, $quantity, 0, 0, 'R'); // Right-aligned Quantity
            $pdf->Ln();
        }

        // Output the PDF
        $pdf->Output('receipt.pdf', 'I');
        exit; // Make sure to exit after outputting the PDF
    } else {
        $pdf->Cell(40, 10, 'No items found for this order.');
        $pdf->Output('receipt.pdf', 'I');
        exit; // Make sure to exit after outputting the PDF
    }
} else {
    echo "<script>
        alert('Missing Order Reference Code [Err code: 22]\\nReturning to Home Page');
        window.location.href = 'home.php';
    </script>";
    exit; // Stop further execution
}
?>