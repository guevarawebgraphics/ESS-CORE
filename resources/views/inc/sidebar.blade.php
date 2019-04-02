<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a class="brand-link" href="index3.html">        
                <span class="brand-text font-weight-light"><b><center>ESS Portal</center></b></span>
            </a> <!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image"><img alt="User Image" class="img-circle elevation-2" src="storage/pic.jpg"></div>
					<div class="info">
						<a class="d-block" href="#">{{ Auth::user()->name }}</a>
					</div>
				</div><!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false" data-widget="treeview" role="menu">
						<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                        <!-- MY PROFILE -->
						<li class="nav-item has-treeview">
							<a class="nav-link active" href="#"><i class="nav-icon fa fa-user-secret"></i>
							<p>My Profile <i class="right fa fa-angle-left"></i></p></a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
									<p>Settings</p></a>                                   
								</li>
								<li class="nav-item">
									<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
									<p>Change Password</p></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="./index3.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>System Logs</p></a>
								</li>
							</ul>
						</li>
                        <!-- END -->
						<!-- CREATE PROFILES -->
						<li class="nav-item has-treeview">
							<a class="nav-link" href="#"><i class="nav-icon fa fa-user"></i>
							<p>Create Profiles <i class="fa fa-angle-left right"></i></p></a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
									<p>Create Profile</p></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
									<p>Update Profile</p></a>
								</li>
								
							</ul>
						</li>
                        <!-- END -->
                        <!-- MANAGE USERS -->
						<li class="nav-item has-treeview">
							<a class="nav-link" href="#"><i class="nav-icon fa fa-edit"></i>
							<p>Manage Users <i class="fa fa-angle-left right"></i></p></a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
									<p>Create Users</p></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
									<p>Manage Users Access</p></a>
								</li>								
							</ul>
						</li>
                        <!-- END -->
                        <!-- ESS CONTENT -->
						<li class="nav-item has-treeview">
							<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
							<p>ESS Content <i class="fa fa-angle-left right"></i></p></a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link" href="pages/tables/simple.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>Create Content</p></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="pages/tables/data.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>Manage Content</p></a>
								</li>
							</ul>
						</li>	
                        <!-- END -->
                        <!--SEND ANNOUNCEMENTS  -->
                        <li class="nav-item has-treeview">
							<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
							<p>Send Announcements <i class="fa fa-angle-left right"></i></p></a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link" href="pages/tables/simple.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>Create Announcements</p></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="pages/tables/data.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>Manage Announcements</p></a>
								</li>
							</ul>
						</li>		
                        <!-- END -->
                        <!-- DOCS AND TEMPLATES -->
                        <li class="nav-item has-treeview">
							<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
							<p>Manage Docs & Templates <i class="fa fa-angle-left right"></i></p></a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link" href="pages/tables/simple.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>Create</p></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="pages/tables/data.html"><i class="fa fa-circle-o nav-icon"></i>
									<p>Manage</p></a>
								</li>
							</ul>
						</li>	
                        <!-- END -->

					</ul>           
				</nav><!-- /.sidebar-menu -->
			</div><!-- /.sidebar -->
		</aside><!-- Content Wrapper. Contains page content -->