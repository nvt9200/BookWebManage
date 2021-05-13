<?php include("includes/connection.php");
 
	include('includes/function.php');
 
	$qry = "SELECT * FROM tbl_users WHERE id = '".$_GET['id']."'"; 
	$result = mysqli_query($mysqli,$qry);
	 
	$row = mysqli_fetch_assoc($result);
  				 
    $set['EBOOK_APP'][]=array('user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'password'=>$row['password'],'phone'=>$row['phone'],'user_image'=>$row['user_image'],'dt_register'=>$row['dt_register'],'success'=>'1');
			  
		 

	header( 'Content-Type: application/json; charset=utf-8' );
	$json = json_encode($set);
	echo $json;
	 exit;
	 
?>