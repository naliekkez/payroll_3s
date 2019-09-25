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
        Employee Exchange
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Employee Exchange Request</li>
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
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Employee ID</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Authorized by</th>
                  <th>Requested by</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $branch = $_SESSION['branch'];
                    $sql = "SELECT *, employees.employee_id AS empid, exchange.id AS attid FROM employees,exchange,position where employees.id=exchange.employee_id AND (exchange.branch_id = '$branch' OR '0' = '$branch') AND approved = 0 AND position.id = exchange.position_id ORDER BY exchange.date DESC, exchange.time_in DESC ";
                    
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      $status = ($row['status'])?'<span class="label label-warning pull-right">ontime</span>':'<span class="label label-danger pull-right">late</span>';
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".date('M d, Y', strtotime($row['date']))."</td>
                          <td>".$row['empid']."</td>
                          <td>".$row['firstname'].' '.$row['lastname']."</td>
                          <td>".$row['description']."</td>
                          <td>".date('h:i A', strtotime($row['time_in'])).$status."</td>
                          <td>".date('h:i A', strtotime($row['time_out']))."</td>
                          <td>".$row['authorized_by']."</td>
                          <td>".$row['requested_by']."</td>
                          <td>
                            
                            <button class='btn btn-success btn-sm btn-flat approve' data-id='".$row['attid']."'><i class='fa fa-edit'></i> Approve</button>
                            <button class='btn btn-danger btn-sm btn-flat reject' data-id='".$row['attid']."'><i class='fa fa-trash'></i> Reject</button>
                                
                          </td>
                        </tr>
                      ";
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
  <?php include 'includes/exchange_modal.php'; ?>
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
$(document).ready(function() {
    
    $('#example1').on('click', '.approve', function (e) {
         e.preventDefault();
        $('#approve').modal('show');
        var id = $(this).data('id');

        getRow(id);
    } );
    $('#example1').on('click', '.reject', function (e) {
        e.preventDefault();
        $('#reject').modal('show');
        var id = $(this).data('id');

        getRow(id);
    } );
} );

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'exchange_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#datepicker_edit').val(response.date);
      $('#exchange_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#approve_attid').val(response.attid);
      $('#approve_employee_name').html(response.firstname+' '+response.lastname);
      $('#reject_attid').val(response.attid);
      $('#reject_employee_name').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
