<?php
 $controller=$this->router->fetch_class();
 $method=$this->router->fetch_method();
 $this->show_filter_form=(isset($_GET['mode']) && $_GET['mode']=='mobile') ? 'display:none;' : '';
 $this->plant_types=unserialize(PLANT_TYPES);
 $modules_access=$this->session->userdata('modules_access');

 if((isset($_GET['mode']) && $_GET['mode']=='mobile'))
 {
 ?>
<style>
.no-records-found { text-align:left !important; }
  </style>
  <?php } ?>
<body >
    <script src="<?php echo base_url(); ?>assets/latest/js/demo-theme.min.js?1692870487"></script>
    <script type="text/javascript">var base_url='<?php echo base_url(); ?>';</script>
    <div class="page">
     
      <!-- Navbar -->
      <header class="navbar navbar-expand-md d-print-none" style="<?php echo $this->show_filter_form;?>" >
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url(); ?>assets/img/logo.jpg" height="50" alt="<?php echo $this->lang->line('site_name'); ?>" title="<?php echo $this->lang->line('site_name'); ?>"  class="navbar-brand-image"/>
            </a>
          </h1>
          <?php
          $hide=0;
          if(!in_array($controller,array('dashboard'))) {
            $hide=1;
          ?>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo $_SESSION['department_name']; ?></div>
                  <div class="mt-1 small text-secondary"><?php echo $_SESSION['first_name']; ?></div>
                </div>
              </a>
            </div>
          </div>
          <?php } ?>
        </div>
      </header>
      <?php
     
      if($hide==1 && $this->show_filter_form!='display:none;') { 
      $my_permits_active=$open_permits_active=$closed_permits_active=$avi_permits_active=$show_all_permits_active=$users_active=$materials_active=$responsible_permits_active='';

            if($controller=='jobs')
            {
                if(in_array($method,array('index','form')))
                $my_permits_active='active';
                else if($method=='open_permits')
                $open_permits_active='active';
                else if($method=='closed_permits')
                $closed_permits_active='active';
                else if($method=='show_all')
                $show_all_permits_active='active';
                else if($method=='responsible')
                $responsible_permits_active='active';
            } else if($controller=='avis') {
                $avi_permits_active='active';
            } else if($controller=='users'){
                $users_active='active';
            } else if($controller=='active'){
                $materials_active='active';
            }
      ?>
      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">
                <?php
                if(in_array($modules_access,array(PERMIT,BOTH))) {

                ?>
                
                <li class="nav-item <?php echo $my_permits_active; ?>">
                  <a class="nav-link" href="<?php echo base_url(); ?>jobs/" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      My Permits
                    </span>
                  </a>
                </li>
                <li class="nav-item <?php echo $responsible_permits_active; ?>">
                  <a class="nav-link" href="<?php echo base_url(); ?>jobs/responsible/" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-address-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" /><path d="M10 16h6" /><path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 8h3" /><path d="M4 12h3" /><path d="M4 16h3" /></svg>
                  </span>
                    <span class="nav-link-title">
                       Responsible Permits
                    </span>
                  </a>
                </li>
                <li class="nav-item <?php echo $show_all_permits_active; ?>">
                  <a class="nav-link" href="<?php echo base_url(); ?>jobs/show_all/" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-address-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" /><path d="M10 16h6" /><path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 8h3" /><path d="M4 12h3" /><path d="M4 16h3" /></svg>
                  </span>
                    <span class="nav-link-title">
                       Dept Permits
                    </span>
                  </a>
                </li>
                <li class="nav-item <?php echo $open_permits_active; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>jobs/open_permits">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Open Permits
                    </span>
                  </a>
                </li>
                <li class="nav-item <?php echo $closed_permits_active; ?>">
                  <a class="nav-link" href="<?php echo base_url(); ?>jobs/closed_permits">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Closed Permits
                    </span>
                  </a>
                </li>           
                <li class="nav-item <?php echo $avi_permits_active; ?>">
                  <a class="nav-link" href="javascript:void(0);" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                    </span>
                    <span class="nav-link-title">
                      AVI
                    </span>
                  </a>
                </li>    
                <?php } else { ?>
                  <li class="nav-item <?php echo $materials_active; ?>">
                  <a class="nav-link" href="<?php echo base_url(); ?>materials">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                    <span class="nav-link-title">
                       Materials
                    </span>
                  </a>
                </li> 
                  
                <?php } ?>
                <li class="nav-item <?php echo $users_active; ?>">
                  <a class="nav-link" href="<?php echo base_url(); ?>users/changepassword">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-air-balloon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 19m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M12 16c3.314 0 6 -4.686 6 -8a6 6 0 1 0 -12 0c0 3.314 2.686 8 6 8z" /><path d="M12 9m-2 0a2 7 0 1 0 4 0a2 7 0 1 0 -4 0" /></svg>
                    <span class="nav-link-title">
                       Change Password
                    </span>
                  </a>
                </li>    
                <li class="nav-item ">
                  <a class="nav-link" href="<?php echo base_url(); ?>users/logout" style="color:red">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                    <span class="nav-link-title">
                       Logout
                    </span>
                  </a>
                </li>     
              </ul>
            </div>
          </div>
        </div>
      </header>
      <?php } ?>