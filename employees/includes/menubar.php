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
      
        <li><a href="home.php"><i class="fa fa-files-o"></i> <span>Payroll</span></a></li>
        <li><a href="cashadvance_request.php"><i class="fa fa-files-o"></i> <span>Cash Advance Request</span></a></li>
        <li><a href="cashadvance_authorized.php"><i class="fa fa-files-o"></i> <span>Cash Advance Response</span></a></li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>