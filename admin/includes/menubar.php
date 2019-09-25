<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
          <a><i class="fa fa-circle text-success"></i>Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      
      <ul class="sidebar-menu" data-widget="tree">
      <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
       <?php if( $user['privileges'] == '0'){?>
        
       
        <li class="header">SUPER ADMIN</li>
        
        <li><a href="position.php"><i class="fa fa-suitcase"></i>Positions & Salary Component</a></li>
        <li><a href="hr.php"><i class="fa fa-users"></i>Assign HR</a></li>
      <?php }?>
        <?php if($user['privileges'] == '1' OR $user['privileges'] == '0'){?>
        
       
        <li class="header">HR</li>
        <li><a href="leader.php"><i class="fa fa-users"></i>Assign Leader</a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Employees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="employee.php"><i class="fa fa-circle-o"></i>Employee List</a></li>

            
            <li><a href="overtime.php"><i class="fa fa-circle-o"></i>Overtime</a></li>
            <li><a href="cashadvance_incoming.php"><i class="fa fa-circle-o"></i>Incoming Cash Advance request</a></li>
            <li><a href="cashadvance_authorized.php"><i class="fa fa-circle-o"></i>Authorized Cash Advance</a></li>
            <li><a href="history.php"><i class="fa fa-circle-o"></i>History</a></li>
            <li><a href="exchange.php"><i class="fa fa-circle-o"></i>Employee Exchange Request</a></li>
            <li><a href="exchange_incoming.php"><i class="fa fa-circle-o"></i>Incoming Exchange Request</a></li>
            
            
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-university"></i>
            <span>Branch</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="branch.php"><i class="fa fa-circle-o"></i>Branch List</a></li>
            <li><a href="schedule.php"><i class="fa fa-circle-o"></i>Schedules</a></li>
            <li><a href="attendance.php"><i class="fa fa-circle-o"></i> <span>Attendance</span></a></li>
            
          </ul>
        </li>
       
      <?php }?>
      <?php if($user['privileges'] == '2'){?>
        <li class="header">BRANCH LEADER</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Employees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="employee.php"><i class="fa fa-circle-o"></i>Employee List</a></li>
            <li><a href="overtime.php"><i class="fa fa-circle-o"></i>Overtime</a></li>
            <li><a href="cashadvance.php"><i class="fa fa-circle-o"></i>Cash Advance</a></li>
            
            <li><a href="history.php"><i class="fa fa-circle-o"></i>History</a></li>
            <li><a href="exchange.php"><i class="fa fa-circle-o"></i>Employee Exchange Request</a></li>
            <li><a href="exchange_incoming.php"><i class="fa fa-circle-o"></i>Incoming Exchange Request</a></li>

            
            
          </ul>
        </li>
        <li><a href="attendance.php"><i class="fa fa-calendar"></i> <span>Attendance</span></a></li>
         <?php }?>
        
        <li class="header">PRINTABLES</li>
        <li><a href="payroll.php"><i class="fa fa-files-o"></i> <span>Payslip</span></a></li>
        <li><a href="payslip.php"><i class="fa fa-files-o"></i> <span>Payroll</span></a></li>
        <li><a href="archive.php"><i class="fa fa-files-o"></i> <span>Monthly Archives</span></a></li>
        <li><a href="schedule_employee.php"><i class="fa fa-clock-o"></i> <span>Schedule</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>