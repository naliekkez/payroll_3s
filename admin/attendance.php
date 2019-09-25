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
        Attendance
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Attendance</li>
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
              <div class="pull-right">
                <form method="POST" class="form-inline" id="payForm">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="month"  id="month" name="month" class="form-control" required>
                     <select type="text" class="form-control" id="branch" name="branch"  required>
                        <option val=""> -- Select -- </option>
                        <?php
                          $branch = $_SESSION['branch'];
                          $sql = "SELECT * FROM branch where branch_id = $branch or $branch = '0'";
                          $query = $conn->query($sql);
                          while($row = $query->fetch_assoc()){
                            echo"<option value='". $row['branch_id']."'>". $row['name'] . "</option>";
                          }
                        ?>
                      </select>
                  </div>
                  <button type="button" class="btn btn-primary btn-sm btn-flat" id="generate"><span class="glyphicon glyphicon-print"></span> SHOW </button>
                </form>
              </div>
            </div>
            <div class="box-body" id="my">
             
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/attendance_modal.php'; ?>
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
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'attendance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#datepicker_edit').val(response.date);
      $('#attendance_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#del_attid').val(response.attid);
      $('#del_employee_name').html(response.firstname+' '+response.lastname);
    }
  });
}


function fill_table(){
  var temp = document.getElementById("month").value;
  var branch = document.getElementById("branch").value;
  console.log(temp);
  var arr = temp.split("-");
  var year = arr[0];
  var month = arr[1];

  handler = function (obj, cell, val) {
                  
                  
                        var id = $(cell).prop('id').split('-');
                        var x = parseInt(id[1]) + 1;
                        var empid = $('#my').jexcel('getValue','A' + x);
                        
                        var day = parseInt(id[0]) - 2;
                        var year_var = year;
                        var month_var = month;
                        var status = $(cell).text();
                       
                        
                        
                        
                        $.ajax({
                          type: 'POST',
                          url: 'update_attendance.php',
                          data: {empid:empid,year:year_var,month:month_var,status:status,day:day,branch:branch},
                      
                          success: function(response){
                            console.log(response);  
                          }
                        });

                  
                    
            };

  $.ajax({
      type: 'POST',
      url: 'get_attendance.php',
      
      data: {month:month,branch:branch,year:year},
     // dataType: 'json',
      success: function(response){
         document.getElementById("my").innerHTML = '';
         console.log(response);
        $('#my').jexcel({
            // Full CSV URL
            data:response,
            onchange: handler,
             // Headers
            colHeaders: ['ID','Nama','status','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
            colWidths: [ 70,120,50,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40  ],
            
        }); 
        
      }
    });

}

       
$('#download').on('click', function () {
    $('#my').jexcel('download');
});

$('#generate').on('click', function () {
    fill_table();
});
</script>
</body>
</html>
