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
  $insertSQL = sprintf("INSERT INTO tarif (id_tarif, daya, tarif_perkwh, ket) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_tarif'], "text"),
                       GetSQLValueString($_POST['daya'], "text"),
                       GetSQLValueString($_POST['tarif_perkwh'], "double"),
                       GetSQLValueString($_POST['ket'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "t_tarif.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_pelanggan = 10;
$pageNum_pelanggan = 0;
if (isset($_GET['pageNum_pelanggan'])) {
  $pageNum_pelanggan = $_GET['pageNum_pelanggan'];
}
$startRow_pelanggan = $pageNum_pelanggan * $maxRows_pelanggan;

mysql_select_db($database_koneksi, $koneksi);
$query_pelanggan = "SELECT * FROM pelanggan";
$query_limit_pelanggan = sprintf("%s LIMIT %d, %d", $query_pelanggan, $startRow_pelanggan, $maxRows_pelanggan);
$pelanggan = mysql_query($query_limit_pelanggan, $koneksi) or die(mysql_error());
$row_pelanggan = mysql_fetch_assoc($pelanggan);

if (isset($_GET['totalRows_pelanggan'])) {
  $totalRows_pelanggan = $_GET['totalRows_pelanggan'];
} else {
  $all_pelanggan = mysql_query($query_pelanggan);
  $totalRows_pelanggan = mysql_num_rows($all_pelanggan);
}
$totalPages_pelanggan = ceil($totalRows_pelanggan/$maxRows_pelanggan)-1;

mysql_select_db($database_koneksi, $koneksi);
$query_tarif = "SELECT * FROM tarif ORDER BY id_tarif ASC";
$tarif = mysql_query($query_tarif, $koneksi) or die(mysql_error());
$row_tarif = mysql_fetch_assoc($tarif);
$totalRows_tarif = mysql_num_rows($tarif);
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
<p align="center" class="style1">Input Data Tarif </p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">ID Tarif:</td>
          <td><input type="text" name="id_tarif" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Daya:</td>
          <td><select name="daya">
              <option value="R-1/450A" <?php if (!(strcmp("R-1/450A", ""))) {echo "SELECTED";} ?>>R-1/450A</option>
              <option value="R-1/500A" <?php if (!(strcmp("R-1/500A", ""))) {echo "SELECTED";} ?>>R-1/500A</option>
              <option value="R-1/900A" <?php if (!(strcmp("R-1/900A", ""))) {echo "SELECTED";} ?>>R-1/900A</option>
              <option value="R-1/460A" <?php if (!(strcmp("R-1/460A", ""))) {echo "SELECTED";} ?>>R-1/460A</option>
              <option value="R-1/490A" <?php if (!(strcmp("R-1/490A", ""))) {echo "SELECTED";} ?>>R-1/490A</option>
            </select>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Tarif Perkwh:</td>
          <td><input type="text" name="tarif_perkwh" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Keterangan:</td>
          <td><select name="ket">
              <option value="Subsidi" <?php if (!(strcmp("Subsidi", ""))) {echo "SELECTED";} ?>>Subsidi</option>
              <option value="Non Subsidi" <?php if (!(strcmp("Non Subsidi", ""))) {echo "SELECTED";} ?>>Non Subsidi</option>
            </select>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Tambah Tarif"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pelanggan);

mysql_free_result($tarif);
?>
