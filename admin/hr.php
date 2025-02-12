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
        HR List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>HR</li>
        <li class="active">HR List</li>
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
                  <th>Name</th>
                  <th>Username</th>
                  <th>Created On</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * from admin WHERE privileges='1'";
                    $query = $conn->query($sql);
                    $i = 1;
                    while($row = $query->fetch_assoc()){

                      ?>
                        <tr>
                         <td><?php echo $i++ ?></td> 
                         <td><?php echo $row['firstname'] . " " . $row['lastname'] ?></td> 
                         <td><?php echo $row['username'] ?></td> 
                         <td><?php echo $row['created_on'] ?></td> 
                         <td>
                            <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i> Delete</button>
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
  <?php include 'includes/hr_modal.php'; ?>
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
    $('#example1').on('click', '.photo', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
    } );
} );
function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'hr_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.hrid').val(response.id);
      $('.hr_id').html(response.id);
      $('.del_hr_name').html(response.firstname+' '+response.lastname);
      $('#hr_name').html(response.firstname+' '+response.lastname);
      $('#hr_username').html(response.username);
      $('#edit_firstname').val(response.firstname);
      $('#edit_username').val(response.username);
      $('#edit_lastname').val(response.lastname);
      
    }
  });
}

</script>
</body>
</html>
