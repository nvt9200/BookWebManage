<?php include('includes/header.php');

include('includes/function.php');
include('language/language.php');


if (isset($_POST['books_search'])) {

		$book_id=$_GET['book_id'];
	
		$books_qry = "SELECT * FROM tbl_chapter
								LEFT JOIN tbl_books ON tbl_chapter.book_id= tbl_books.id
								WHERE tbl_chapter.book_id = '".$book_id."' AND tbl_chapter.chapter_number like '%" . addslashes($_POST['chapter_title']) . "%' 
								ORDER BY tbl_chapter.chapter_number ASC";
		$books_result = mysqli_query($mysqli, $books_qry);
} else {
	if (isset($_GET['book_id'])) {

		$book_id=$_GET['book_id'];

		$tableName = "tbl_chapter";
		$targetpage = "manage_chapter_list.php?book_id=$book_id&";
		$limit = 50;

		$query = "SELECT COUNT(*) as num FROM $tableName
			LEFT JOIN tbl_books ON tbl_chapter.book_id= tbl_books.id
			WHERE tbl_chapter.chapter_number = chapter_number";
		$total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
		$total_pages = $total_pages['num'];


		$stages = 3;
		$page = 0;
		if (isset($_GET['page'])) {
			$page = mysqli_real_escape_string($mysqli, $_GET['page']);
		}
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}
		

		$books_qry = "SELECT * FROM tbl_chapter
			LEFT JOIN tbl_books ON tbl_chapter.book_id= tbl_books.id
			WHERE tbl_chapter.book_id = '".$book_id."'
			ORDER BY tbl_chapter.chapter_number ASC LIMIT $start, $limit";

		$books_result = mysqli_query($mysqli, $books_qry);
	}
}
if (isset($_GET['chapter_id'])) {

	Delete('tbl_chapter', 'chap_id=' . $_GET['chapter_id'] . '');

	$_SESSION['msg'] = "12";
	header("Location:manage_chapter_list.php");
	exit;
}


?>


<div class="row">
	<div class="col-xs-12">
		<div class="card mrg_bottom">
			<div class="page_title_block">
				<div class="col-md-5 col-xs-12">
					<div class="page_title">Chapter Lists</div>
				</div>
				<div class="col-md-7 col-xs-12">
					<div class="search_list">
						<div class="search_block">
							<form method="post" action="">
								<input class="form-control input-sm" placeholder="Search book..." aria-controls="DataTables_Table_0" type="search" name="chapter_title" required>
								<button type="submit" name="books_search" class="btn-search"><i class="fa fa-search"></i></button>
							</form>
						</div>
						<tbody>
						
						<div class="add_btn_primary"> <a href="add_chapter.php?book_id=<?php echo $_GET['book_id'];?>">Add chapter</a> </div>
						</tbody>
					</div>

				</div>
			</div>

			<div class="col-md-12 col-xs-12">
				<div class="pagination_item_block">
					<nav>

						<?php if (!isset($_POST["books_search"])) {
							$book_id=$_GET['book_id'];
							include("pagination_chapter.php");
						} ?>
					</nav>
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
			<div class="col-md-12 mrg-top">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>

							<th>Book Title</th>
							<th>Chapter Number</th>
							<th>Chapter Title</th>
							<th class="cat_action_list">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 0;
						while ($books_row = mysqli_fetch_array($books_result)) {

						?>
							<tr>
								<td><?php echo $books_row['book_title']; ?></td>
								<td><?php echo $books_row['chapter_number']; ?></td>
								<td><?php echo stripslashes($books_row['chapter_title']); ?></td>
								<td><a href="edit_chapter.php?chap_id=<?php echo $books_row['chap_id']; ?>" class="btn btn-primary">Edit</a>
									<a href="manage_chapter_list.php?chapter_id=<?php echo $books_row['chap_id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');" class="btn btn-default">Delete</a></td>
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

						<?php if (!isset($_POST["books_search"])) {
							include("pagination_chapter.php");
						} ?>
					</nav>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<?php include('includes/footer.php'); ?>