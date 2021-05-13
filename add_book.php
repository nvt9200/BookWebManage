<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");


  //All Category
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
  $cat_result=mysqli_query($mysqli,$cat_qry);

  $author_qry="SELECT * FROM tbl_author ORDER BY author_name";
  $author_result=mysqli_query($mysqli,$author_qry);
	
	if(isset($_POST['submit']))
	{
	    
     $file_name= str_replace(" ","-",$_FILES['book_cover_img']['name']);

	   $book_cover_img=rand(0,99999)."_".$file_name;
		 	 
     //Main Image
     $file_tem_loc=$_FILES["book_cover_img"]["tmp_name"];
	   $tpath1='images/book_images/book_cover_img/'.$book_cover_img; 			 
     move_uploaded_file($file_tem_loc, $tpath1);
	 
      if($_FILES['book_bg_img']['name']!="")
      {
         $file_name2= str_replace(" ","-",$_FILES['book_bg_img']['name']);

         $book_bg_img=rand(0,99999)."_".$file_name2;
           
         //Main Image
         $file_tem_loc=$_FILES["book_bg_img"]["tmp_name"];
         $tpath2='images/book_images/book_bg_img/'.$book_bg_img;  
         move_uploaded_file($file_tem_loc, $tpath2);      
        
      }
      else
      {
        $book_bg_img=null;
      }

          
       $data = array( 
			   'cat_id'  =>  $_POST['cat_id'],
         'aid'  =>  $_POST['aid'],
         'book_title'  =>  addslashes($_POST['book_title']),
         'book_description'  =>  addslashes($_POST['book_description']),         
         'book_cover_img'  =>  $book_cover_img,
         'book_bg_img'  =>  $book_bg_img,
			    );		

 		$qry = Insert('tbl_books',$data);	

     
		$_SESSION['msg']="10";
 
		header( "Location:manage_books.php");
		exit;	

		
	}
	 

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

 
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Book</div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
 
              <div class="section">
                <div class="section-body">                 
                    <div class="form-group">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" required>
                        <option value="">--Select Category--</option>
                        <?php
                            while($cat_row=mysqli_fetch_array($cat_result))
                            {
                        ?>                       
                        <option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                           
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Author :-</label>
                    <div class="col-md-6">
                      <select name="aid" id="aid" class="select2" required>
                        <option value="">--Select Author--</option>
                        <?php
                            while($author_row=mysqli_fetch_array($author_result))
                            {
                        ?>                       
                        <option value="<?php echo $author_row['author_id'];?>"><?php echo $author_row['author_name'];?></option>                           
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Book Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="book_title" id="book_title" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Book Description :-</label>
                    <div class="col-md-6">
                 
                      <textarea name="book_description" id="book_description" class="form-control"></textarea>

                      <script>CKEDITOR.replace( 'book_description' );</script>
                    </div>
                  </div>                  
                  <div class="form-group">&nbsp;</div>
                                  
                   
                  <div class="form-group">&nbsp;</div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Book cover Image :-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="book_cover_img" value="" id="fileupload" required>
                            
                        	  <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="Featured image" /></div>
                        	 
                      </div>
                    </div>
                  </div>
                    <div class="form-group">
                    <label class="col-md-3 control-label">Book Bg Image :-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="book_bg_img" value="" id="fileupload" required>
                            
                            <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="Featured image" /></div>
                           
                      </div>
                    </div>
                  </div>
 
               
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
