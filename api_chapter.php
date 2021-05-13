<?php include("includes/connection.php");
 	  include("includes/function.php"); 

    if(isset($_GET['book_id']))
 	{
        $book_id=$_GET['book_id'];
        $jsonObj= array();

        $query="SELECT chap_id,book_id,chapter_number,chapter_title,chapter_content FROM tbl_chapter WHERE tbl_chapter.book_id = '".$book_id."' ORDER BY tbl_chapter.chapter_number ASC";
        $sql = mysqli_query($mysqli,$query)or die(mysql_error());

        while($data = mysqli_fetch_assoc($sql))
        {
            
            $row['chap_id'] = $data['chap_id'];
            $row['book_id'] = $data['book_id'];
            $row['chapter_number'] = $data['chapter_number'];
            $row['chapter_title'] = $data['chapter_title'];
            $row['chapter_content'] = stripslashes($data['chapter_content']);

            array_push($jsonObj,$row);
        
        }
        sort($jsonObj);
        $set['EBOOK_APP'] = $jsonObj;
        
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }

    if(isset($_GET['chap_id']))
 	{
        $chap_id=$_GET['chap_id'];

        $jsonObj= array();

        $query="SELECT chap_id,book_id,chapter_number,chapter_title,chapter_content FROM tbl_chapter WHERE tbl_chapter.chap_id = '".$chap_id."'";
        $sql = mysqli_query($mysqli,$query)or die(mysql_error());

        while($data = mysqli_fetch_assoc($sql))
        {
            
            $row['chap_id'] = $data['chap_id'];
            $row['book_id'] = $data['book_id'];
            $row['chapter_number'] = $data['chapter_number'];
            $row['chapter_title'] = $data['chapter_title'];
            $row['chapter_content'] = stripslashes($data['chapter_content']);

            array_push($jsonObj,$row);
        
        }

        $set['EBOOK_APP'] = $jsonObj;
        
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }

?>