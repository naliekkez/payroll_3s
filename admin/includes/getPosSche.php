<?php
  if ($_POST) {
      $branch = $_POST['branch'];
      if ($branch != '') {
         echo "<select class=\"form-control\" name=\"position\" id=\"position\" required>";
         echo "<option value=\"\" selected>- Select -</option>"; 
         $sql = "SELECT * FROM position where branch_id = $branch";
          $query = $conn->query($sql);
          while($prow = $query->fetch_assoc()){
            echo "
              <option value='".$prow['id']."'>".$prow['description']."</option>
            ";
          }
        
         echo "</select>";
      }
      else
      {
          echo  '';
      }
  }
?>