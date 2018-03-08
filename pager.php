<?php

function db_connection(){

	$conn = mysqli_connect('localhost','root','vendershop','ajaxdb');

	if(!$conn){

		die('Unable to connect');
	}

	return $conn;
}

function get_total_rows(){

	$total = mysqli_query(db_connection(),"SELECT * FROM hashes");

	return mysqli_num_rows($total);
}

function query_data($page_num = 1,$per_page = 20){

	if($page == 1 || !isset($_GET['page'])){

		$offset = 0;

	}else{

		$offset  = (($page_num * $per_page) - $per_page );
	}

	$data = mysqli_query(db_connection(),'SELECT * FROM hashes LIMIT '.$offset.','.$per_page);

	return $data;
}

function get_page_links(){

	$linkstr = '';

	$total = mysqli_query(db_connection(),"SELECT * FROM hashes");

	$total_pages = ceil(mysqli_num_rows($total) / 20 );

	for($i=1; $i<=$total_pages; $i++){

		$linkstr.='<li><a href='.$_SERVER["PHP_SELF"].'?page='.$i.'>'.$i.'</a></li>';
	}

	return '<ul class="pagination">'.$linkstr.'</ul>';
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<title>Pager Sample</title>
</head>
	<body>
		<?php foreach(query_data($_GET['page']) as $result ): ?>

		<?php echo $result['id'].'-'. $result['hash_id'].'<br>'; ?>

		<?php endforeach; ?>

		<?php echo get_page_links(); ?>
	</body>
</html>



