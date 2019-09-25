<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Position</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="position_add.php">
              <div class="form-group">
                    <label for="branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">
                      <select type="text" class="form-control" id="branch" name="branch" required>
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
                <h4 class="modal-title"><b>Full Time</b></h4>
          		  <div class="form-group">
                  	<label for="title" class="col-sm-3 control-label">Position Title</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="title" name="title" required>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Rate per Day</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="rate" name="rate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lunch" class="col-sm-3 control-label">Lunch Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="lunch" name="lunch" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="transport" class="col-sm-3 control-label">Transport Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="transport" name="transport" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="insentive" class="col-sm-3 control-label">Insentive Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="insentive" name="insentive" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Position Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="late" class="col-sm-3 control-label">Late Cut</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="late" name="late" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="overtime" class="col-sm-3 control-label">Overtime</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="overtime" name="overtime" required>
                    </div>
                </div>
                <h4 class="modal-title"><b>Part time</b></h4>

                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Rate per Day</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_rate" name="part_rate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lunch" class="col-sm-3 control-label">Lunch Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_lunch" name="part_lunch" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="transport" class="col-sm-3 control-label">Transport Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_transport" name="part_transport" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="insentive" class="col-sm-3 control-label">Insentive Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_insentive" name="part_insentive" required>
                    </div>
                </div>
                 
                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Position Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_position" name="part_position" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="late" class="col-sm-3 control-label">Late Cut</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_late" name="part_late" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="overtime" class="col-sm-3 control-label">Overtime</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="part_overtime" name="part_overtime" required>
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
            	<h4 class="modal-title"><b>Update Position</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="position_edit.php">
            		<input type="hidden" id="posid" name="id">
                <div class="form-group">
                    <label for="edit_branch" class="col-sm-3 control-label">Branch</label>

                    <div class="col-sm-9">
                      <select type="text" class="form-control" id="edit_branch" name="branch" required>
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

                <h4 class="modal-title"><b>Full Time</b></h4>
                <div class="form-group">
                    <label for="edit_title" class="col-sm-3 control-label">Position Title</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_title" name="title">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_rate" class="col-sm-3 control-label">Rate per Day</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_rate" name="rate">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_lunch" class="col-sm-3 control-label">Lunch Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_lunch" name="lunch">
                    </div>
                </div>
               
                <div class="form-group">
                    <label for="edit_transport" class="col-sm-3 control-label">Transport Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_transport" name="transport">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_insentive" class="col-sm-3 control-label">Insentive Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_insentive" name="insentive">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_position" class="col-sm-3 control-label">Position Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_position" name="position">
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_late_cut" class="col-sm-3 control-label">Late Cut</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_late" name="late">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_overtime" class="col-sm-3 control-label">Overtime</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_overtime" name="overtime">
                    </div>
                </div>
                <h4 class="modal-title"><b>Part time</b></h4>

                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Rate per Day</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_rate" name="part_rate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lunch" class="col-sm-3 control-label">Lunch Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_lunch" name="part_lunch" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="transport" class="col-sm-3 control-label">Transport Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_transport" name="part_transport" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="insentive" class="col-sm-3 control-label">Insentive Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_insentive" name="part_insentive" required>
                    </div>
                </div>
                 
                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Position Fund</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_position" name="part_position" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="late" class="col-sm-3 control-label">Late Cut</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_late" name="part_late" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_part_overtime" class="col-sm-3 control-label">Overtime</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_part_overtime" name="part_overtime" required>
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
            	<h4 class="modal-title"><b>Deleting...</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="position_delete.php">
            		<input type="hidden" id="del_posid" name="id">
            		<div class="text-center">
	                	<p>DELETE POSITION</p>
	                	<h2 id="del_position" class="bold"></h2>
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


     