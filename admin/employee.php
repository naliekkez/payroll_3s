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
        Employee List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Employee List</li>
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
            <?php if($_SESSION['privileges'] == 1 OR $_SESSION['privileges'] == 0){ ?>
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
             <?php }?>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Employee ID</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Branch</th>
                  <th>Position</th>
                  <th>Member Since</th>
                  <th>Uniform Fee</th>
                  <th>BPJS</th>
                  <?php if($_SESSION['privileges'] == 1 OR $_SESSION['privileges'] == 0){ ?>
                  <th>Tools</th>

                  <?php }?>
                </thead>
                <tbody>
                  <?php
                    $branch = $_SESSION['branch'];
                    $sql = "SELECT *, employees.id AS empid, branch.name as bname FROM employees, position,branch WHERE branch.branch_id=employees.branch_id AND position.id=employees.position_id AND (employees.branch_id = '$branch' or '0' = '$branch')";
                   
                    $query = $conn->query($sql);

                    while($row = $query->fetch_assoc()){

                      ?>
                        <tr>
                          <td><?php echo $row['employee_id']; ?></td>
                          <td><img src="<?php echo (!empty($row['photo']))? '../images/'.$row['photo']:'../images/profile.jpg'; ?>" width="30px" height="30px"><?php if($_SESSION['privileges'] == 1 OR $_SESSION['privileges'] == 0){ ?>
                           <a href="#edit_photo" data-toggle="modal" class="pull-right photo" data-id="<?php echo $row['empid']; ?>"><span class="fa fa-edit"></span></a>
                           <?php }?>
                         </td>
                          <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
                          <td><?php echo $row['bname']; ?></td>
                          <td><?php echo $row['description']; ?></td>
                          <td><?php echo date('M d, Y', strtotime($row['created_on'])) ?></td>
                          <td><?php if($row['uniform_fee'] == 0) {
                                           echo "Paid";
                                    }
                                    else{
                                     
                                      echo "Rp. " . $row['uniform_fee'] . ",00";
                                    
                                    }
                                      ?>
                                                  

                          </td>
                          <td>
                            <?php echo "Rp. " . $row['bpjs'] . ",00" ?>

                          </td>

                          <?php if($_SESSION['privileges'] == 1 OR $_SESSION['privileges'] == 0){ ?>
                          <td>
                            <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-trash"></i> Delete</button>
                          </td>
                           <?php }?>
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
    url: 'employee_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.empid').val(response.empid);
      $('.employee_id').html(response.employee_id);
      $('.del_employee_name').html(response.firstname+' '+response.lastname);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#edit_bank_account_number').val(response.bank_account_number);
      $('#edit_uni_fee').val(response.uniform_fee);
      $('#datepicker_edit').val(response.birthdate);
      $('#edit_contact').val(response.contact_info);
      $('#edit_bpjs').val(response.bpjs);
      $('#gender_val').val(response.gender).html(response.gender);
      $('#position_val').val(response.position_id).html(response.description);
      $('#schedule_val').val(response.schedule_id).html(response.time_in+' - '+response.time_out);
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
    
}

function get_pos_sche_edit() { // Call to ajax function
    var branch = $('#edit_branch').val();
    var BdataString = "branch="+branch;
    console.log(BdataString);
    $.ajax({
        type: "POST",
        url: "includes/getPos.php", // Name of the php files
        data: BdataString,
        success: function(html)
        {
            $("#edit_position").html(html);
        }
    });
    
}
</script>
</body>
</html>
