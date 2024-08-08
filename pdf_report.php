<?php
require('fpdf/fpdf.php');
include 'db_config.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'User Report',0,1,'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Table
    function UserTable($header, $data)
    {
        // Header
        $this->SetFont('Arial','B',12);
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
        $this->SetFont('Arial','',10);
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }
}

// Fetch data
$sql = "SELECT id, username, email, role, user_type, created_at FROM users";
$result = $conn->query($sql);

$header = array('ID', 'Username', 'Email', 'Role', 'User Type', 'Created At');
$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->UserTable($header, $data);
$pdf->Output('D', 'user_report.pdf'); // 'D' to force download
?>
