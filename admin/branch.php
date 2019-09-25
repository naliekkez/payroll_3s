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
        Branch List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Branch</li>
        <li class="active">Branch List</li>
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
                  <th>No</th>
                  <th>Branch Name</th>
                  <th>Status</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $branch = $_SESSION['branch'];
                    $sql = "SELECT * from branch";
                    $query = $conn->query($sql);
                    $i = 1;
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php if($row['status'] == 0) echo "Active";
                                    else echo "Not Active" ;
                          ?></td>
                          
  
                                                  

                          </td>
                          <td>
                            <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $row['branch_id']; ?>"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['branch_id']; ?>"><i class="fa fa-edit"></i> Change Status</button>
                          </td>
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
  <?php include 'includes/branch_modal.php'; ?>
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
    url: 'branch_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){

      $('.bid').val(response.branch_id);
      $('.bstatus').val(response.status);
      $('.branch_id').html(response.branch_id);
      $('.branch_name').html(response.name);
      $('#branch_name').html(response.name);
      $('#edit_branch_name').val(response.name);
      $('#datepicker_edit').val(response.day_month);
    }
  });
}



</script>
</body>
</html>
