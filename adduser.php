<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="#"><span class="fa fa-tachometer-alt"></span>Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="nav navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="admin.php"><span class="fa fa-home"></span>Home</a>
				</li>
				<li class="nav-item active">
					<button class="btn btn-cus nav-link" data-toggle="modal" data-target="#usercontrol"><span class="fa fa-user"></span>User Control</button>
				</li>
			</ul>
			<ul class="nav navbar-nav">
				<li class="nav-item active">
					<button class="btn btn-cus nav-link" onclick="loadnotifications();" data-toggle="modal" data-target="#notif"><span class="fa fa-bell"></span>Notifications
					</button>
				</li>
				<li class="nav-item active" style="padding-right: 5px;">
					<button class="btn btn-cus nav-link" onclick="location.href='chgpwd.php'"><span class="fa fa-key"></span>Change Password
					</button>
				</li>
				<hr>
				<a id="logout" href="logout.php" class="btn btn-danger navbar-btn"><span class="fa fa-sign-out-alt"></span>Log Out</a>
			</ul>
		</div>
	</div>
</nav>

<!-- User Control Modal -->
<div class="modal fade" id="usercontrol" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="usercontrol">User Control</h5>
				<button style="outline:none;" type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-fill nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-adduser" role="tab">Add User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-deluser" role="tab">Delete User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-userstatus" role="tab">Activate/Deactivate User</a>
					</li>
				</ul>
				<!-- Add User -->
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-adduser" role="tabpanel">
						<form action="register.php" method="post">
							<div class="form-row form-group">
								<input type="text" class="form-control field"  placeholder="Name" name="name" required>
							</div>
							<div class="form-row form-group">
								<input type="email" class="form-control field"  placeholder="Email" name="email" required>
							</div>
							<div class="form-row form-group">
								<input type="text" class="form-control field"  placeholder="Username" name="username" required>
							</div>
							<div class="form-row form-group">
								<input type="password" class=" field form-control" placeholder="Password" name="newpassword" required>
							</div>
							<div class="form-row form-group">
								<input type="password" class=" field form-control" placeholder="Confirm Password" name="confirmpassword" required>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
								<input type="submit" class="btn btn-success" value="Confirm">
							</div>
						</form>
					</div>
					<!-- Delete User -->
					<div class="tab-pane fade" id="pills-deluser" role="tabpanel">
						<form action="deregister.php" method="post">
							<div class="form-row form-group">
								<label for="userselect">Select User</label>
								<select class="form-control custom-select" id="userselect" name="username">
									<?php
										$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` != 'admin'");
										$stmt->execute();
										$result = $stmt->get_result();
										while($row = $result->fetch_assoc())
										{
											echo "<option value='".$row['username']."'>".$row['name']."</option>";
										}
									?>
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
								<input type="submit" class="btn btn-success" value="Confirm">
							</div>
						</form>
					</div>
					<!-- Change User Status -->
					<div class="tab-pane fade" id="pills-userstatus" role="tabpanel">
						<form action="statuschg.php" method="post">
							<div class="form-row form-group">
								<label for="userselect">Select User</label>
								<select class="form-control custom-select" id="userselect" name="username">
									<?php
										$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` != 'admin'");
										$stmt->execute();
										$result = $stmt->get_result();
										while($row = $result->fetch_assoc())
										{
											echo "<option value='".$row['username']."'>".$row['name']."</option>";
										}
									?>
								</select>
							</div>
								<div class="form-row form-group">
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="active" name="userstatus" class="custom-control-input" value="1">
										<label class="custom-control-label" for="active">Activate User</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="inactive" name="userstatus" class="custom-control-input" value="0">
										<label class="custom-control-label" for="inactive">Deactivate User</label>
									</div>
								</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
								<input type="submit" class="btn btn-success" value="Confirm">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Notifications Modal -->
<div class="modal fade" id="notif" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="notif">Notifications</h5>
				<button style="outline:none;" type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
					<table class="table table-bordered table-striped">
					<!-- <thead class="thead-dark">
					</thead> -->
					<tbody id="notifications">
						<!-- Notifications are displayed here using Ajax below -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function loadnotifications()
	{
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'get_notif.php', true);
		xhr.onload = function()
		{
			if(this.status == 200)
			{
				// console.log(this.responseText);
				var resultvar = JSON.parse(this.responseText);
				var resultstring = '';
				var i = 0;
				while(resultvar[i])
				{
					if(i%2==0)
						var color = 'info';
					else
						var color = 'default';
					resultstring += "<tr class='table-" + color + "'><td>" + resultvar[i].content + "<strong>" + resultvar[i].time + "</strong></td></tr>";
					i++;
				}
				document.getElementById('notifications').innerHTML = resultstring;
								}
		}
		xhr.send();
	}
</script>