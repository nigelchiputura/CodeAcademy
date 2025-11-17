<header>

    <nav class="navbar navbar-expand-lg navbar-light shadow text-end">

        <div class="container-fluid">
            
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item p-2">
                        <a href="../../auth/password_change.php" class="nav-link">
                            <i class="fas fa-key"></i> 
                            <span class="label nowrap">Update Password</span>
                        </a>
                    </li>

                    <!-- <li class="nav-item p-2">
                        <form action="../../auth/logout.php" method="post" >
                            <button type="submit" name="logout-submit" class="btn nav-link d-inline">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li> -->

                    <li class="nav-item p-2">
                        <button href="#" id="logoutLink" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-power-off me-2"></i> Logout
                        </button>
                    </li>

                </ul>
            </div>

        </div>

    </nav>

</header>