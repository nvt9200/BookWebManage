<?php include('includes/header.php');

include('includes/function.php');
include('language/language.php');


if (isset($_POST['books_search'])) {


	$books_qry = "SELECT * FROM tbl_books
							WHERE tbl_books.book_title 
							like '%" . addslashes($_POST['book_title']) . "%' 
							ORDER BY tbl_books.id DESC";

	$books_result = mysqli_query($mysqli, $books_qry);
} else {

	$tableName = "tbl_books";
	$targetpage = "manage_chapter.php";
	$limit = 10;

	$query = "SELECT COUNT(*) as num FROM $tableName";
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


	$books_qry = "SELECT * FROM tbl_books
			ORDER BY tbl_books.id DESC LIMIT $start, $limit";

	$books_result = mysqli_query($mysqli, $books_qry);
}

//Active and Deactive status
if (isset($_GET['status_deactive_id'])) {
	$data = array('book_chapter_status'  =>  '0');

	$edit_status = Update('tbl_books', $data, "WHERE id = '" . $_GET['status_deactive_id'] . "'");

	$_SESSION['msg'] = "14";
	header("Location:manage_chapter.php");
	exit;
}
if (isset($_GET['status_active_id'])) {
	$data = array('book_chapter_status'  =>  '1');

	$edit_status = Update('tbl_books', $data, "WHERE id = '" . $_GET['status_active_id'] . "'");

	$_SESSION['msg'] = "13";
	header("Location:manage_chapter.php");
	exit;
}


?>


<div class="row">
	<div class="col-xs-12">
		<div class="card mrg_bottom">
			<div class="page_title_block">
				<div class="col-md-5 col-xs-12">
					<div class="page_title">Manage chapter</div>
				</div>
				<div class="col-md-7 col-xs-12">
					<div class="search_list">
						<div class="search_block">
							<form method="post" action="">
								<input class="form-control input-sm" placeholder="Search book..." aria-controls="DataTables_Table_0" type="search" name="book_title" required>
								<button type="submit" name="books_search" class="btn-search"><i class="fa fa-search"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12 mrg-top">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Title</th>
							<th>Image</th>
							<th>Chapter Status</th>
							<th class="cat_action_list">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 0;
						while ($books_row = mysqli_fetch_array($books_result)) {

						?>
							<tr>
								<td><?php echo stripslashes($books_row['book_title']); ?></td>
								<td><img src="images/book_images/book_cover_img/<?php echo $books_row['book_cover_img']; ?>" width="100" height="150" /></td>
								<td>
									<?php if ($books_row['book_chapter_status'] != "0") { ?>
										<a href="manage_chapter.php?status_deactive_id=<?php echo $books_row['id']; ?>" title="Change Status"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Hoàn Thành</span></span></a>
									<?php } else { ?>
										<a href="manage_chapter.php?status_active_id=<?php echo $books_row['id']; ?>" title="Change Status"><span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Chưa Hoàn Thành </span></span></a>
									<?php } ?>
								</td>
								<td><a href="manage_chapter_list.php?book_id=<?php echo $books_row['id']; ?>" class="btn btn-primary">Manage chapters</a>

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
							include("pagination.php");
						} ?>
					</nav>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>



<?php include('includes/footer.php'); ?>