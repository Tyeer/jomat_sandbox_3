        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url(); ?>" class="site_title"><i class="fa fa-paw"></i> <span> Admin Panel</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url(); ?>">View site</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Cars <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url(); ?>add_property">Add</a></li>
                      <li><a href="<?php echo base_url(); ?>admin">View Published cars</a></li>
                      <li><a href="<?php echo base_url(); ?>admin/draft">View Drafts</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-file-text"></i> Requests <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url(); ?>admin/requests">View request</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-file-text"></i> Post <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url(); ?>admin/posts">View posts</a></li>
                      <li><a href="<?php echo base_url(); ?>admin/add_post">add posts</a></li>
                    </ul>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>