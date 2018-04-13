<?php require_once('Connections/koneksi.php'); ?>
<?php
$maxRows_tagihan = 10;
$pageNum_tagihan = 0;
if (isset($_GET['pageNum_tagihan'])) {
  $pageNum_tagihan = $_GET['pageNum_tagihan'];
}
$startRow_tagihan = $pageNum_tagihan * $maxRows_tagihan;

$colname_tagihan = "-1";
if (isset($_GET['cari'])) {
  $colname_tagihan = (get_magic_quotes_gpc()) ? $_GET['cari'] : addslashes($_GET['cari']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_tagihan = sprintf("SELECT * FROM tagihan WHERE id_tagihan LIKE '%%%s%%' ORDER BY id_tagihan ASC", $colname_tagihan);
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
			<li><a href="t_tagihan.php">Tampil Data</a></li>
			<li><a href="i_tagihan.php">Input Data</a></li>
			<li><a href="c_tagihan.php">Cari Data</a></li>
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
<p align="center"><strong>Cari Data Tagihan </strong></p>
<form id="form1" name="form1" method="get" action="">
  <div align="center">
    <table width="535" border="0" align="center">
      <tr>
        <td width="241" align="right">Silahkan Masukkan ID Tagihan </td>
        <td width="144"><label>
          <input name="cari" type="text" id="cari" />
        </label></td>
        <td width="136"><label>
          <input type="submit" name="Submit" value="Submit" />
        </label></td>
      </tr>
    </table>
  </div>
</form>
<p align="center">&nbsp;</p>


<?php if ($totalRows_tagihan > 0) { // Show if recordset not empty ?>
  <table border="1" align="center">
    <tr>
      <td bgcolor="#0099FF"><div align="center"><strong>ID Tagihan </strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Tahun Tagih </strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Bulan Tagih </strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Pemakaian</strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>Status Tagihan </strong></div></td>
      <td bgcolor="#0099FF"><div align="center"><strong>No Pelanggan </strong></div></td>
    </tr>
    <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_tagihan['id_tagihan']; ?></div></td>
      <td><div align="center"><?php echo $row_tagihan['tahun_tagih']; ?></div></td>
      <td><?php echo $row_tagihan['bulan_tagih']; ?></td>
      <td><?php echo $row_tagihan['pemakaian']; ?></td>
      <td><?php echo $row_tagihan['status_tagihan']; ?></td>
      <td><div align="center"><?php echo $row_tagihan['no_pelanggan']; ?></div></td>
    </tr>
    <?php } while ($row_tagihan = mysql_fetch_assoc($tagihan)); ?>
</table>
  <?php } // Show if recordset not empty ?><div align="center"> </div>
  <p align="center">No Pelanggan Belum Terdaftar </p>
<div align="center"> </div>
</body>
</html>
<?php
mysql_free_result($tagihan);
?>