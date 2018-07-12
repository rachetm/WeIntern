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
					<button class="btn btn-cus nav-link" data-toggle="modal" data-target="#adduser"><span class="fa fa-user-plus"></span>Add User</button>
				</li>
				<li class="nav-item active">
					<button class="btn btn-cus nav-link" data-toggle="modal" data-target="#deluser"><span class="fa fa-user-minus"></span>Delete User</button>
				</li>
			</ul>
			<ul class="nav navbar-nav">
				<li class="nav-item active" style="padding-right: 10px;">
					<button class="btn btn-cus nav-link" onclick="loadnotifications();" data-toggle="modal" data-target="#notif"><span class="fa fa-bell"></span>Notifications
					</button>
				</li>
				<hr>
				<a id="logout" href="logout.php" class="btn btn-danger navbar-btn"><span class="fa fa-sign-out-alt"></span>Log Out</a>
			</ul>
		</div>
	</div>
</nav>
<!-- Notifications Modal -->
<div class="modal fade" id="notif" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="notif">Notifications</h5>
				<button style="outline:none;" type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<ul id="notifications" class="list-group">
					<!-- Display of notificatins done at the end using Ajax -->
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Add User Modal -->
<div class="modal fade" id="adduser" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="adduser">Add User</h5>
				<button style="outline:none;" type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="register.php" method="post">
				<div class="modal-body">
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
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete User Modal -->
<div class="modal fade" id="deluser" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deluser">Delete User or Make Inactive</h5>
				<button type="button" class="close" data-dismiss="modal">
				<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row form-group">
					<label for="">Select User</label>
					<select class="form-control" id="">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
					</select>
				</div>
				<div class="form-row form-group">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="delete" name="delete" class="custom-control-input">
						<label class="custom-control-label" for="customRadioInline1">Delete User</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="inactive" name="inactive" class="custom-control-input">
						<label class="custom-control-label" for="customRadioInline2">Make User Inactive</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<input type="submit" class="btn btn-success" value="Confirm">
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
					resultstring += "<li class='list-group-item'>" + resultvar[i].content + resultvar[i].time + "</li>";
					i++;
				}
				document.getElementById('notifications').innerHTML = resultstring;
								}
		}
		xhr.send();
	}
</script>