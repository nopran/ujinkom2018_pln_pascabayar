<?php require_once('Connections/koneksi.php'); ?>
<?php
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_koneksi, $koneksi);
$query_Recordset1 = "SELECT * FROM pelanggan";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $koneksi) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_koneksi, $koneksi);
$query_Recordset2 = "SELECT * FROM pelanggan ORDER BY no_pelanggan ASC";
$Recordset2 = mysql_query($query_Recordset2, $koneksi) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$maxRows_tagihan = 10;
$pageNum_tagihan = 0;
if (isset($_GET['pageNum_tagihan'])) {
  $pageNum_tagihan = $_GET['pageNum_tagihan'];
}
$startRow_tagihan = $pageNum_tagihan * $maxRows_tagihan;

mysql_select_db($database_koneksi, $koneksi);
$query_tagihan = "SELECT * FROM tagihan ORDER BY id_tagihan ASC";
$query_limit_tagihan = sprintf("%s LIMIT %d, %d", $query_tagihan, $startRow_tagihan, $maxRows_tagihan);
$tagihan = mysql_query($query_limit_tagihan, $koneksi) or die(mysql_error());
$row_tagihan = mysql_fetch_assoc($tagihan);

if (isset($_GET['totalRows_tagihan'])) {
  $totalRows_tagihan = $_GET['totalRows_tagihan'];
} else {
  $all_tagihan = mysql_query($query_tagihan);
  $totalRows_tagihan = mysql_num_rows($all_tagihan);
}
$totalPages_tagihan = ceil($totalRows_tagihan/$maxRows_tagihan)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tampil Data Pelanggan</title>
<link rel="stylesheet" type="text/css" href="style.css">
<style type="text/css">
<!--
.style1 {
	font-size: x-large;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<center>
	<h1>PLN Belum Jadi</h1>
</center>
<div class="container">	
<a class="toggleMenu" href="#">Menu</a>
<ul class="nav">
	<li  class="test">
		<a href="#">Tarif</a>
		<ul>
			<li><a href="t_tarif.php">Tampil Data</a></li>
			<li><a href="i_tarif.php">Input Data</a></li>
			<li><a href="c_tarif.php">Cari Data</a></li>
		</ul>
	</li>
	<li  class="test">
		<a href="#">Pelanggan</a>
		<ul>
			<li><a href="t_pelanggan.php">Tampil Data</a></li>
			<li><a href="i_pelanggan.php">Input Data</a></li>
			<li><a href="c_pelanggan.php">Cari Data</a></li>
		</ul>
	</li>
	<li  class="test">
		<a href="#">Tagihan</a>
		<ul>
			<li><a href="t_tagihan.php">Tampil Data</a></li>
			<li><a href="i_tagihan.php">Input Data</a></li>
			<li><a href="c_tagihan.php">Cari Data</a></li>
		</ul>
	</li>
	<li  class="test">
		<a href="#">Pembayaran</a>
		<ul>
			<li><a href="t_pembayaran.php">Tampil Data</a></li>
			<li><a href="i_pembayaran.php">Input Data</a></li>
			<li><a href="c_pembayaran.php">Cari Data</a></li>
		</ul>
	</li>
	<li  class="test">
		<a href="#">Cetak Laporan </a>
		<ul>
			<li><a href="cetak_laporan_tagihan.php">Laporan Tagihan</a></li>
			<li><a href="cetak_laporan_pembayaran.php">Laporan Pembayaran</a></li>
		</ul>
	</li>
	<li  class="test">
		<a href="logout.php">Logout</a>
	</li>
</ul>
</div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="script.js"></script>

<p align="center" class="style1">&nbsp;</p>
<p align="center" class="style1">Tampil Data Tagihan </p>
<div align="center">
  <table border="1">
    <tr>
      <td bgcolor="#00CCFF"><div align="center"><strong>ID Tagihan </strong></div></td>
      <td bgcolor="#00CCFF"><div align="center"><strong>Tahun Tagihan </strong></div></td>
      <td bgcolor="#00CCFF"><div align="center"><strong>Bulan Tagih </strong></div></td>
      <td bgcolor="#00CCFF"><div align="center"><strong>Pemakain</strong></div></td>
      <td bgcolor="#00CCFF"><div align="center"><strong>Status Tagihan </strong></div></td>
      <td bgcolor="#00CCFF"><div align="center"><strong>No Pelanggan </strong></div></td>
      <td colspan="2" bgcolor="#00CCFF"><div align="center"><strong>Action</strong></div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_tagihan['id_tagihan']; ?></div></td>
        <td><div align="center"><?php echo $row_tagihan['tahun_tagih']; ?></div></td>
        <td><?php echo $row_tagihan['bulan_tagih']; ?></td>
        <td><?php echo $row_tagihan['pemakaian']; ?></td>
        <td><?php echo $row_tagihan['status_tagihan']; ?></td>
        <td><div align="center"><?php echo $row_tagihan['no_pelanggan']; ?></div></td>
        <td><a href="e_tagihan.php?id_tagihan=<?php echo $row_tagihan['id_tagihan']; ?>">Update</a></td>
        <td><a href="d_tagihan.php?id_tagihan=<?php echo $row_tagihan['id_tagihan']; ?>">Delete</a></td>
      </tr>
      <?php } while ($row_tagihan = mysql_fetch_assoc($tagihan)); ?>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($tagihan);
?>
