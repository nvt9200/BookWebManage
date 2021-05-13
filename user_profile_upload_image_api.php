<?php include("includes/connection.php");

    include('includes/function.php');

    //set random file name with time
    $user_images = rand(0, 99999) . '_' . time() . ".jpeg";
    
    $tpath = 'images/user_images/' . $user_images;
    
    if (move_uploaded_file($_FILES['user_image']['tmp_name'], $tpath))
    {
        $data = array(
            'user_image'  =>  $user_images
        );
        $user_edit=Update('tbl_users', $data, "WHERE id = '".$_GET['id']."'");
        $set['EBOOK_APP'][]=
        array(
            "Message" => "the file has been uploaded.",
            "success" => "1"
        );
    } else {
        $set['EBOOK_APP'][]=
        array(
            "Message" => "Sorry, there was an error uploading your file.",
            "success" => "0"
        );
    }
        
    header( 'Content-Type: application/json; charset=utf-8' );
	$json = json_encode($set);
	echo $json;
	exit;
?>
