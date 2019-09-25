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
        Positions
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Positions</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Position Title</th>
                  <th>Branch</th>
                  <th>Rate per Day</th>
                  <th>Lunch Fund</th>
                  <th>Transport Fund</th>
                  <th>Insentive Fund</th>
                  <th>Position Fund</th>
                  <th>Late cut</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $branch = $_SESSION['branch'];
                    $sql = "SELECT *,branch.name as bname FROM position,branch where branch.branch_id = position.branch_id";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['description']."</td>
                          <td>".$row['bname']."</td>
                          <td>".number_format($row['rate'], 2)."</td>
                           <td>".number_format($row['lunch_fund'], 2)."</td>
                           <td>".number_format($row['transport_fund'], 2)."</td>
                           <td>".number_format($row['insentive_fund'], 2)."</td>
                           <td>".number_format($row['position_fund'], 2)."</td>
                           <td>".number_format($row['late_cut'], 2)."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
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
  <?php include 'includes/position_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(document).ready(function() {
    
    $('#example1').on('click', '.edit', function (e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
    } );
    $('#example1').on('click', '.delete', function (e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
    } );
} );


function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'position_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#posid').val(response.id);
      $('#edit_title').val(response.description);
      $('#edit_branch').val(response.branch_id);
      $('#edit_rate').val(response.rate);
      $('#edit_lunch').val(response.lunch_fund);
      $('#edit_transport').val(response.transport_fund);
      $('#edit_insentive').val(response.insentive_fund);
      $('#edit_position').val(response.position_fund);
      $('#edit_late').val(response.late_cut);
      $('#edit_overtime').val(response.overtime);
      $('#edit_part_rate').val(response.part_rate);
      $('#edit_part_lunch').val(response.part_lunch_fund);
      $('#edit_part_transport').val(response.part_transport_fund);
      $('#edit_part_insentive').val(response.part_insentive_fund);
      $('#edit_part_position').val(response.part_position_fund);
      $('#edit_part_overtime').val(response.part_overtime);
      $('#edit_part_late').val(response.part_late_cut);
      $('#del_posid').val(response.id);
      $('#del_position').html(response.description);
    }
  });
}
</script>
</body>
</html>
