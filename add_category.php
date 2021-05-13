<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");



if (isset($_POST['submit']) and isset($_GET['add'])) {
    if ($_FILES['cat_image']['name'] != "") {
      $file_name = $_FILES['cat_image']['name'];
    
      $cat_image = rand(0, 99999) . "_" . $file_name;
    
      $file_tem_loc = $_FILES["cat_image"]["tmp_name"];
    
      //Main Image
      $tpath1 = 'images/cat_images/' . $cat_image;
    
      move_uploaded_file($file_tem_loc, $tpath1);
    } else {
        $cat_image='no_categories.png';
    }
      $data = array(
        'category_name'  =>  $_POST['category_name'],
        'cat_image'  =>  $cat_image
        );

  $qry = Insert('tbl_category', $data);

  $_SESSION['msg'] = "10";

  header("Location:manage_category.php");
  exit;
}

if (isset($_GET['cat_id'])) {

  $qry = "SELECT * FROM tbl_category where cid='" . $_GET['cat_id'] . "'";
  $result = mysqli_query($mysqli, $qry);
  $row = mysqli_fetch_assoc($result);
}
if (isset($_POST['submit']) and isset($_POST['cat_id'])) {

  if ($_FILES['cat_image']['name'] != "") {

    $file_name = $_FILES['cat_image']['name'];

    $cat_image = rand(0, 99999) . "_" . $file_name;

    $file_tem_loc = $_FILES["cat_image"]["tmp_name"];

    //Main Image
    $tpath1 = 'images/cat_images/' . $cat_image;

    move_uploaded_file($file_tem_loc, $tpath1);
  } else {
    $cat_image = $_POST['cat_image_hidden'];
  }

  $data = array(
    'category_name'  =>  addslashes($_POST['category_name']),
    'cat_image'  =>  $cat_image
  );

$category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['cat_id']."'");
    if ($category_edit > 0){
      $_SESSION['msg'] = "11";
      header("Location:manage_category.php");
      exit;
    }
}


?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?php if (isset($_GET['cat_id'])) { ?>Edit<?php } else { ?>Add<?php } ?> Category</div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row mrg-top">
        <div class="col-md-12">

          <div class="col-md-12 col-sm-12">
            <?php if (isset($_SESSION['msg'])) { ?>
              <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?php echo $client_lang[$_SESSION['msg']]; ?></a> </div>
            <?php unset($_SESSION['msg']);
            } ?>
          </div>
        </div>
      </div>
      <div class="card-body mrg_bottom">
        <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id']; ?>" />

          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Category Name :-</label>
                <div class="col-md-6">
                  <input type="text" name="category_name" id="category_name" value="<?php if (isset($_GET['cat_id'])) {
                                                                                      echo $row['category_name'];
                                                                                    } ?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Category Image :-</label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="hidden" name="cat_image_hidden" id="cat_image_hidden" value="<?php echo $row['cat_image'];?>">
                    <input type="file" name="cat_image" value="fileupload" id="fileupload">
                    <?php if (isset($_GET['cat_id']) and $row['cat_image'] != "") { ?>
                      <div class="fileupload_img"><img type="image" src="images/cat_images/<?php echo $row['cat_image']; ?>" alt="category image" /></div>
                    <?php } else { ?>
                      <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                    <?php } ?>
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

<?php include("includes/footer.php"); ?>