<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo base_url();?>assets/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url();?>assets/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?php echo base_url('/page/profil'); ?>" class="d-block"><?= $this->session->userdata('name') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="<?php echo base_url('/home'); ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Kontrol Akses Pengguna
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php
              if(in_array('user-list', permissions($this->session->userdata())))
              {
                ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('/user'); ?>" class="nav-link">
                    <p>
                      Users
                    </p>
                  </a>
                </li>
              <?php } ?>
              <?php
              if(in_array('permissions-list', permissions($this->session->userdata())))
              {
                ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('/permission'); ?>" class="nav-link">
                    <p>
                      Permissions
                    </p>
                  </a>
                </li>
              <?php } ?>
              <?php
              if(in_array('role-list', permissions($this->session->userdata())))
              {
                ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('/role'); ?>" class="nav-link">
                    <p>
                      Role
                    </p>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Masterdata
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('/kriteria'); ?>" class="nav-link">
                  <p>
                    Kriteria
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('/subkriteria'); ?>" class="nav-link">
                  <p>
                    Sub Kriteria
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('/importdata'); ?>" class="nav-link">
                  <p>
                    Import ke Database
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('auth/logout'); ?>" class="nav-link">
              <i class="nav-icon fas fa-times"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>