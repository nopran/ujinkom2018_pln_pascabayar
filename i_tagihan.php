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
  $insertSQL = sprintf("INSERT INTO tagihan (id_tagihan, tahun_tagih, bulan_tagih, pemakaian, status_tagihan, no_pelanggan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_tagihan'], "int"),
                       GetSQLValueString($_POST['tahun_tagih'], "date"),
                       GetSQLValueString($_POST['bulan_tagih'], "text"),
                       GetSQLValueString($_POST['pemakaian'], "int"),
                       GetSQLValueString($_POST['status_tagihan'], "text"),
                       GetSQLValueString($_POST['no_pelanggan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "t_tagihan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
$query_pelanggan = "SELECT * FROM pelanggan ORDER BY no_pelanggan ASC";
$pelanggan = mysql_query($query_pelanggan, $koneksi) or die(mysql_error());
$row_pelanggan = mysql_fetch_assoc($pelanggan);
$totalRows_pelanggan = mysql_num_rows($pelanggan);

$maxRows_tagihan = 10;
$pageNum_tagihan = 0;
if (isset($_GET['pageNum_tagihan'])) {
  $pageNum_tagihan = $_GET['pageNum_tagihan'];
}
$startRow_tagihan = $pageNum_tagihan * $maxRows_tagihan;

$colname_tagihan = "-1";
if (isset($_GET['id_tagihan'])) {
  $colname_tagihan = (get_magic_quotes_gpc()) ? $_GET['id_tagihan'] : addslashes($_GET['id_tagihan']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_tagihan = sprintf("SELECT * FROM tagihan WHERE id_tagihan = %s ORDER BY id_tagihan ASC", $colname_tagihan);
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
<p align="center" class="style1">Input Data Tagihan </p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">ID Tagihan:</td>
      <td><input type="text" name="id_tagihan" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tahun Tagih:</td>
      <td><input type="text" name="tahun_tagih" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Bulan Tagih:</td>
      <td><select name="bulan_tagih">
        <option value="Januari" <?php if (!(strcmp("Januari", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Januari</option>
        <option value="Februari" <?php if (!(strcmp("Februari", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Februari</option>
        <option value="Maret" <?php if (!(strcmp("Maret", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Maret</option>
        <option value="April" <?php if (!(strcmp("April", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>April</option>
        <option value="Mei" <?php if (!(strcmp("Mei", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Mei</option>
        <option value="Juni" <?php if (!(strcmp("Juni", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Juni</option>
        <option value="Juli" <?php if (!(strcmp("Juli", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Juli</option>
        <option value="Agustus" <?php if (!(strcmp("Agustus", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Agustus</option>
        <option value="September" <?php if (!(strcmp("September", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>September</option>
        <option value="Oktober" <?php if (!(strcmp("Oktober", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Oktober</option>
        <option value="November" <?php if (!(strcmp("November", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>November</option>
        <option value="Desember" <?php if (!(strcmp("Desember", $row_tagihan['bulan_tagih']))) {echo "SELECTED";} ?>>Desember</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Pemakaian:</td>
      <td><input type="text" name="pemakaian" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status</td>
      <td><select name="status_tagihan">
        <option value="Belum Bayar" <?php if (!(strcmp("Belum Bayar", $row_tagihan['status_tagihan']))) {echo "SELECTED";} ?>>Belum Bayar</option>
        <option value="Lunas" <?php if (!(strcmp("Lunas", $row_tagihan['status_tagihan']))) {echo "SELECTED";} ?>>Lunas</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No Pelanggan </td>
      <td><select name="no_pelanggan">
        <?php 
do {  
?>
        <option value="<?php echo $row_pelanggan['no_pelanggan']?>" <?php if (!(strcmp($row_pelanggan['no_pelanggan'], $row_pelanggan['no_pelanggan']))) {echo "SELECTED";} ?>><?php echo $row_pelanggan['no_pelanggan']?></option>
        <?php
} while ($row_pelanggan = mysql_fetch_assoc($pelanggan));
?>
      </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Tambah"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<p align="center" class="style1">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($pelanggan);

mysql_free_result($tagihan);
?>
