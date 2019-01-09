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
            <li><a href="<?php echo site_url('admin_users'); ?>"> <i class="icon-user"></i>Users </a></li>
            <li><a href="<?php echo site_url('admin_security') ?>"> <i class="fa fa-cog"></i>Security Config </a></li>
            <li><a href="<?php echo site_url('history'); ?>"> <i class="fa fa-history"></i>History Logs</a></li>
          </ul>

          <ul class="list-unstyled">
            <span class="heading"><i class="fa fa-cogs" aria-hidden="true"></i> Config Items</span>
            <li><a href="<?php echo site_url('batch_year') ?>"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>Batch Year </a></li>
            <li><a href="<?php echo site_url('vocational_programs') ?>"> <i class="icon-list" aria-hidden="true"></i>Vocational Programs </a></li>
            <li><a href="<?php echo site_url('rooms') ?>"> <i class="fa fa-university" aria-hidden="true"></i>Rooms </a></li>
            <li><a href="<?php echo site_url('subjects') ?>"> <i class="icon-list-1" aria-hidden="true"></i>Subjects </a></li>
            <li><a href="<?php echo site_url('company') ?>"> <i class="icon-home" aria-hidden="true"></i>Company </a></li>
          </ul>

          <ul class="list-unstyled">
            <span class="heading">About me</span>
            <li><a href="<?php echo site_url('user_profile'); ?>"> <i class="icon-user"></i>Profile </a></li>
          </ul>
        </nav>