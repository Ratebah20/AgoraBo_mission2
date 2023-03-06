    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="profile.html"><img src="web/img/greece-1162816_640.jpg" class="img-circle" width="80"></a></p>
          <h5 class="centered">MJC Agora</h5>

          <li class="sub-menu">
            <a <?php if (isset($menuActif) && $menuActif == 'Jeux') {echo 'class="active"';} ?> href="index.php">
              <i class="fa fa-desktop"></i>
              <span>Jeux vidéos</span>
              </a>
            <ul class="sub">
            <li><a href="index.php?uc=gererJeux&action=afficherJeux">Jeux</a></li>
              <li><a href="index.php?uc=gererGenres&action=afficherGenres">Genres</a></li>
              <li><a href="index.php?uc=gererPlateforme&action=afficherPlateforme">Plateforme</a></li>
              <li><a href="index.php?uc=gererMarque&action=afficherMarque">Marque</a></li>
			  <li><li><a href="index.php?uc=gererPegi&action=afficherPegi">Pegi</a></li>
			  <li><a href="index.php">Tournois</a></li>
            </ul>
          </li>
		  <li class="sub-menu">
            <a <?php if (isset($menuActif) && $menuActif == 'Clubs') {echo 'class="active"';} ?> href="javascript:;">
              <i class="fa fa-group"></i>
              <span>Clubs d'activités</span>
              </a>
            <ul class="sub">
              <li><a href="index.php">sous-menu 1</a></li>
              <li><a href="index.php">sous-menu 2</a></li>
              <li><a href="index.php">sous-menu 3</a></li>
              <li><a href="index.php">sous-menu 4</a></li>
			  <li><a href="index.php">sous-menu 5</a></li>
            </ul>
          </li>
		  
          <li class="sub-menu">
            <a <?php if (isset($menuActif) && $menuActif == 'Formations') {echo 'class="active"';} ?> href="javascript:;">
              <i class="fa fa-th"></i>
              <span>Formations</span>
              </a>
            <ul class="sub">
              <li><a href="index.php">sous-menu 1</a></li>
              <li><a href="index.php">sous-menu 2</a></li>
              <li><a href="index.php">sous-menu 3</a></li>
              <li><a href="index.php">sous-menu 4</a></li>
			  <li><a href="index.php">sous-menu 5</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a <?php if (isset($menuActif) && $menuActif == 'Membres') {echo 'class="active"';} ?> href="javascript:;">
              <i class="fa fa-user-md"></i>
              <span>Membres</span>
              </a>
            <ul class="sub">
              <li><a href="index.php">sous-menu 1</a></li>
              <li><a href="index.php">sous-menu 2</a></li>
              <li><a href="index.php">sous-menu 3</a></li>
              <li><a href="index.php">sous-menu 4</a></li>
			  <li><a href="index.php">sous-menu 5</a></li>
            </ul>
          </li>
		  
          <li class="sub-menu">
            <a <?php if (isset($menuActif) && $menuActif == 'Intervenants') {echo 'class="active"';} ?> href="javascript:;">
              <i class="fa fa-smile-o"></i>
              <span>Intervenants</span>
              </a>
            <ul class="sub">
              <li><a href="index.php">sous-menu 1</a></li>
              <li><a href="index.php">sous-menu 2</a></li>
              <li><a href="index.php">sous-menu 3</a></li>
              <li><a href="index.php">sous-menu 4</a></li>
			  <li><a href="index.php">sous-menu 5</a></li>
            </ul>
          </li>

        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">