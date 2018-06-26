<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();

$conn = new mysqli("localhost", "root", "", "dokumentasi_ta");
if ($conn->connect_errno) {
    echo die("Failed to connect to MySQL: " . $conn->connect_error);
}

$nama = $_REQUEST['nama'];
$nim = $_REQUEST['nim'];
$judul = $_REQUEST['judul'];
$dosen = $_REQUEST['nama'];
$tahun = $_REQUEST['tahun'];
?>