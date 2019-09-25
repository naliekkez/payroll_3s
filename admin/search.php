<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; 

  $keyword = strval($_POST['query']);
  $search_param = "{$keyword}%";

  $sql = $conn->prepare("SELECT * FROM employees WHERE employee_id LIKE ?");
  $sql->bind_param("s",$search_param);      
  $sql->execute();
  $result = $sql->get_result();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    $countryResult[] = $row["firstname"] ." " . $row['lastname'] . " (". $row['employee_id'] .")";
    }
    echo json_encode($countryResult);
  }
  $conn->close();
?>