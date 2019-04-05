<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a class="brand-link" href="/">        
		<span class="brand-text font-weight-light"><b><center>ESS Portal</center></b></span>
	</a> <!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image"><img alt="User Image" class="img-circle elevation-2" src="../storage/pic.jpg"></div>
			<div class="info">
				<a class="d-block" href="#">{{ Auth::user()->name }}</a>
			</div>
		</div><!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false" data-widget="treeview" role="menu">
				<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
				@php
					$myprofile = "";
					$createprofile = "";
					$manageusers = "";
					$manageusers_tree = "";
					$esscontent = "";
					$sendannounce = "";
					$managedocs = "";

					if(Request::segment(1) == 'manageuser')
					{
						$manageusers = "menu-open";
						$manageusers_tree = "active";
					}
				@endphp

				<!-- ADMIN -->
							
				<!-- MY PROFILE -->
				
				@if(Session::get("my_profile") != "none")				
				<li class="nav-item has-treeview">
					<a class="nav-link " href="#"><i class="nav-icon fa fa-user-secret"></i>
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
							<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
							<p>System Logs</p></a>
						</li>
					</ul>
				</li>				
				@else								
				@endif
				<!-- END -->
				
				<!-- CREATE PROFILES -->
				@if(Session::get("create_profile") != "none")	
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-user"></i>
					<p>Create Profiles <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link" href="/Account/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create Profile</p></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/Account"><i class="fa fa-circle-o nav-icon"></i>
							<p>Update Profile</p></a>
						</li>
						
					</ul>
				</li>
				@else								
				@endif
				<!-- END -->
				
				<!-- MANAGE USERS -->
				@if(Session::get("manage_users") != "none")	
				<li class="nav-item has-treeview {{$manageusers}}">
					<a class="nav-link {{$manageusers_tree}}" href="#"><i class="nav-icon fa fa-edit"></i>
					<p>Manage Users <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link" href="/manageuser/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create User</p></a>
						</li>
						{{-- <li class="nav-item">
							<a class="nav-link" href="/manageuser/createusertype"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create User Type</p></a>
						</li> --}}
						<li class="nav-item">
							<a class="nav-link" href="/manageuser/manage"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage User Access</p></a>
						</li>								
					</ul>
				</li>
				@else								
				@endif
				<!-- END -->

				<!-- ESS CONTENT -->
				@if(Session::get("ess_content") != "none")	
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
				@else								
				@endif
				<!-- END -->

				<!--SEND ANNOUNCEMENTS  -->
				@if(Session::get("send_announcement") != "none")
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
				@else								
				@endif	
				<!-- END -->

				<!-- DOCS AND TEMPLATES -->
				@if(Session::get("manage_docs") != "none")
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
				@else								
				@endif
				<!-- END -->

				<!-- END ADMIN -->

				<!-- EMPLOYER -->

				<!-- EMPLOYEES ENROLLMENT -->
				@if(Session::get("employee_enrollment") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link " href="#"><i class="nav-icon fa fa-user"></i>
					<p>Employees Enrollment <i class="right fa fa-angle-left"></i></p></a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
							<p>Upload Employee</p></a>                                   
						</li>
						<li class="nav-item">
							<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
							<p>Encode Employee</p></a>
						</li>						
					</ul>
				</li>
				@else								
				@endif
				<!-- END -->

				<!-- PAYROLL MANAGEMENT -->
				@if(Session::get("payroll_management") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link " href="#"><i class="nav-icon fa fa-user"></i>
					<p>Payroll Management <i class="right fa fa-angle-left"></i></p></a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
							<p>Upload Payroll Register</p></a>                                   
						</li>
						<li class="nav-item">
							<a class="nav-link" href=""><i class="fa fa-circle-o nav-icon"></i>
							<p>View Payroll Register</p></a>
						</li>						
					</ul>
				</li>
				@else								
				@endif
				<!-- END -->
				
				@if(Session::get("employer_content") != "none")				
				<!-- EMPLOYER CONTENT -->
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>Employer Content <i class="fa fa-angle-left right"></i></p></a>
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
				@else							
				@endif
				<!-- END -->

				<!-- END EMPLOYER -->

				<!-- EMPLOYEE -->
				
				<!-- MY PAYSLIPS -->
				@if(Session::get("payslips") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>My Payslips</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- MY TIME AND ATTENDANCE -->
				@if(Session::get("t_a") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>My Time and Attendance</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- I CREDIT -->
				@if(Session::get("icredit") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>i-Credit</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- CASH ADVANCE -->
				@if(Session::get("cash_advance") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>Cash Advance</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- PREPAID E WALLET -->
				@if(Session::get("e_wallet") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>Prepaid E-Wallet</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- FINANCIAL CALENDAR -->
				@if(Session::get("financial_calendar") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>Financial Calendar</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- FINANCIAL TIPS -->
				@if(Session::get("financial_tips") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link" href="#"><i class="nav-icon fa fa-table"></i>
					<p>Financial Tips</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- END EMPLOYEE -->

			</ul>           
		</nav><!-- /.sidebar-menu -->
	</div><!-- /.sidebar -->
</aside><!-- Content Wrapper. Contains page content -->