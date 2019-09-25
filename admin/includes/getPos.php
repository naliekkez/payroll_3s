<?php
  include 'conn.php';
  if ($_POST) {
      $branch = $_POST['branch'];
      if ($branch != '') {
        
         echo "<option value=\"\" selected>- Select -</option>"; 
         $sql = "SELECT * FROM position where branch_id = $branch";
          $query = $conn->query($sql);
          while($prow = $query->fetch_assoc()){
            echo "
              <option value='".$prow['id']."'>".$prow['description']."</option>
            ";
          }
        
      }
      else
      {
          echo  '';
      }
  }
?>