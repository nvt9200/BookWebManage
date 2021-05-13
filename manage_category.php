<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	
  //Get all Category 
  
  if(isset($_POST['cat_search']))
   {
     
    
      $cat_qry="SELECT * FROM tbl_category WHERE tbl_category.category_name like '%".addslashes($_POST['search_value'])."%' ORDER BY tbl_category.category_name DESC";  
               
      $result=mysqli_query($mysqli,$cat_qry);
    
     
   }
   else
   {
      $tableName="tbl_category";   
      $targetpage = "manage_category.php";   
      $limit = 10; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName";
      $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $total_pages = $total_pages['num'];
      
      $stages = 3;
      $page=0;
      if(isset($_GET['page'])){
      $page = mysqli_real_escape_string($mysqli,$_GET['page']);
      }
      if($page){
        $start = ($page - 1) * $limit; 
      }else{
        $start = 0; 
        } 
      
      
     $cat_qry="SELECT * FROM tbl_category
     ORDER BY tbl_category.category_name LIMIT $start, $limit";  

     $result=mysqli_query($mysqli,$cat_qry);

  }
	
	if(isset($_GET['cat_id']))
	{ 

    $img_res = mysqli_query($mysqli, 'SELECT * FROM tbl_category WHERE cid=\'' . $_GET['cid'] . '\'');
    $img_row = mysqli_fetch_assoc($img_res);
    
    if ($img_row['cat_images'] != "") {
      unlink('images/cat_images/' . $img_row['cat_images']);
    }

		Delete('tbl_category','cid='.$_GET['cat_id'].'');

		$_SESSION['msg']="12";
		header( "Location:manage_category.php");
		exit;
		
	}	
	 
?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Categories</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="cat_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                <div class="add_btn_primary"> <a href="add_category.php?add=yes">Add Category</a> </div>
              </div>
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
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>                  
                  <th>Category</th>
                  <th>Category Image</th>
                   <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php	
						$i=0;
						while($row=mysqli_fetch_array($result))
						{					
				?>
                <tr>                 
                  <td><?php echo $row['category_name'];?></td>
                  <td><span class="category_img">
                      <?php if($row['cat_image']!=null) {?>
                      <img type="image" src="images/cat_images/<?php echo $row['cat_image'];?>" />
                    <?php } else {?>
                      <img type="image" src="assets/images/no-image.png"  />
                    <?php }?></span></td>
                  <td><a href="add_category.php?cat_id=<?php echo $row['cid'];?>" class="btn btn-primary">Edit</a>
                    <a href="?cat_id=<?php echo $row['cid'];?>" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this category and related channel?');">Delete</a></td>
                </tr>
                <?php
						
						$i++;
				     	}
				?> 
              </tbody>
            </table>
          </div>
            <div class="col-md-12 col-xs-12">
              <div class="pagination_item_block">
                <nav>
                  <?php if(!isset($_POST["cat_search"])){ include("pagination.php");}?>                 
                </nav>
              </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
