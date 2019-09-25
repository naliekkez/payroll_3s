<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee History List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">History List</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>No</th>
                  <th>Name</th>
                  <th>Previous Position</th>
                  <th>Current Position</th>
                  <th>Date</th>
                </thead>
                <tbody>
                  <?php
                  
                    $branch = $_SESSION['branch'];
                    $sql = "SELECT *,(SELECT description from position where id = prev_position) as prev,(SELECT description from position where id = next_position) as next  from employees,history,position where employees.id = history.employee_id and position.id = employees.position_id AND (employees.branch_id = '$branch' or '0' = '$branch')";
                    
                    $query = $conn->query($sql);
                    $i=0;
                    while($row = $query->fetch_assoc()){
                      $i++;
                      ?>
                        <tr>
                          <td><?php echo $i ?></td>
                          <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>

                          <td><?php echo $row['prev']; ?></td>
                          <td><?php echo $row['next']; ?></td>
                          <td><?php echo date('d. M. Y', strtotime($row['Time'])); ?></td>
                          
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/employee_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>

</body>
</html>
