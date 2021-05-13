<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");



if (isset($_GET['chap_id'])) {

    $qry = "SELECT * FROM tbl_chapter where chap_id='" . $_GET['chap_id'] . "'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {

    $data = array(
        'chapter_number' => $_POST['chapter_number'],
        'chapter_title'  =>  addslashes($_POST['chapter_title']),
        'chapter_content'  =>  addslashes($_POST['chapter_content']),
    );

    $book_edit = Update('tbl_chapter', $data, "WHERE chap_id = '" . $_POST['chap_id'] . "'");


    $_SESSION['msg'] = "11";

    header("Location:manage_chapter_list.php?book_id=" . $row['book_id']);
    exit;
}



?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">Edit chapter</div>
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

                    <input type="hidden" name="chap_id" value="<?php echo $_GET['chap_id']; ?>" />
                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>" />

                    <div class="section">
                        <div class="section-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label">chapter Of Number :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="chapter_number" id="chapter_number" value="<?php echo stripslashes($row['chapter_number']); ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Chapter Title :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="chapter_title" id="chapter_title" value="<?php echo stripslashes($row['chapter_title']); ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Chapter Content :-</label>
                                <div class="col-md-6">
                                    <div class="fileupload_block">

                                        <textarea name="chapter_content" id="chapter_content" class="form-control"><?php echo stripslashes($row['chapter_content']); ?></textarea>

                                        <script>
                                            CKEDITOR.replace('chapter_content');
                                        </script>
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