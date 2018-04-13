<?php require_once('Connections/koneksi.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pembayaran (id_pembayaran, tgl_bayar, id_tagihan, biaya_denda, biaya_admin, status_pembayaran) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pembayaran'], "int"),
                       GetSQLValueString($_POST['tgl_bayar'], "date"),
                       GetSQLValueString($_POST['id_tagihan'], "int"),
                       GetSQLValueString($_POST['biaya_denda'], "double"),
                       GetSQLValueString($_POST['biaya_admin'], "double"),
                       GetSQLValueString($_POST['status_pembayaran'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "t_pembayaran.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_pembayaran = 10;
$pageNum_pembayaran = 0;
if (isset($_GET['pageNum_pembayaran'])) {
  $pageNum_pembayaran = $_GET['pageNum_pembayaran'];
}
$startRow_pembayaran = $pageNum_pembayaran * $maxRows_pembayaran;

$colname_pembayaran = "-1";
if (isset($_GET['id_pembayaran'])) {
  $colname_pembayaran = (get_magic_quotes_gpc()) ? $_GET['id_pembayaran'] : addslashes($_GET['id_pembayaran']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_pembayaran = sprintf("SELECT * FROM pembayaran WHERE id_pembayaran = %s ORDER BY id_pembayaran ASC", $colname_pembayaran);
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
<p align="center" class="style1">Input Data Pembayaran </p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">ID Pembayaran:</td>
      <td><input type="text" name="id_pembayaran" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tanggal Bayar:</td>
      <td><input type="text" name="tgl_bayar" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">ID Tagihan:</td>
      <td><select name="id_tagihan">
          <?php
do {  
?><option value="<?php echo $row_tagihan['id_tagihan']?>"<?php if (!(strcmp($row_tagihan['id_tagihan'], $row_pembayaran['id_tagihan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tagihan['id_tagihan']?></option>
        <?php
} while ($row_tagihan = mysql_fetch_assoc($tagihan));
  $rows = mysql_num_rows($tagihan);
  if($rows > 0) {
      mysql_data_seek($tagihan, 0);
	  $row_tagihan = mysql_fetch_assoc($tagihan);
  }
?>
      </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Biaya Denda:</td>
      <td><input type="text" name="biaya_denda" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Biaya Admin:</td>
      <td><input type="text" name="biaya_admin" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status Pembayaran:</td>
      <td><select name="status_pembayaran">
        <option value="Lunas" <?php if (!(strcmp("Lunas", $row_pembayaran['status_pembayaran']))) {echo "SELECTED";} ?>>Lunas</option>
        <option value="Belum Lunas" <?php if (!(strcmp("Belum Lunas", $row_pembayaran['status_pembayaran']))) {echo "SELECTED";} ?>>Belum Lunas</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Tambah Pembayaran"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pembayaran);

mysql_free_result($tagihan);
?>
