<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");

if (isset($_POST['submit'])) {

    if(isset($_GET['book_id']))
    {
        $book_id = $_GET['book_id'];
        $data = array(
            'book_id'  =>$book_id,
            'chapter_number' => $_POST['chapter_number'],
            'chapter_title'  =>  addslashes($_POST['chapter_title']),
            'chapter_content'  =>  addslashes($_POST['chapter_content']),
        );

        $qry = Insert('tbl_chapter', $data);


        $_SESSION['msg'] = "10";

        header("Location:manage_chapter_list.php?book_id=$book_id");
        exit;
    }
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">Add Chapter</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card-body mrg_bottom">
                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">

                    <div class="section">
                        <div class="section-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Chapter Of Number : -</label>
                                <div class="col-md-6">
                                    <input type="text" name="chapter_number" id="chapter_number" value="" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Chapter Title :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="chapter_title" id="chapter_title" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Chapter Content :-</label>
                                <div class="col-md-6">
                                    <div class="fileupload_block">

                                        <textarea name="chapter_content" id="chapter_content" class="form-control"></textarea>

                                        <script>
                                            CKEDITOR.replace('chapter_content');
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">&nbsp;</div>


                            <div class="form-group">&nbsp;</div>
                            
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