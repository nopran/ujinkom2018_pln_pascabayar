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

$colname_kasir_pembayaran = "-1";
if (isset($_GET['cari'])) {
  $colname_kasir_pembayaran = (get_magic_quotes_gpc()) ? $_GET['cari'] : addslashes($_GET['cari']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_kasir_pembayaran = sprintf("SELECT * FROM query_pembayaran WHERE id_pembayaran LIKE '%%%s%%' ORDER BY id_pembayaran ASC", $colname_kasir_pembayaran);
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
<p align="center"><strong>Cari Data Pembayaran </strong></p>
<form id="form1" name="form1" method="get" action="">
  <div align="center">
    <table width="65%" border="0" align="center">
      <tr>
        <td width="378"><div align="right">Silahkan Masukkan ID Pelanggan </div></td>
        <td width="166"><label>
          <input name="cari" type="text" id="cari" />
        </label></td>
        <td width="279"><label>
          <input type="submit" name="Submit" value="Submit" />
        </label></td>
      </tr>
    </table>
  </div>
</form>
<p align="center">&nbsp;</p>



  <div align="center"> </div>
  
    <?php if ($totalRows_kasir_pembayaran == 0) { // Show if recordset empty ?>
      <p align="center">No Pelanggan Belum Terdaftar </p>
      <?php } // Show if recordset empty ?>
    <div align="center"> </div>
    <?php if ($totalRows_kasir_pembayaran > 0) { // Show if recordset not empty ?>
      <table border="0" align="center">
        <tr>
          <td bgcolor="#00CCFF"><div align="center"><strong>ID Pembayaran </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Tanggal Bayar </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>ID Tagihan </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Tahun Tagih </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Bulan </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Pemakain</strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>No Pelanggan </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Nama Pelanggan </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Daya</strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Tarif perKWH </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Keterangan</strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Biaya Denda </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Biaya Admin </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Status Pembayaran </strong></div></td>
          <td bgcolor="#00CCFF"><div align="center"><strong>Total Tagihan </strong></div></td>
          <td bgcolor="#00CCFF"><strong>Action</strong></td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_kasir_pembayaran['id_pembayaran']; ?></td>
            <td><?php echo $row_kasir_pembayaran['tgl_bayar']; ?></td>
            <td><?php echo $row_kasir_pembayaran['id_tagihan']; ?></td>
            <td><?php echo $row_kasir_pembayaran['tahun_tagih']; ?></td>
            <td><?php echo $row_kasir_pembayaran['bulan_tagih']; ?></td>
            <td><?php echo $row_kasir_pembayaran['pemakaian']; ?></td>
            <td><?php echo $row_kasir_pembayaran['no_pelanggan']; ?></td>
            <td><?php echo $row_kasir_pembayaran['nama_pelanggan']; ?></td>
            <td><?php echo $row_kasir_pembayaran['daya']; ?></td>
            <td><?php echo $row_kasir_pembayaran['tarif_perkwh']; ?></td>
            <td><?php echo $row_kasir_pembayaran['ket']; ?></td>
            <td><?php echo $row_kasir_pembayaran['biaya_denda']; ?></td>
            <td><?php echo $row_kasir_pembayaran['biaya_admin']; ?></td>
            <td><?php echo $row_kasir_pembayaran['status_pembayaran']; ?></td>
            <td><?php echo $row_kasir_pembayaran['Total_tagihan']; ?></td>
            <td><a href="kasir_pembayaran_update.php?id_pembayaran=<?php echo $row_kasir_pembayaran['id_pembayaran']; ?>">Bayar</a></td>
          </tr>
          <?php } while ($row_kasir_pembayaran = mysql_fetch_assoc($kasir_pembayaran)); ?>
    </table>
      <?php } // Show if recordset not empty ?></body>
</html>
<?php
mysql_free_result($tarif);

mysql_free_result($pembayaran);

mysql_free_result($kasir_pembayaran);
?>
