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
        Leader List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>HR</li>
        <li class="active">Leader List</li>
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
                  <th>Branch Name</th>
                  <th>Created On</th>
                  <th>Last Edited By</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * from admin,branch WHERE privileges='2' and branch.branch_id = admin.branch_id";
                    
                    $query = $conn->query($sql);
                    $i = 1;
                    while($row = $query->fetch_assoc()){

                      ?>
                        <tr>
                         <td><?php echo $i++ ?></td> 
                         <td><?php echo $row['firstname'] . " " . $row['lastname'] ?></td> 
                         <td><?php echo $row['username'] ?></td>
                         <td><?php echo $row['name'] ?></td>  
                         <td><?php echo $row['created_on'] ?></td> 
                         <td><?php echo $row['last_edited'] ?></td> 
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
  <?php include 'includes/leader_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.photo').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'hr_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.hrid').val(response.id);
      $('.hr_id').html(response.id);
      $('.del_leader_name').html(response.firstname+' '+response.lastname);
      $('#leader_name').html(response.firstname+' '+response.lastname);
      $('#leader_username').html(response.username);
      $('#edit_firstname').val(response.firstname);
      $('#edit_username').val(response.username);
      $('#edit_branch').val(response.branch_id).html(response.name);
      $('#edit_lastname').val(response.lastname);
      
    }
  });
}
function get_pos_sche() { // Call to ajax function
    var branch = $('#branch').val();
    var BdataString = "branch="+branch;
    console.log(BdataString);
    $.ajax({
        type: "POST",
        url: "includes/getPos.php", // Name of the php files
        data: BdataString,
        success: function(html)
        {
            $("#position").html(html);
        }
    });
    
    $.ajax({
        type: "POST",
        url: "includes/getSche.php", // Name of the php files
        data: BdataString,
        success: function(html)
        {
            $("#schedule").html(html);
        }
    });
}
</script>
</body>
</html>
