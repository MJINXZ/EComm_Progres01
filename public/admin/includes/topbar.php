 <nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">Sweet!</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav m-auto my-2 my-lg-0">

        <li class="nav-item">
          <a class="nav-link active"href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
                    <?php
                    if (isset($_SESSION['UID'])) {
                    ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link nav-change dropdown-toggle"  id="dropdownLink"  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.2rem;">
                                <?php echo $_SESSION['userName']; ?>
                            </a>
                            <div class="dropdown-menu dropdown-style" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item logout-txt" href="Logout.php" style="font-size: 1.2rem;">Logout</a>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <a class="nav-link nav-change " href="login.php" style="font-size: 1.2rem;">Sign In</a>
                    <?php
                    }
                    ?>
                </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Order</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>

      <form class="d-flex">
        <input class="px-2 search" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>