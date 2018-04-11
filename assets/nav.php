<?php $user = new User();?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/"><?php echo Setting::get('title');?></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/category/">Category</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <?php if(!$user->isLoggedIn()){ ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">User</a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="/register/">Register</a>
            <a class="dropdown-item" href="/login/">Login</a>
        </li>
        <?php }else{ ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user->data()->username; ?></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>