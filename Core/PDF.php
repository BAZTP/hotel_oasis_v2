<?php

namespace Core;

use Fpdf\Fpdf;

class PDF extends FPDF {
  // Encabezado
  function getInstance(): PDF
  {
    return new PDF();
  }
  function Header() {
    $this->Image(__DIR__ . '/../public/images/logo.png', $this->GetPageWidth() - 45, 10, 35);
    $this->Ln(20);

    $this->SetFont('Arial', 'B', 14);
    $this->Cell(0, 10, $this->convertText('ROL DE PAGOS'), 0, 1, 'C');
    $this->SetFont('Arial', '', 12);
    $this->Cell(0, 10, $this->convertText('EMPRESA "HOTEL OASIS"'), 0, 1, 'C');
    $this->Ln(10);
  }

  function Footer() {
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, $this->convertText('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }

  function convertText($text) {
    return iconv('UTF-8', 'ISO-8859-1', $text);
  }
}