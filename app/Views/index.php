<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeAcademy</title>
    <link rel="stylesheet" href="/website/assets/static/css/style.css">
    <link rel="stylesheet" href="/website/assets/static/css/fontawesome.css">
    <link rel="stylesheet" href="/website/assets/static/css/normalize.css">
    <link rel="stylesheet" href="/website/assets/static/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="/website/assets/static/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.css">
</head>
<body>

    <template id="template">
        <div class="" id="content-div">
            <div id="heading">
                <span><i class="" id="icon"></i></span>
                <h2></h2>
            </div>
            <div class="line"></div>
            <p class="text p1"></p>
            <p class="text p2"></p>
            <p class="text p3"></p>
            <ul></ul>
        </div>
    </template>

    <article id="index">

        <!-- HEADER -->

        <header class="header" id="intro">
            <nav class="navbar">
                <div class="container">

                    <div class="brand-and-toggler">
                        <a href="./index.php" class="navbar-brand">
                            <!-- <img src="/website/assets/static/images/logo(resized).png" alt=""> -->
                            <span>Code</span>Academy
                        </a>
                        <button type="button" class="navbar-toggler" id="navbar-toggler">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <div class="navbar-collapse">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a href="#" class="nav-link">welcome</a>
                            </li>

                            <li class="nav-item">
                                <a href="#about" class="nav-link">our story</a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">admissions</a>
                            </li>   

                            <li class="nav-item">
                                <a href="#" class="nav-link">contact</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle">
                                    pages
                                    <span class="dropdown-icon"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="./login.php"><i class="fas fa-user"></i> Login</a></li>
                                    <li><a href="#"><i class="fas fa-images"></i> Gallery</a></li>
                                    <li><a href="#"><i class="fas fa-newspaper"></i> News</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            <div class="hero-div center container">
                <h1 class="hero-title">Welcome To CodeAcademy</h1>
                <p class="hero-subtitle">Shaping the digital world since 1980.</p>
                <br>
                <h4 id="typed-text" class="tagline"></h4>

                <div class="hero-btns hero-buttons">

                    <a href="#about">
                        <button type="button" class="btn-trans">our story <i class="fas fa-book"></i></button>
                    </a>
                    <a href="#">
                        <button type="button" class="btn-white">contact us <i class="fas fa-phone-alt"></i></button>
                    </a>

                </div>
            </div>
        </header>

        <!-- END HEADER -->

        <!-- ABOUT SECTION -->

        <section class="about fade-in" id="about">
            <div class="container">
                <div class="title">
                    <h2>About Us</h2>
                    <p class="text">
                        Hello World, Hello Future.
                    </p>
                    <div class="header-line"></div>
                </div>

                <div class="row">

                    <div class="about-left" id="about-item-container-right"></div>

                    <div class="about-right" id="about-item-container-left"></div>

                </div>
            </div>
        </section>

        <!-- END ABOUT SECTION -->

    </article>

    <script>
        
        const text = "Compiling Tomorrow's Coders Today. </>";
        let index = 0;

        function type() {
            if (index < text.length) {
                document.getElementById("typed-text").innerHTML += text.charAt(index);
                index++;
                setTimeout(type, 80);
            }
        }

        window.onload = () => type();

    </script>

    <script src="/website/assets/static/js/jquery-3.7.1.js"></script>
    <script src="/website/assets/static/OwlCarousel2-2.3.4/dist/owl.carousel.js"></script>
    <script src="/website/assets/static/js/index.js" type="module"></script>
    <script src="/website/assets/static/js/navbar.js" type="module"></script>
    <script src="/website/assets/static/js/fadeIn.js"></script>

</body>
</html>