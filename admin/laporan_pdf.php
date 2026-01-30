<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }

require_once '../lib/fpdf/fpdf.php';
include '../includes/db.php';

$type = $_GET['type'] ?? 'pendaftar';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'LAPORAN FABULOUS DANCES CREW', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Tanggal: ' . date('d-m-Y H:i'), 0, 1, 'C');
        $this->Ln(10);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

if ($type == 'pendaftar') {
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'DATA PENDAFTAR', 0, 1, 'C');
    $pdf->Ln(5);
    
    // Header tabel
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetFillColor(26, 44, 78);
    $pdf->SetTextColor(255);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(45, 8, 'Nama', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'NIM', 1, 0, 'C', true);
    $pdf->Cell(35, 8, 'Jurusan', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Divisi', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Status', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Tanggal', 1, 1, 'C', true);
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0);
    
    $data = $pdo->query("SELECT p.*, d.nama_divisi FROM tabel_pendaftar p LEFT JOIN tabel_divisi d ON p.divisi_id = d.id ORDER BY p.id DESC")->fetchAll();
    $no = 1;
    foreach ($data as $row) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(45, 7, $row['nama_lengkap'], 1);
        $pdf->Cell(25, 7, $row['nim'], 1, 0, 'C');
        $pdf->Cell(35, 7, $row['jurusan'], 1);
        $pdf->Cell(30, 7, $row['nama_divisi'], 1);
        $pdf->Cell(25, 7, ucfirst($row['status']), 1, 0, 'C');
        $pdf->Cell(25, 7, date('d/m/Y', strtotime($row['tanggal_daftar'])), 1, 1, 'C');
    }
    
} elseif ($type == 'anggota') {
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'DATA ANGGOTA', 0, 1, 'C');
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(26, 44, 78);
    $pdf->SetTextColor(255);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(70, 8, 'Nama', 1, 0, 'C', true);
    $pdf->Cell(60, 8, 'Jabatan', 1, 0, 'C', true);
    $pdf->Cell(50, 8, 'Divisi', 1, 1, 'C', true);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0);
    
    $data = $pdo->query("SELECT a.*, d.nama_divisi FROM tabel_anggota a LEFT JOIN tabel_divisi d ON a.divisi_id = d.id ORDER BY a.id")->fetchAll();
    $no = 1;
    foreach ($data as $row) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(70, 7, $row['nama'], 1);
        $pdf->Cell(60, 7, $row['jabatan'], 1);
        $pdf->Cell(50, 7, $row['nama_divisi'], 1, 1);
    }
    
} else {
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'DATA DIVISI', 0, 1, 'C');
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(26, 44, 78);
    $pdf->SetTextColor(255);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(60, 8, 'Nama Divisi', 1, 0, 'C', true);
    $pdf->Cell(120, 8, 'Deskripsi', 1, 1, 'C', true);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0);
    
    $data = $pdo->query("SELECT * FROM tabel_divisi ORDER BY id")->fetchAll();
    $no = 1;
    foreach ($data as $row) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(60, 7, $row['nama_divisi'], 1);
        $pdf->Cell(120, 7, $row['deskripsi'], 1, 1);
    }
}

$pdf->Output('I', 'Laporan_' . ucfirst($type) . '_' . date('Ymd') . '.pdf');
