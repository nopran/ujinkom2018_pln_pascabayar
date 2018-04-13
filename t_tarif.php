<?php require_once('Connections/koneksi.php'); ?>
<?php
$maxRows_tarif = 10;
$pageNum_tarif = 0;
if (isset($_GET['pageNum_tarif'])) {
  $pageNum_tarif = $_GET['pageNum_tarif'];
}
$startRow_tarif = $pageNum_tarif * $maxRows_tarif;

mysql_select_db($database_koneksi, $koneksi);
$query_tarif = "SELECT * FROM tarif ORDER BY id_tarif ASC";
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tampil Tarif</title>
<link rel="stylesheet" type="text/css" href="style.css">
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
<p>&nbsp;</p>
<p align="center">Data Tarif</p>
<div align="center">
  <table border="1">
    <tr>
      <td bgcolor="#0099FF"><div align="center"><strong>ID Tarif </strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Daya</strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Tarif PerKWH </strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Keterangan</strong></div></td>
      <td colspan="2" bgcolor="#0099FF"><div align="center"><strong>Action</strong></div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_tarif['id_tarif']; ?></td>
        <td><?php echo $row_tarif['daya']; ?></td>
        <td><?php echo $row_tarif['tarif_perkwh']; ?></td>
        <td><?php echo $row_tarif['ket']; ?></td>
        <td><a href="e_tarif.php?id_tarif=<?php echo $row_tarif['id_tarif']; ?>">Update</a></td>
        <td><a href="d_tarif.php?id_tarif=<?php echo $row_tarif['id_tarif']; ?>">Delete</a></td>
      </tr>
      <?php } while ($row_tarif = mysql_fetch_assoc($tarif)); ?>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($tarif);
?>
