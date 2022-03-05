<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow">
	<?php
	if((isset($_SESSION["logintype"])) && ($_SESSION["logintype"] == "none")){
		?>
		<a class="nav-link" href="./index.php">
			<img class="img-fluid exam-logo" src="./images/system/social.png" />
		</a>
		<button class="navbar-toggler bg-dark header-right me-3" type="button">
			<img class="text-white" src="./images/system/hamberger.png"/>
		</button>
		<div class="container-fluid justify-content-end">
			<ul class="navbar-nav navbar-content">

				<li class="nav-item">
					<a class="nav-link active font-weight-bold" href="./index.php">View Post</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active font-weight-bold" href="./signin.php">Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active font-weight-bold" href="./signup.php">Sign Up</a>
				</li>
			</ul>
		</div>
		<?php
	}
	//when user is login
	if((isset($_SESSION["logintype"])) && ($_SESSION["logintype"] != "none") && (isset($_SESSION["loginuser"]))){
		?>
		<a class="nav-link" href="
			<?php
			if($_SESSION["logintype"] == "user_account_setting"){
				echo "../index.php";
			}
			else{
				echo "./index.php";
			}
			?>
		">
			<img class="img-fluid exam-logo" src="
			<?php
			if($_SESSION["logintype"] == "user_account_setting"){
				echo "../images/system/social.png";
			}
			else{
				echo "./images/system/social.png";
			}
			?>
			" />
		</a>

		<div class="d-flex ms-auto">
			<?php
				if((isset($_SESSION["logintype"])) && ($_SESSION["logintype"] == "index") || ($_SESSION["logintype"] == "profile_search")){
				?>
				<input class="form-control oval-border me-2 search-profile" type="search" placeholder="Search Profile" />
				<?php
			}
			?>

			<button class="btn user-notification-button me-3" type="button">
				<span class="iconify h5 custom-blue-color" data-icon="clarity:notification-solid"></span>
				<div class = "notification-number"><!-- JQUERY CODE--></div>
			</button>
			<button class="btn carret-arrow text-dark border-none me-3" type="button">
				<span class="iconify h5 mt-1" data-icon="ls:dropdown"></span>
			</button>
		</div>
		<?php
	}
	?>
</nav>
<div class="container-fluid">
	<div class="row justify-content-end">
		<div class="col bg-white container-notification display-none shadow-lg position-fixed">

		</div>
	</div>
</div>