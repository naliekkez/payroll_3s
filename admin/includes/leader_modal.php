<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Leader</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="leader_add.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Username</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="Username" name="username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cpassword" class="col-sm-3 control-label">Confirm Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">

                      <select type="text" class="form-control" id="branch" name="branch" onchange="get_pos_sche()" required>
                        <option val=""> -- Select -- </option>
                        <?php
                          $sql = "SELECT * FROM branch";
                          $query = $conn->query($sql);
                          while($row = $query->fetch_assoc()){
                            echo"<option value='". $row['branch_id']."'>". $row['name'] . "</option>";
                          }
                        ?>
                      </select>
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

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="leader_id"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="leader_edit.php">
            		<input type="hidden" class="leaderid" name="id">
                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>

                    <div class="col-sm-9">
                      <input type="label" class="form-control" id="edit_username" name="username" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="edit_password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cpassword" class="col-sm-3 control-label">Confirm Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">

                      <select type="text" class="form-control" id="edit_branch" name="branch" onchange="get_pos_sche()" required>
                        <option val=""> -- Select -- </option>
                        <?php
                          $sql = "SELECT * FROM branch";
                          $query = $conn->query($sql);
                          while($row = $query->fetch_assoc()){
                            echo"<option value='". $row['branch_id']."'>". $row['name'] . "</option>";
                          }
                        ?>
                      </select>
                    </div>
                </div>
          	</div>
           
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="leader_id"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="leader_delete.php">
            		<input type="hidden" class="leaderid" name="id">
            		<div class="text-center">
	                	<p>DELETE leader</p>
	                	<h2 class="bold del_leader_name"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
