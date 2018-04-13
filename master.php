<?php require_once('Connections/koneksi.php'); ?>
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
?><!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>PLN</title>
		<meta name="description" content="Blueprint: Horizontal Slide Out Menu" />
		<meta name="keywords" content="horizontal, slide out, menu, navigation, responsive, javascript, images, grid" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<center>
				<h3>Sistem Pembayaran PLN yang belum sempurna</h3>				
</center>
	<body>
		<div class="container">
				
			<div class="main">
				<nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper">
					<div class="cbp-hsinner">
						<ul class="cbp-hsmenu">
							<li>
								<a href="#">Tarif</a>
								<ul class="cbp-hssubmenu">
									<li><a href="t_tarif.php"><span>Tampil Data</span></a></li>
									<li><a href="i_tarif.php"><span>Input Data</span></a></li>
									<li><a href="c_tarif.php"><span>Cari Data</span></a></li>
								</ul>
							</li>
							<li>
								<a href="#">Pelanggan</a>
								<ul class="cbp-hssubmenu">
									<li><a href="t_pelanggan.php"><span>Tampil Data</span></a></li>
									<li><a href="i_pelanggan.php"><span>Input Data</span></a></li>
									<li><a href="c_pelanggan.php"><span>Cari Data</span></a></li>
								</ul>
							</li>
							<li>
								<a href="#">Tagihan</a>
								<ul class="cbp-hssubmenu">
									<li><a href="t_tagihan.php"><span>Tampil Data</span></a></li>
									<li><a href="i_tagihan.php"><span>Input Data</span></a></li>
									<li><a href="c_tagihan.php"><span>Cari Data</span></a></li>
								</ul>
							</li>
							<li>
								<a href="#">Pembayaran</a>
								<ul class="cbp-hssubmenu">
									<li><a href="t_pembayaran.php"><span>Tampil Data</span></a></li>
									<li><a href="i_pembayaran.php"><span>Input Data</span></a></li>
									<li><a href="c_pembayaran.php"><span>Cari Data</span></a></li>
								</ul>
							</li>
							<li>
								<a href="#">Cetak Laporan</a>
								<ul class="cbp-hssubmenu">
									<li><a href="#"><span>Tampil Data</span></a></li>
									<li><a href="#"><span>Input Data</span></a></li>
									<li><a href="#"><span>Cari Data</span></a></li>
								</ul>
							</li>
							<li><a href=""> Logout</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div>
		<p align="center">
		  <script src="js/cbpHorizontalSlideOutMenu.min.js"></script>
		  <script>
			var menu = new cbpHorizontalSlideOutMenu( document.getElementById( 'cbp-hsmenu-wrapper' ) );
		</script>
	      <span class="clearfix">Data Tarif </span></p>
		
        <div align="center">
          <table border="1">
            <tr>
              <td><div align="center">ID Tarif </div></td>
              <td><div align="center">Daya</div></td>
              <td><div align="center">Tarif PerKWH </div></td>
              <td><div align="center">Keterangan</div></td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_tarif['id_tarif']; ?></td>
                <td><?php echo $row_tarif['daya']; ?></td>
                <td><?php echo $row_tarif['tarif_perkwh']; ?></td>
                <td><?php echo $row_tarif['ket']; ?></td>
              </tr>
              <?php } while ($row_tarif = mysql_fetch_assoc($tarif)); ?>
                  </table>
        </div>
        <p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;    </p>
		</div>
	</body>
</html>
<?php
mysql_free_result($tarif);
?>
