        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="<?php echo base_url('application/assets/img/avatar_1.jpg'); ?>" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h6"><?php echo $this->session->userdata('u_full_name'); ?></h1>
              <p><?php echo $this->session->userdata('designation'); ?></p>
            </div>
          </div>

          <!-- Sidebar Navidation Menus-->
          <span class="heading">Main</span>
          <ul class="list-unstyled">
            <li><a href="<?php echo site_url('admin_dashboard'); ?>"> <i class="icon-home"></i>Home </a></li>
            <li><a href="<?php echo site_url('students'); ?>"> <i class="fa fa-user-o"></i>Student </a></li>
            <!-- <li><a href="<?php //echo site_url('student_import_registration'); ?>"> <i class="fa fa-upload" aria-hidden="true"></i> Import Students </a></li> -->
            <li><a href="<?php echo site_url('register_student'); ?>"> <i class="fa fa-pencil-square-o"></i>Register Student </a></li>
          </ul>
        </nav>