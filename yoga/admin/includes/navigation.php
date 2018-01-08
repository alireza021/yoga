
<body>

<div class="wrap-box"></div>
<div class="header_bottom">
	    <div class="container">
			<div class="col-xs-8 header-bottom-left">
				<div class="col-xs-2 logo">
					<a href = "index.php">
					<img width="115" height="70" src="../images/yoga-logo.png" class="img-responsive"  alt="item1">
				</a>
				</div>
				<div class="col-xs-6 menu">
		            <ul class="megamenu skyblue">
									<li>
										<a class="color1" href="#" data-toggle="dropdown">Hello <b><?=$user_data['first'];?></b>!
											<span class="caret"></span>
										</a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="change_password.php">Change Password</a></li>
											<li><a href="logout.php">Logout</a></li>
										</ul>
									</li>

				    	<li><a class="color2" href="index.php">Manage Classes</a></li>
							<!-- make sure admin has permission to add more admins -->
							<?php if(has_permission('admin')): ?>
				    	<li><a class="color3" href="users.php">Manage Instructors</a></li>
						<?php endif; ?>


			</div>
		</div>

	         <div class="clearfix"></div>
       </div>
        <div class="clearfix"></div>
	 </div>
</div>
  <div class="container-fluid">
