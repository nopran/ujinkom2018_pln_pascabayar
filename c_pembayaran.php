<?php require_once('Connections/koneksi.php'); ?>
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
<p align="center"><strong>Cari Data Pembayaran </strong></p>
<form id="form1" name="form1" method="get" action="">
  <div align="center">
    <table width="567" border="0" align="center">
      <tr>
        <td width="249">Silahkan Masukkan ID Pembayaran </td>
        <td width="153"><label>
          <input name="cari" type="text" id="cari" />
        </label></td>
        <td width="151"><label>
          <input type="submit" name="Submit" value="Submit" />
        </label></td>
      </tr>
    </table>
  </div>
</form>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>


<?php if ($totalRows_pembayaran > 0) { // Show if recordset not empty ?>
  <div align="center">
    <table border="1" align="center">
          <tr>
            <td bgcolor="#0099FF"><div align="center"><strong>ID Pembayaran </strong></div></td>
            <td bgcolor="#0099FF"><div align="center"><strong>Tanggal</strong></div></td>
            <td bgcolor="#0099FF"><div align="center"><strong>ID Tagihan </strong></div></td>
            <td bgcolor="#0099FF"><div align="center"><strong>Biaya Denda </strong></div></td>
            <td bgcolor="#0099FF"><div align="center"><strong>Biaya Admin </strong></div></td>
            <td bgcolor="#0099FF"><div align="center"><strong>Status Pembayaran </strong></div></td>
          </tr>
          <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_pembayaran['id_pembayaran']; ?></div></td>
        <td><div align="center"><?php echo $row_pembayaran['tgl_bayar']; ?></div></td>
        <td><div align="center"><?php echo $row_pembayaran['id_tagihan']; ?></div></td>
        <td><div align="center"><?php echo $row_pembayaran['biaya_denda']; ?></div></td>
        <td><div align="center"><?php echo $row_pembayaran['biaya_admin']; ?></div></td>
        <td><div align="center"><?php echo $row_pembayaran['status_pembayaran']; ?></div></td>
      </tr>
      <?php } while ($row_pembayaran = mysql_fetch_assoc($pembayaran)); ?>
</table>
  </div>
  <?php } // Show if recordset not empty ?><?php if ($totalRows_tarif == 0) { // Show if recordset empty ?>
    <p align="center">No Pelanggan Belum Terdaftar </p>
    <?php } // Show if recordset empty ?><div align="center"> </div>
</body>
</html>
<?php
mysql_free_result($tarif);

mysql_free_result($pembayaran);
?>
