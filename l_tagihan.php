<?php
//header("content-type:application/vnd-ms-excel");
//header("content-diposition:attachment;filename=cetak-laporan.xls"); ?>

<?php require_once('Connections/koneksi.php'); ?>
<?php

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_koneksi, $koneksi);
$query_Recordset1 = "SELECT * FROM tagihan ORDER BY id_tagihan ASC";
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="623" border="0" align="center">
  <tr>
    <td width="105"><img src="logo.png" width="100" height="100" /></td>
    <td width="502"><p><strong>PT. PLN<br />
    Jl. Gatot Subroto. </strong></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="2"><p align="center">&nbsp;</p>
      <p align="center"><strong>Laporan Tagihan </strong></p>
      <table border="1" align="center">
        <tr>
          <td><div align="center">ID Tagihan </div></td>
          <td><div align="center">Tahun Tagih </div></td>
          <td><div align="center">Bulan Tagih </div></td>
          <td><div align="center">Pemakaian</div></td>
          <td><div align="center">Status</div></td>
          <td><div align="center">No Pelanggan </div></td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_Recordset1['id_tagihan']; ?></td>
            <td><?php echo $row_Recordset1['tahun_tagih']; ?></td>
            <td><?php echo $row_Recordset1['bulan_tagih']; ?></td>
            <td><?php echo $row_Recordset1['pemakaian']; ?></td>
            <td><?php echo $row_Recordset1['status_tagihan']; ?></td>
            <td><?php echo $row_Recordset1['no_pelanggan']; ?></td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </table>
    <p align="right">Jonggol..............20.....<br />
Penanggung Jawab,<br />
</p>
    <p align="right">&nbsp;<br />
        <br />
    (...........................................)</p></td>
  </tr>
</table>
<div align="right">
  <p>&nbsp; <br>
    <br>
    &nbsp;<br/>
    &nbsp;<br/>
&nbsp;  </p>
  </p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
