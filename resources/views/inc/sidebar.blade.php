<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a class="brand-link" href="/">  
		<img src="/storage/ess.png" alt="AdminLTE Logo" class="img-circle" style="height: 45px">      
		<span class="brand-text font-weight-light">ESS PORTAL</span>
	</a> <!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			{{-- <div class="image" id="profile_picture"><img alt="User Image" class="img-circle elevation-2" src="/storage/pic.jpg"></div> --}}
		<div class="image" id="profile_picture"><img alt="User Image" id="user_profile_picture" class="img-circle elevation-2 " style="height: 33px; width: 33px;"></div>
			<div class="info">
				<a class="d-block">{{ Auth::user()->name }}</a>
			</div>
		</div><!-- Sidebar Menu -->
		{{-- {{Session::get("employer_id")}} --}}
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false" data-widget="treeview" role="menu">
				<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
				@php
					//profile
					$myprofile = "";
					$myprofile_tree = "";
					$settings = "";
					$changepass = "";
					$s_logs = "";
					//create profile
					$createprofile = "";
					$createprofile_tree = "";
					$create_p = "";
					$update_p = "";
					//manage users
					$manageusers = "";
					$manageusers_tree = "";
					$create = "";
					$manage = "";
					//system notif
					$systemnotifications = "";
					$systemnotifications_tree = "";
					$create_notif = "";
					$manage_notif = "";
					//announcement
					$sendannounce = "";
					$sendannounce_tree = "";
					$create_sendannounce = "";
					$manage_sendannounce = "";
					//manage documents
					$managedocs = "";
					$managedocs_tree = "";
					$create_managedocs = "";
					$manage_managedocs = "";
					//employercontent
					$employercontent = "";
					$employercontent_tree = "";
					$create_employercontent = "";
					$manage_employercontent = "";
					//employee enrollment
					$employee_enrollment = "";
					$employee_enrollment_tree = "";
					$upload_employee_enrollment = "";
					$encode_employee_enrollment = "";
					//payroll management
					$payroll_management = "";
					$payroll_management_tree = "";
					$upload_payrollmanagement = "";
					$view_payrollmanagement = "";
					//payslips
					$payslips_index = "";
					//tna
					$tna_index = "";
					//icredit
					$icredit_index = "";
					//cash advance
					$cashadvance_index = "";
					//ewallet
					$ewallet_index = "";
					//financial calendar
					$financialcalendar_index = "";
					//financial tips
					$financialtips_index = "";


					if(Request::segment(1) == 'myprofile')
					{
						$myprofile = "menu-open";
						$myprofile_tree = "active";
						if(Request::segment(2) == 'settings')
						{
							$settings = 'active';
						}
						if(Request::segment(2) == 'changepassword')
						{
							$changepass = 'active';
						}	
						if(Request::segment(2) == 'systemlogs')
						{
							$s_logs = 'active';
						}						
					}
					else if(Request::segment(1) == 'Account')
					{
						$createprofile = "menu-open";
						$createprofile_tree = "active";	
						if(Request::segment(2) == 'create')
						{
							$create_p = "active";
						}
						if(Request::segment(2) == '')
						{
							$update_p = "active";
						}					
					}
					else if(Request::segment(1) == 'manageuser')
					{
						$manageusers = "menu-open";
						$manageusers_tree = "active";
						if(Request::segment(2) == 'create')
						{
							$create = "active";
						}
						if(Request::segment(2) == 'manage')
						{
							$manage = "active";
						}					
					}
					else if(Request::segment(1) == 'Notification')
					{
						$systemnotifications = "menu-open";
						$systemnotifications_tree = "active";
						$manage_notif = "active";					
					}
					else if(Request::segment(1) == 'Announcement')
					{
						$sendannounce = "menu-open";
						$sendannounce_tree = "active";					
						$manage_sendannounce = "active";										
					}
					else if(Request::segment(1) == 'Template')
					{
						$managedocs = "menu-open";
						$managedocs_tree = "active";
						
						$manage_managedocs = "active";
											
					}	
					else if(Request::segment(1) == 'enrollemployee')
					{
						$employee_enrollment = "menu-open";
						$employee_enrollment_tree = "active";
						if(Request::segment(2) == 'upload')
						{
							$upload_employee_enrollment = "active";
						}
						if(Request::segment(2) == '' || Request::segment(2) == 'encode')
						{
							$encode_employee_enrollment = "active";
						}					
					}
					else if(Request::segment(1) == 'employercontent')
					{
						$employercontent = "menu-open";
						$employercontent_tree = "active";
						if(Request::segment(2) == 'create')
						{
							$create_employercontent = "active";
						}
						if(Request::segment(2) == 'manage')
						{
							$manage_employercontent = "active";
						}					
					}	
					else if(Request::segment(1) == 'payrollmanagement')
					{
						$payroll_management = "menu-open";
						$payroll_management_tree = "active";
						if(Request::segment(2) == 'upload')
						{
							$upload_payrollmanagement = "active";
						}
						if(Request::segment(2) == 'view')
						{
							$view_payrollmanagement = "active";
						}					
					}	
					else if(Request::segment(1) == 'payslips')
					{
						$payslips_index = "active";						
					}
					else if(Request::segment(1) == 'timeattendance')
					{
						$tna_index = "active";						
					}
					else if(Request::segment(1) == 'icredit')
					{
						$icredit_index = "active";						
					}
					else if(Request::segment(1) == 'cashadvance')
					{
						$cashadvance_index = "active";						
					}
					else if(Request::segment(1) == 'ewallet')
					{
						$ewallet_index = "active";						
					}
					else if(Request::segment(1) == 'financialcalendar')
					{
						$financialcalendar_index = "active";						
					}
					else if(Request::segment(1) == 'financialtips')
					{
						$financialtips_index = "active";						
					}									
					
				@endphp

				<!-- ADMIN -->
							
				<!-- MY PROFILE -->
				
				@if(Session::get("my_profile") != "none")				
				<li class="nav-item has-treeview {{$myprofile}}">
					<a class="nav-link {{$myprofile_tree}}" href="#"><i class="nav-icon fa fa-user-secret"></i>
					<p>My Profile <i class="right fa fa-angle-left"></i></p></a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link {{$settings}}" href="/myprofile/settings"><i class="fa fa-circle-o nav-icon"></i>
							<p>Settings</p></a>                                   
						</li>
						<li class="nav-item">
							<a class="nav-link {{$changepass}}" href="/myprofile/changepassword"><i class="fa fa-circle-o nav-icon"></i>
							<p>Change Password</p></a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{$s_logs}}" href="/myprofile/systemlogs"><i class="fa fa-circle-o nav-icon"></i>
							<p>System Logs</p></a>
						</li>
					</ul>
				</li>				
				@else								
				@endif
				<!-- END -->
				
				<!-- CREATE PROFILES -->
				@if(Session::get("create_profile") != "none")	
				<li class="nav-item has-treeview {{$createprofile}}">
					<a class="nav-link {{$createprofile_tree}}" href="#"><i class="nav-icon fa fa-user"></i>
					<p>Create Profiles <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link {{$create_p}}" href="/Account/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create Profile</p></a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{$update_p}}" href="/Account"><i class="fa fa-circle-o nav-icon"></i>
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
							<a class="nav-link {{$create}}" href="/manageuser/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create User</p></a>
						</li>
						@if(Session::get('employer_id') == "admin")
							<li class="nav-item">
								<a class="nav-link {{$manage}}" href="/manageuser/manage"><i class="fa fa-circle-o nav-icon"></i>
								<p>Manage User Access</p></a>
							</li>
						@else
						@endif								
					</ul>
				</li>
				@else								
				@endif
				<!-- END -->

				<!-- END ADMIN -->

				<!-- EMPLOYER -->

				<!-- EMPLOYEES ENROLLMENT -->
				@if(Session::get("employee_enrollment") != "none")
				<li class="nav-item has-treeview {{$employee_enrollment}}">
					<a class="nav-link {{$employee_enrollment_tree}}" href="#"><i class="nav-icon fa fa-user"></i>
					<p>Employees Enrollment <i class="right fa fa-angle-left"></i></p></a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a class="nav-link {{$upload_employee_enrollment}}" href="/enrollemployee/upload"><i class="fa fa-circle-o nav-icon"></i>
							<p>Upload Employee</p></a>                                   
						</li> --}}
						<li class="nav-item">
							<a class="nav-link {{$encode_employee_enrollment}}" href="/enrollemployee"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage Employee</p></a>
						</li>						
					</ul>
				</li>
				@else								
				@endif
				<!-- END -->

				<!-- PAYROLL MANAGEMENT -->
				@if(Session::get("payroll_management") != "none")
				<li class="nav-item has-treeview {{$payroll_management}}">
					<a class="nav-link {{$payroll_management_tree}}" href="#"><i class="nav-icon fa fa-user"></i>
					<p>Payroll Management <i class="right fa fa-angle-left"></i></p></a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a class="nav-link {{$upload_payrollmanagement}}" href="/payrollmanagement/upload"><i class="fa fa-circle-o nav-icon"></i>
							<p>Upload Payroll Register</p></a>                                   
						</li> --}}
						<li class="nav-item">
							<a class="nav-link {{$view_payrollmanagement}}" href="/payrollmanagement/view"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage Payroll Register</p></a>
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
					<a class="nav-link {{$payslips_index}}" href="/payslips"><i class="nav-icon fa fa-sticky-note"></i>
					<p>My Payslips</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- MY TIME AND ATTENDANCE -->
				@if(Session::get("t_a") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link {{$tna_index}}" href="/timeattendance"><i class="nav-icon fa fa-calendar-o"></i>
					<p>My Time and Attendance</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->
				
				<!-- I CREDIT -->
				@if(Session::get("icredit") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link {{$icredit_index}}" href="/icredit"><i class="nav-icon fa fa-credit-card"></i>
					<p>i-Credit</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- CASH ADVANCE -->
				@if(Session::get("cash_advance") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link {{$cashadvance_index}}" href="/cashadvance"><i class="nav-icon fa fa-money"></i>
					<p>Cash Advance</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- PREPAID E WALLET -->
				@if(Session::get("e_wallet") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link {{$ewallet_index}}" href="/ewallet"><i class="nav-icon fa fa-industry"></i>
					<p>Prepaid E-Wallet</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- FINANCIAL CALENDAR -->
				@if(Session::get("financial_calendar") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link {{$financialcalendar_index}}" href="/financialcalendar"><i class="nav-icon fa fa-calendar-o"></i>
					<p>Financial Calendar</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- FINANCIAL TIPS -->
				@if(Session::get("financial_tips") != "none")
				<li class="nav-item has-treeview">
					<a class="nav-link {{$financialtips_index}}" href="/financialtips"><i class="nav-icon fa fa-table"></i>
					<p>Financial Tips</p></a>					
				</li>	
				@else							
				@endif
				<!-- END  -->

				<!-- END EMPLOYEE -->

				@if(Session::get("employer_content") != "none")				
				<!-- EMPLOYER CONTENT -->
				<li class="nav-item has-treeview {{$employercontent}}">
					<a class="nav-link {{$employercontent_tree}}" href="#"><i class="nav-icon fa fa-table"></i>
					<p>Employer Content <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a class="nav-link {{$create_employercontent}}" href="/employercontent/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create Content</p></a>
						</li> --}}
						<li class="nav-item">
							<a class="nav-link {{$manage_employercontent}}" href="/employercontent/manage"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage Content</p></a>
						</li>
					</ul>
				</li>					
				@else							
				@endif
				<!-- END -->

				<!-- NOTIFICATION -->
				@if(Session::get("system_notifications") != "none")	
				<li class="nav-item has-treeview {{$systemnotifications}}">
					<a class="nav-link {{$systemnotifications_tree}}" href="#"><i class="nav-icon fa fa-bell"></i>
					<p>System Notifications <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a class="nav-link {{$create_notif}}" href="/systemnotifications/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create Notifications</p></a>
						</li> --}}
						<li class="nav-item">
							<a class="nav-link {{$create_notif}}" href="/Notification"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage Notifications</p></a>
						</li>
					</ul>
				</li>	
				@else								
				@endif
				<!-- END -->

				<!--SEND ANNOUNCEMENTS  -->
				@if(auth()->user()->user_type_id != 4)
				@if(Session::get("send_announcement") != "none")
				<li class="nav-item has-treeview {{$sendannounce}}">
					<a class="nav-link {{$sendannounce_tree}}" href="#"><i class="nav-icon fa fa-bullhorn"></i>
					<p>Send Announcements <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a class="nav-link {{$create_sendannounce}}" href="/sendannouncements/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create Announcements</p></a>
						</li> --}}
						<li class="nav-item">
							<a class="nav-link {{$create_sendannounce}}" href="/Announcement"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage Announcements</p></a>
						</li>
					</ul>
				</li>	
				@else								
				@endif
				@endif	
				<!-- END -->

				<!-- DOCS AND TEMPLATES -->
				@if(Session::get("manage_docs") != "none")
				<li class="nav-item has-treeview {{$managedocs}}">
					<a class="nav-link {{$managedocs_tree}}" href="#"><i class="nav-icon fa fa-file"></i>
					<p>Manage Docs & Templates <i class="fa fa-angle-left right"></i></p></a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a class="nav-link {{$create_managedocs}}" href="/managedocs/create"><i class="fa fa-circle-o nav-icon"></i>
							<p>Create</p></a>
						</li> --}}
						<li class="nav-item">
							<a class="nav-link {{$create_managedocs}}" href="/Template"><i class="fa fa-circle-o nav-icon"></i>
							<p>Manage Template</p></a>
						</li>
					</ul>
				</li>	
				@else								
				@endif
				<!-- END -->


			</ul>           
		</nav><!-- /.sidebar-menu -->
	</div><!-- /.sidebar -->
</aside><!-- Content Wrapper. Contains page content -->

<!-- Modal For Upload Profile Picture-->
<div class="modal fade" id="upload_profile_picture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Upload</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form id="upload_image" runat="server">
			  @csrf
			  <div class="col-md-4 offset-md-4 mb-3">
					<img class="img-thumbnail" id="image_preview" alt="your image" />
			  </div>
			<div class="col-md-12">
                            
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="fa fa-folder input-group-text"></span>
					</div>
					<div class="custom-file"> 
						<input type="hidden" id="data_to_do" value="">
						<input type="file" class="custom-file-input" id="profile_picture" name="profile_picture" multiple onchange="processSelectedFilesProfileImage(this)" >
						<label class="custom-file-label" for="validatedCustomFile" id="profile_image_filename">Choose file...</label>
					</div>
				</div>
					
			</div>
		  
		</div>
		<div class="modal-footer">
		  {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
		  <button type="submit" class="btn btn-primary" data-image="empty" id="Upload"><span><i class="fa fa-upload"></i></span> Upload</button>
		</div>
		</form>
	  </div>
	</div>
  </div>