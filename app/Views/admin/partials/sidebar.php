<aside class="sidebar" id="sidebar">
    
    <div class="logo">
        <img src="/portal/assets/static/images/logo.png" class="shadow rounded-pill p-1   " alt="">
    </div>

    <ul class="menu" id="menu">

        <li id="dashboard" class="active">
            <a href="./dashboard.php">
                <i class="fas fa-tachometer-alt"></i>
                <span class="label">Dashboard</span>
            </a>
        </li>

        <hr>
        
        <li id="users">
            <a href="./users.php">
                <i class="fas fa-user"></i>
                <span class="label">Users</span>
            </a>
        </li>

        <li id="courses">
            <a href="./courses.php">
                <i class="fas fa-book"></i>
                <span class="label">Courses</span>
            </a>
        </li>

        <li id="students">
            <a href="./students.php">
                <i class="fas fa-user-graduate"></i>
                <span class="label">Students</span>
            </a>
        </li>

        <li id="payments">
            <a href="./payments.php">
                <i class="fas fa-credit-card"></i>
                <span class="label">Payments</span>
            </a>
        </li>

    </ul>

</aside>

<script>

    const url = window.location.href;
    // console.log(url);
    const fileName = url.substring(url.lastIndexOf('/') + 1).slice(0, -4);
    console.log(fileName);

    const sidebarMenu = document.getElementById("menu");
    const sidebarLinks = sidebarMenu.querySelectorAll("li");
    const defaultActiveLink = document.getElementById("index");

    sidebarLinks.forEach((link) => {
        link.classList.remove("active");
        let linkType = link.getAttribute("id");
        // console.log(linkType)

        if (fileName === linkType) {
            link.classList.add("active");
        }
    })

</script>