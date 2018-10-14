<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<title>Google Crawl</title>
</head>
<body>
	<!-- Begin page content -->
	<main role="main" class="container">
		<h1 class="mt-5">Google Maps Crawl</h1>
	
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<div class="form-group">
				<input type="text" class="form-control" name="Txt_cari" placeholder="Cari...?">
				<small id="emailHelp" class="form-text text-muted">cari hotel, pariwisata, pelabuhan</small>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="Txt_kab" placeholder="Negara/Provinsi/Kab/Kota...?">
			</div>
			<button type="submit" class="btn btn-primary" name="btn_find">Submit</button>
		</form>
	</main>
	<br/><br/>
	<main role="main" class="container">
	<?php if(isset($_POST['btn_find'])){ ?>
	<h3>Hasil : <?php echo $_POST['Txt_cari']; ?> </h3>
	<table class="table table-border">
	<tr>
		<td>Nomor</td>
		<td>Nama</td>
		<td>Alamat</td>
		<td>Latitude</td>
		<td>Longitude</td>
	</tr>
	<?php
		$api 	= ""; //Google Key
		$find 	= str_replace(" ", "%20", $_POST['Txt_cari']);
		$kab 	= $_POST['Txt_kab'];
		$url 	= "https://maps.googleapis.com/maps/api/place/textsearch/xml?query=".$find."+in+".$kab."&key=".$api;

		$data 	= file_get_contents($url);
		$result = simplexml_load_string($data);
		$no = 1;
		//print_r($result);
		$next_page_token 	= $result->next_page_token;
		foreach ($result->result as $value) {
			echo "<tr>";
			echo "<td>".$no++."</td>";
			echo "<td>".$value->name."</td>";
			echo "<td>".$value->formatted_address."</td>";
			echo "<td>".$value->geometry->location->lat."</td>";
			echo "<td>".$value->geometry->location->lng."</td>";
			echo "</tr>";
		}
		echo "Token : ".$next_page_token;
		echo "Status : ".$result->status;
	}
	?>
	</table>
	</main>
	<br/><br/>
	<footer class="footer">
		<div class="container">
			<span class="text-muted">Created By Ridowan - ridowann@gmail.com</span>
		</div>
	</footer>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
