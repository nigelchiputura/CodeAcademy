<aside class="sidebar" id="sidebar">
    
    <div class="logo">
        <img src="../../assets/static/images/logo.png" class="shadow rounded-pill p-1   " alt="">
    </div>

    <ul class="menu" id="menu">

        <li id="index" class="active">
            <a href="../../views/admin/index.php">
                <i class="fas fa-tachometer-alt"></i>
                <span class="label">Dashboard</span>
            </a>
        </li>

        <hr>
        
        <li id="users">
            <a href="../../views/admin/dashboard.php?request=users">
                <i class="fas fa-user"></i>
                <span class="label">Users</span>
            </a>
        </li>

        <li id="courses">
            <a href="../../views/admin/dashboard.php?request=courses">
                <i class="fas fa-book"></i>
                <span class="label">Courses</span>
            </a>
        </li>

        <li id="students">
            <a href="../../views/admin/dashboard.php?request=students">
                <i class="fas fa-user-graduate"></i>
                <span class="label">Students</span>
            </a>
        </li>

        <li id="payments">
            <a href="../../views/admin/dashboard.php?request=payments">
                <i class="fas fa-credit-card"></i>
                <span class="label">Payments</span>
            </a>
        </li>

    </ul>

</aside>

<script>

    const params = new URLSearchParams(window.location.search);
    const searchParameter = params.get("request");

    const sidebarMenu = document.getElementById("menu");
    const sidebarLinks = sidebarMenu.querySelectorAll("li");
    const defaultActiveLink = document.getElementById("index");

    sidebarLinks.forEach((link) => {
        link.classList.remove("active");
        let linkType = link.getAttribute("id");
        
        if (linkType === searchParameter) {
            link.classList.add("active");
        }
    })

    if (searchParameter === null) {
        defaultActiveLink.classList.add("active");
    }

</script>