<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Create new Payroll</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="payroll_add.php" enctype="multipart/form-data">
          		  <div class="form-group">
                    <label for="branch_list" class="col-sm-3 control-label">Branch list</label>
                    <div class="col-sm-9">
                      <select type="text" class="form-control" id="branch_list" name="branch_list" onchange="get_user_list()" required>
                          <option val=""> -- Select -- </option>
                          <?php
                           $branch = $_SESSION['branch'];
                            $sql = "SELECT * FROM branch where (branch_id = '$branch' OR $branch = '0')";
                           
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                              echo"<option value='". $row['branch_id']."'>". $row['name'] . "</option>";
                            }
                          ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                  	<label for="employee_id" class="col-sm-3 control-label">Employee ID</label>
                    <div class="col-sm-9">
                    	<select type="text" class="form-control" id="employee_id" name="employee_id" onchange="get_user_detail()" required>
                          <option val=""> -- Select -- </option>
                          
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="accoint_number" class="col-sm-3 control-label">Account Number</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="account_number" name="accoint_number" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="startDate_add" class="col-sm-3 control-label">Start Date</label>

                    <div class="col-sm-9"> 
                      <div class="date">
                        <input type="text" class="form-control" id="startDate_add" name="startDate">
                      </div>
                    </div>
                </div>
               <div class="form-group">
                    <label for="endDate_add" class="col-sm-3 control-label">End Date</label>

                    <div class="col-sm-9"> 
                      <div class="date">
                        <input type="text" class="form-control" id="endDate_add" name="endDate">
                      </div>
                    </div>
                </div>

                 <div class="form-group">
                    <label for="bonus" class="col-sm-3 control-label">Bonus</label>

                    <div class="col-sm-9"> 
                      <input type="text" class="form-control" id="bonus" name="bonus">
                      
                    </div>
                </div>

                <div class="form-group">
                  	<label for="uniform_fee" class="col-sm-3 control-label">Uniform Fee</label>

                  	<div class="col-sm-9"> 
                      
                      <input type="text" class="form-control" id="uniform_fee" name="uniform_fee" readonly>
                    
                  	</div>
                </div>
                <div class="form-group">
                    <label for="uniform_fee_cut" class="col-sm-3 control-label">Uniform Fee Cut</label>

                    <div class="col-sm-9"> 
                      
                      <input type="text" class="form-control" id="uniform_fee_cut" name="uniform_fee_cut" >
                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="cash_advance" class="col-sm-3 control-label">Cash Advance</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="cash_advance" name="cash_advance" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cash_advance_cut" class="col-sm-3 control-label">Cash Advance Cut</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="cash_advance_cut" name="cash_advance_cut" >
                    </div>
                </div>
          	</div>

          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


