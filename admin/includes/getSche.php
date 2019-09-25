<?php
  include 'conn.php';
  if ($_POST) {
      $branch = $_POST['branch'];
      if ($branch != '') {
         
         echo "<option value=\"\" selected>- Select -</option>"; 
         $sql = "SELECT * FROM schedules where branch_id = $branch";
            $query = $conn->query($sql);
            while($srow = $query->fetch_assoc()){
              echo "
                <option value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
              ";
          }
        
      }
      else
      {
          echo  '';
      }
  }
?>