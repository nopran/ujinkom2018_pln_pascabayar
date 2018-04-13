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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pembayaran SET tgl_bayar=%s, id_tagihan=%s, biaya_denda=%s, biaya_admin=%s, status_pembayaran=%s WHERE id_pembayaran=%s",
                       GetSQLValueString($_POST['tgl_bayar'], "date"),
                       GetSQLValueString($_POST['id_tagihan'], "int"),
                       GetSQLValueString($_POST['biaya_denda'], "double"),
                       GetSQLValueString($_POST['biaya_admin'], "double"),
                       GetSQLValueString($_POST['status_pembayaran'], "text"),
                       GetSQLValueString($_POST['id_pembayaran'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "t_pembayaran.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_tarif = "-1";
if (isset($_GET['id_tarif'])) {
  $colname_tarif = (get_magic_quotes_gpc()) ? $_GET['id_tarif'] : addslashes($_GET['id_tarif']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_tarif = sprintf("SELECT * FROM tarif WHERE id_tarif = '%s' ORDER BY id_tarif ASC", $colname_tarif);
$tarif = mysql_query($query_tarif, $koneksi) or die(mysql_error());
$row_tarif = mysql_fetch_assoc($tarif);
$totalRows_tarif = mysql_num_rows($tarif);

$colname_pembayaran = "-1";
if (isset($_GET['id_pembayaran'])) {
  $colname_pembayaran = (get_magic_quotes_gpc()) ? $_GET['id_pembayaran'] : addslashes($_GET['id_pembayaran']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_pembayaran = sprintf("SELECT * FROM pembayaran WHERE id_pembayaran = %s ORDER BY id_pembayaran ASC", $colname_pembayaran);
$pembayaran = mysql_query($query_pembayaran, $koneksi) or die(mysql_error());
$row_pembayaran = mysql_fetch_assoc($pembayaran);
$totalRows_pembayaran = mysql_num_rows($pembayaran);

mysql_select_db($database_koneksi, $koneksi);
$query_tagihan = "SELECT * FROM tagihan ORDER BY id_tagihan ASC";
$tagihan = mysql_query($query_tagihan, $koneksi) or die(mysql_error());
$row_tagihan = mysql_fetch_assoc($tagihan);
$totalRows_tagihan = mysql_num_rows($tagihan);
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
.style2 {font-family: Georgia, "Times New Roman", Times, serif}
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
<p align="center" class="style1">Update Pembayaran</p>
<p align="center" class="style1">&nbsp;</p>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">ID Pembayaran:</td>
      <td><?php echo $row_pembayaran['id_pembayaran']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tanggal Bayar:</td>
      <td><input type="text" name="tgl_bayar" value="<?php echo $row_pembayaran['tgl_bayar']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">ID Tagihan:</td>
      <td><select name="id_tagihan">
        <?php 
do {  
?>
        <option value="<?php echo $row_tagihan['id_tagihan']?>" <?php if (!(strcmp($row_tagihan['id_tagihan'], $row_pembayaran['id_tagihan']))) {echo "SELECTED";} ?>><?php echo $row_tagihan['id_tagihan']?></option>
        <?php
} while ($row_tagihan = mysql_fetch_assoc($tagihan));
?>
      </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Biaya Denda:</td>
      <td><input type="text" name="biaya_denda" value="<?php echo $row_pembayaran['biaya_denda']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Biaya Admin:</td>
      <td><input type="text" name="biaya_admin" value="<?php echo $row_pembayaran['biaya_admin']; ?>" size="32"></td>
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
      <td><input type="submit" value="Update"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_pembayaran" value="<?php echo $row_pembayaran['id_pembayaran']; ?>">
</form>
</body>
</html>
<?php
mysql_free_result($tarif);

mysql_free_result($pembayaran);

mysql_free_result($tagihan);
?>
