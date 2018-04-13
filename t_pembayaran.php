<?php require_once('Connections/koneksi.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$maxRows_pembayaran = 10;
$pageNum_pembayaran = 0;
if (isset($_GET['pageNum_pembayaran'])) {
  $pageNum_pembayaran = $_GET['pageNum_pembayaran'];
}
$startRow_pembayaran = $pageNum_pembayaran * $maxRows_pembayaran;

mysql_select_db($database_koneksi, $koneksi);
$query_pembayaran = "SELECT * FROM pembayaran ORDER BY id_pembayaran ASC";
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
<p><a href="<?php echo $logoutAction ?>"></a></p>
<p align="center">Data Pembayaran</p>
<table border="1" align="center">
  <tr>
    <td bgcolor="#00CCFF"><div align="center"><strong>ID Pembayaran</strong></div></td>
    <td bgcolor="#00CCFF"><div align="center"><strong>Tanggal Bayar </strong></div></td>
    <td bgcolor="#00CCFF"><div align="center"><strong>ID Tagihan </strong></div></td>
    <td bgcolor="#00CCFF"><div align="center"><strong>Biaya Denda </strong></div></td>
    <td bgcolor="#00CCFF"><div align="center"><strong>Biaya Admin </strong></div></td>
    <td bgcolor="#00CCFF"><div align="center"><strong>Status Pembayaran </strong></div></td>
    <td colspan="2" bgcolor="#00CCFF"><strong>Action</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_pembayaran['id_pembayaran']; ?></div></td>
      <td><div align="center"><?php echo $row_pembayaran['tgl_bayar']; ?></div></td>
      <td><div align="center"><?php echo $row_pembayaran['id_tagihan']; ?></div></td>
      <td><?php echo $row_pembayaran['biaya_denda']; ?></td>
      <td><?php echo $row_pembayaran['biaya_admin']; ?></td>
      <td><div align="center"><?php echo $row_pembayaran['status_pembayaran']; ?></div></td>
      <td><a href="e_pembayaran.php?id_pembayaran=<?php echo $row_pembayaran['id_pembayaran']; ?>">Update</a></td>
      <td><a href="d_pembayaran.php?id_pembayaran=<?php echo $row_pembayaran['id_pembayaran']; ?>">Delete</a></td>
    </tr>
    <?php } while ($row_pembayaran = mysql_fetch_assoc($pembayaran)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($tarif);

mysql_free_result($pembayaran);
?>
