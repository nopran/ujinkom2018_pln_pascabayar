<?php require_once('../Connections/koneksi.php'); ?>
<?php

$maxRows_tarif = 10;
$pageNum_tarif = 0;
if (isset($_GET['pageNum_tarif'])) {
  $pageNum_tarif = $_GET['pageNum_tarif'];
}
$startRow_tarif = $pageNum_tarif * $maxRows_tarif;

$colname_tarif = "-1";
if (isset($_GET['cari'])) {
  $colname_tarif = (get_magic_quotes_gpc()) ? $_GET['cari'] : addslashes($_GET['cari']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_tarif = sprintf("SELECT * FROM tarif WHERE id_tarif = '%s' ORDER BY id_tarif ASC", $colname_tarif);
$query_limit_tarif = sprintf("%s LIMIT %d, %d", $query_tarif, $startRow_tarif, $maxRows_tarif);
$tarif = mysql_query($query_limit_tarif, $koneksi) or die(mysql_error());
$row_tarif = mysql_fetch_assoc($tarif);

if (isset($_GET['totalRows_tarif'])) {
  $totalRows_tarif = $_GET['totalRows_tarif'];
} else {
  $all_tarif = mysql_query($query_tarif);
  $totalRows_tarif = mysql_num_rows($all_tarif);
}
$totalPages_tarif = ceil($totalRows_tarif/$maxRows_tarif)-1;

$maxRows_pembayaran = 10;
$pageNum_pembayaran = 0;
if (isset($_GET['pageNum_pembayaran'])) {
  $pageNum_pembayaran = $_GET['pageNum_pembayaran'];
}
$startRow_pembayaran = $pageNum_pembayaran * $maxRows_pembayaran;

$colname_pembayaran = "-1";
if (isset($_GET['cari'])) {
  $colname_pembayaran = (get_magic_quotes_gpc()) ? $_GET['cari'] : addslashes($_GET['cari']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_pembayaran = sprintf("SELECT * FROM pembayaran WHERE id_tagihan LIKE '%%%s%%' ORDER BY id_pembayaran ASC", $colname_pembayaran);
$query_limit_pembayaran = sprintf("%s LIMIT %d, %d", $query_pembayaran, $startRow_pembayaran, $maxRows_pembayaran);
$pembayaran = mysql_query($query_limit_pembayaran, $koneksi) or die(mysql_error());
$row_pembayaran = mysql_fetch_assoc($pembayaran);

if (isset($_GET['totalRows_pembayaran'])) {
  $totalRows_pembayaran = $_GET['totalRows_pembayaran'];
} else {
  $all_pembayaran = mysql_query($query_pembayaran);
  $totalRows_pembayaran = mysql_num_rows($all_pembayaran);
}
$totalPages_pembayaran = ceil($totalRows_pembayaran/$maxRows_pembayaran)-1;

$maxRows_kasir_pembayaran = 10;
$pageNum_kasir_pembayaran = 0;
if (isset($_GET['pageNum_kasir_pembayaran'])) {
  $pageNum_kasir_pembayaran = $_GET['pageNum_kasir_pembayaran'];
}
$startRow_kasir_pembayaran = $pageNum_kasir_pembayaran * $maxRows_kasir_pembayaran;

mysql_select_db($database_koneksi, $koneksi);
$query_kasir_pembayaran = "SELECT * FROM query_pembayaran ORDER BY id_pembayaran ASC";
$query_limit_kasir_pembayaran = sprintf("%s LIMIT %d, %d", $query_kasir_pembayaran, $startRow_kasir_pembayaran, $maxRows_kasir_pembayaran);
$kasir_pembayaran = mysql_query($query_limit_kasir_pembayaran, $koneksi) or die(mysql_error());
$row_kasir_pembayaran = mysql_fetch_assoc($kasir_pembayaran);

if (isset($_GET['totalRows_kasir_pembayaran'])) {
  $totalRows_kasir_pembayaran = $_GET['totalRows_kasir_pembayaran'];
} else {
  $all_kasir_pembayaran = mysql_query($query_kasir_pembayaran);
  $totalRows_kasir_pembayaran = mysql_num_rows($all_kasir_pembayaran);
}
$totalPages_kasir_pembayaran = ceil($totalRows_kasir_pembayaran/$maxRows_kasir_pembayaran)-1;

$maxRows_pembayran = 10;
$pageNum_pembayran = 0;
if (isset($_GET['pageNum_pembayran'])) {
  $pageNum_pembayran = $_GET['pageNum_pembayran'];
}
$startRow_pembayran = $pageNum_pembayran * $maxRows_pembayran;

mysql_select_db($database_koneksi, $koneksi);
$query_pembayran = "SELECT id_pembayaran, tgl_bayar, pemakaian, nama_pelanggan, daya, tarif_perkwh, status_pembayaran, Total_tagihan FROM query_pembayaran ORDER BY id_pembayaran ASC";
$query_limit_pembayran = sprintf("%s LIMIT %d, %d", $query_pembayran, $startRow_pembayran, $maxRows_pembayran);
$pembayran = mysql_query($query_limit_pembayran, $koneksi) or die(mysql_error());
$row_pembayran = mysql_fetch_assoc($pembayran);

if (isset($_GET['totalRows_pembayran'])) {
  $totalRows_pembayran = $_GET['totalRows_pembayran'];
} else {
  $all_pembayran = mysql_query($query_pembayran);
  $totalRows_pembayran = mysql_num_rows($all_pembayran);
}
$totalPages_pembayran = ceil($totalRows_pembayran/$maxRows_pembayran)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tampil Tarif</title>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>

<body>
<center>
	<h1>PLN Sedikit Lagi Jadi</h1>
</center>
<div class="container">	
<a class="toggleMenu" href="#">Menu</a>
<ul class="nav">
	<li  class="test">
		<a href="#">Pembayaran</a>
		<ul>
			<li><a href="kasir_pembayaran.php">Cari Data</a></li>
			<li><a href="data_pembayaran.php">Tampil Data</a></li>
	  </ul>
	</li>
	<li  class="test">
		<a href="#">Cetak Laporan </a>
		<ul>
			<li><a href="../cetak_laporan_tagihan.php">Laporan Tagihan</a></li>
			<li><a href="../cetak_laporan_pembayaran.php">Laporan Pembayaran</a></li>
		</ul>
	</li>
	<li  class="test">
		<a href="../logout.php">Logout</a>	
	</li>
</ul>
</div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../script.js"></script>

<p>&nbsp;</p>
<p align="center"><strong> Data Pembayaran</strong></p>
<p align="center">&nbsp;</p>

<table border="1">
  <tr>
    <td bgcolor="#00FFFF"><div align="center"><strong>ID Pembayaran </strong></div></td>
    <td bgcolor="#00FFFF"><div align="center"><strong>Tanggal Bayar </strong></div></td>
    <td bgcolor="#00FFFF"> <div align="center"><strong>Pemakaian </strong></div></td>
    <td bgcolor="#00FFFF"><div align="center"><strong>Nama Pelanggan </strong></div></td>
    <td bgcolor="#00FFFF"><div align="center"><strong>Daya</strong></div></td>
    <td bgcolor="#00FFFF"><div align="center"><strong>Tarif peKWH </strong></div></td>
    <td bgcolor="#00FFFF"><div align="center"><strong>Status Pembayaran </strong></div></td>
    <td bgcolor="#00FFFF"><div align="center"><strong>Total Tagihan </strong></div></td>
    <td colspan="2" bgcolor="#00FFFF"><div align="center"><strong>Action</strong></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_pembayran['id_pembayaran']; ?></div></td>
      <td><?php echo $row_pembayran['tgl_bayar']; ?></td>
      <td><?php echo $row_pembayran['pemakaian']; ?></td>
      <td><?php echo $row_pembayran['nama_pelanggan']; ?></td>
      <td><?php echo $row_pembayran['daya']; ?></td>
      <td><?php echo $row_pembayran['tarif_perkwh']; ?></td>
      <td><?php echo $row_pembayran['status_pembayaran']; ?></td>
      <td><?php echo $row_pembayran['Total_tagihan']; ?></td>
      <td><a href="detail_pembayaran.php?id_pembayaran=<?php echo $row_pembayran['id_pembayaran']; ?>">Detail</a></td>
      <td><a href="kasir_pembayaran_update.php?id_pembayaran=<?php echo $row_pembayran['id_pembayaran']; ?>">Bayar</a></td>
    </tr>
    <?php } while ($row_pembayran = mysql_fetch_assoc($pembayran)); ?>
</table>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>

<p>&nbsp;</p>

<form id="form1" name="form1" method="get" action="">
  <div align="center"></div>
</form>
</body>
</html>
<?php
mysql_free_result($tarif);

mysql_free_result($pembayaran);

mysql_free_result($kasir_pembayaran);

mysql_free_result($pembayran);
?>
