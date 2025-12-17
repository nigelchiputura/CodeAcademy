<header>

    <nav class="navbar navbar-expand-lg navbar-light shadow text-end bg-white">

        <div class="container-fluid">
            
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content: space-between;">
                <h1 class="lead fw-bold ms-3 mt-3 p-2 rounded-pill text-white bg-secondary text-center">Welcome <?= $_SESSION["name"] ?></h1>

                <ul class="navbar-nav mr-auto">

                    <li class="nav-item p-2">
                        <a href="../update_password.php" class="nav-link">
                            <i class="fas fa-key"></i> 
                            <span class="label nowrap">Update Password</span>
                        </a>
                    </li>

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