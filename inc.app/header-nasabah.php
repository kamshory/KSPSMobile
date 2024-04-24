  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="./"><?php echo $app->get_app_name();?></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="./"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <?php
		require_once __DIR__."/menu-content.php";
		?>
      </nav><!-- .nav-menu -->

    </div>
	
	<div class="content-menu container">
		<nav class="tab-content-menu">
			<?php
			require_once __DIR__."/tab-nasabah.php";
			?>
		</nav>
	</div>
  </header><!-- End Header -->