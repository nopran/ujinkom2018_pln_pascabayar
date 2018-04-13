<?php require_once('../Connections/koneksi.php'); ?>
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

  $updateGoTo = "data_pembayaran.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_pembayaran = "-1";
if (isset($_GET['id_pembayaran'])) {
  $colname_pembayaran = (get_magic_quotes_gpc()) ? $_GET['id_pembayaran'] : addslashes($_GET['id_pembayaran']);
}
mysql_select_db($database_koneksi, $koneksi);
$query_pembayaran = sprintf("SELECT * FROM pembayaran WHERE id_pembayaran = %s ORDER BY id_pembayaran ASC", $colname_pembayaran);
$pembayaran = mysql_query($query_pembayaran, $koneksi) or die(mysql_error());
$row_pembayaran = mysql_fetch_assoc($pembayaran);
$totalRows_pembayaran = mysql_num_rows($pembayaran);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tampil Data Pelanggan</title>
<link rel="stylesheet" type="text/css" href="../style.css">
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
<p align="center" class="style1">&nbsp;</p>
<p align="center" class="style1">Update Data Pembayaran </p>
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
          <td><input type="text" name="id_tagihan" value="<?php echo $row_pembayaran['id_tagihan']; ?>" size="32"></td>
        </tr>
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
          <td><input type="submit" value="Update">
            <label>
			<a title="Cetak Invoice" onclick ="window.print();" target="_blank" style="cursor:pointer"></a> </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id_pembayaran" value="<?php echo $row_pembayaran['id_pembayaran']; ?>">
</form>
    <p>&nbsp;</p>
    <p align="center" class="style1">&nbsp;</p>

<p align="center" class="style1">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pembayaran);


?>
