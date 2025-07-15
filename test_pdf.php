<?php
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>PDF Berhasil!</h1><p>Contoh isi PDF.</p>');
$mpdf->Output();
