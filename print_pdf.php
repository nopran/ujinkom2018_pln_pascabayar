<?php
function generateRow(){
		$contents = '';
		include_once('connection.php');
		$sql = "SELECT * FROM query_pembayaran";
		//use for MySQLi OOP
		$query = $conn->query($sql);
		while($row = $query->fetch_assoc()){
			$contents .= "
			<tr>
				<td>".$row['id_pembayaran']."</td>
				<td>".$row['tgl_bayar']."</td>
				<td>".$row['id_tagihan']."</td>
				<td>".$row['tahun_tagih']."</td>
				<td>".$row['bulan_tagih']."</td>
				<td>".$row['pemakaian']."</td>
				<td>".$row['no_pelanggan']."</td>
				<td>".$row['nama_pelanggan']."</td>
				<td>".$row['daya']."</td>
				<td>".$row['tarif_perkwh']."</td>
				<td>".$row['ket']."</td>
				<td>".$row['biaya_denda']."</td>
				<td>".$row['biaya_admin']."</td>
				<td>".$row['status_pembayaran']."</td>
				<td>".$row['Total_tagihan']."</td>
			</tr>
			";
		}
		////////////////

		//use for MySQLi Procedural
		// $query = mysqli_query($conn, $sql);
		// while($row = mysqli_fetch_assoc($query)){
		// 	$contents .= "
		// 	<tr>
		// 		<td>".$row['id']."</td>
		// 		<td>".$row['firstname']."</td>
		// 		<td>".$row['lastname']."</td>
		// 		<td>".$row['address']."</td>
		// 	</tr>
		// 	";
		// }
		////////////////
		
		return $contents;
	}

	require_once('tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Generated PDF using TCPDF");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">Generated PDF using TCPDF</h2>
      	<h4>Members Table</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th>ID Pembayaran</th>
				<th>Tanggal Bayar</th>
				<th>ID Tagihan</th>
				<th>Tahun Tagih</th>
				<th>Bulan Tagih</th>
				<th>Pemakaian</th>
				<th>No Pelanggan</th>
				<th>Nama Pelanggan</th>
				<th>Daya</th>
				<th>Tarif perKWH</th>
				<th>Keterangan</th>
				<th>Biaya Denda</th>
				<th>Biaya Admin</th>
				<th>Status Pembayaran</th>
				<th>Total Tagihan</th> 
           </tr>  
      ';  
    $content .= generateRow();  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('members.pdf', 'I');
	
?>