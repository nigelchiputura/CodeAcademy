<button id="toggleSidebar"><i class="fas fa-bars"></i></button>

<div class="modal fade" id="wipModal" tabindex="-1" aria-labelledby="wipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="wipModalLabel">🚧 Work in Progress</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        This module/functionality is still in development.  
        <br><br>
        You’ll be notified when it’s available and fully functional.  
        <br><br>
        Thank you for browsing through my work!  
        <br><br>
        If you’d like something similar built for your business or brand, feel free to reach out.  
        <br><br>
        — <strong>Nigel Chiputura</strong> (Software Developer)
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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

        <li class="label" data-bs-toggle="modal" data-bs-target="#wipModal" id="courses">
            <a href="#">
                <i class="fas fa-book"></i>
                <span >Courses</span>
            </a>
        </li>
        
        <li class="label" data-bs-toggle="modal" data-bs-target="#wipModal" id="teachers">
            <a href="#">
                <i class="fas fa-chalkboard-teacher"></i>
                <span >Teachers</span>
            </a>
        </li>

        <li class="label" data-bs-toggle="modal" data-bs-target="#wipModal" id="students">
            <a href="#">
                <i class="fas fa-user-graduate"></i>
                <span >Students</span>
            </a>
        </li>

        <li class="label" data-bs-toggle="modal" data-bs-target="#wipModal" id="payments">
            <a href="#">
                <i class="fas fa-credit-card"></i>
                <span >Payments</span>
            </a>
        </li>

        <li class="label" data-bs-toggle="modal" data-bs-target="#wipModal" id="anouncements">
            <a href="#">
                <i class="fas fa-bullhorn"></i>
                <span >Anouncements</span>
            </a>
        </li>

        <hr>

        <li class="label" data-bs-toggle="modal" data-bs-target="#wipModal" id="anouncements">
            <a href="#">
                <i class="fas fa-history"></i>
                <span >Activity Logs</span>
            </a>
        </li>

    </ul>

</aside>

<script src="/portal/assets/static/js/sidebar.js"></script>
