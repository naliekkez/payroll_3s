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
        Cash Advance
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Request</li>
        <li class="active">Cash Advance Request</li>
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
           
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Date</th>
                  <th>Employee ID</th>
                  <th>Name</th>
                  <th>Amount</th>
                  <th>Authorized by</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <?php
                    $branch = $_SESSION['branch'];
                    $sql = "SELECT *, cashadvance.id cid FROM cashadvance,employees where cashadvance.employee_id = employees.employee_id AND approved != 0";
                    
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      if($row['approved'] == 1){
                            $lascol = "</td>
                                <td>
                                  <div class='btn-success'>Approved</div>  
                                </td>
                              </tr>
                            ";
                          }

                          else if($row['approved'] == 2){
                            $lascol = "</td>
                                <td>
                                  <div class='btn-danger'>Rejected</div>  
                                </td>
                              </tr>
                            ";
                          }
                      echo "
                        <tr>
                          <td>".date('M d, Y', strtotime($row['date_advance']))."</td>
                          <td>".$row['employee_id']."</td>
                          <td>".$row['firstname'].' '.$row['lastname']."</td>
                          <td>".$row['amount']."</td>
                          <td>".$row['authorized_by']."</td>
                          ".$lascol;
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
  <?php include 'includes/cashadvance_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){


  $('.approve').click(function(e){

    e.preventDefault();
    $('#approve').modal('show');
    var id = $(this).data('id');

    getRow(id);
  });
  $('.reject').click(function(e){

    e.preventDefault();
    $('#reject').modal('show');
    var id = $(this).data('id');

    getRow(id);
  });
});

function getRow(id){

  $.ajax({
    type: 'POST',
    url: 'cashadvance_row.php',
    data: {id:id},
    dataType : 'json',
    success: function(response){
      console.log(response);
      
      
      
      $('#approve_attid').val(response.id);
      $('#approve_empid').val(response.employee_id);
      $('#approve_amount').val(response.amount);
      
      $('#approve_employee_name').html(response.employee_id);
      $('#reject_employee_name').html(response.employee_id);
    }
  });
}
</script>
</body>
</html>
