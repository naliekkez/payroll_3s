<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$branch = $_SESSION['branch'];
		//$sql = "SELECT *, branch.branch_id as bid from admin,branch where id=$id and admin.branch_id = branch.branch_id";
		
		$sql = "SELECT * from admin where id=$id";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>