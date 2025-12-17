    <footer class="footer fade-in">
        <div class="container footer-container">

            <!-- Company Info -->
            <div class="footer-section footer-brand">
                <h2 class="footer-company">Garage.<span>Experts</span></h2>
                <p class="footer-description">
                    Your trusted partner for gate installations, intercom and biometric setup, home security and so much more!
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section footer-links-list">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/services">Our Services</a></li>
                    <li><a href="/#about">About Us</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Details -->
            <div class="footer-section footer-contact">
                <h3>Contact Us</h3>
                <p><i class="fas fa-map-marker-alt"></i> Cape Town, South Africa</p>
                <p><a href="#"><i class="fas fa-phone"></i> +263 77 392 8945</a></p>
                <p><a href="#"><i class="fas fa-envelope"></i> info@garagegurus.net</a></p>
            </div>

            <!-- Map -->
            <div class="footer-section footer-map">
                <h3>Find Us</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16552.626719234773!2d31.579416847622268!3d-18.18510347666814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19384b8f6ae0e87f%3A0xe1ebf7af5120a061!2sMarondera!5e0!3m2!1sen!2szw!4v1696969699699"
                    width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

        </div>

        <!-- Bottom Row -->
        <div class="footer-bottom">
            <p>© Website Designed And Maintained By Nigel Chiputura | All Rights Reserved</p>

            <div class="footer-socials">
                <a href="#" class="center"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="center"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="center"><i class="fab fa-twitter"></i></a>
                <a href="#" class="center"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <a class="back-to-top btn btn-primary rounded-pill" href="#" id="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </a>

    <?php require_once __DIR__ . "/chatbot.php" ?>
    
    <script src="/public/website/assets/static/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const url = window.location.href;
        const currentPage = url.substring(url.lastIndexOf("/") + 1);

        const navbar = document.querySelector(".navbar");

        if (currentPage) {
            navbar.classList.add("cng-navbar");
        }

        document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();

            const parent = this.parentElement;

            // close previously open dropdowns
            document.querySelectorAll(".dropdown.open").forEach((d) => {
            if (d !== parent) d.classList.remove("open");
            });

            // toggle current dropdown
            parent.classList.toggle("open");
        });
        });

        // Optional: close dropdown when clicking outside
        document.addEventListener("click", function (e) {
        if (!e.target.closest(".dropdown")) {
            document
            .querySelectorAll(".dropdown.open")
            .forEach((d) => d.classList.remove("open"));
        }
        });

    </script>
</html>