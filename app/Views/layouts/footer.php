<!-- Toast Notifications -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    <div id="crudToast" class="toast align-items-center text-bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                <span id="crudToastMessage">Action successful!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-warning">
        <h5 class="modal-title fw-bold">
          <i class="fas fa-sign-out-alt me-2"></i> Confirm Logout
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out of the admin dashboard?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="../logout.php" method="post" >
            <button type="submit" name="logout-submit" class="btn btn-warning fw-bold" id="confirmLogoutBtn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
window.addEventListener('load', () => {
  document.getElementById('loading-spinner').classList.add('hidden');
});
</script>
<script src="/public/assets/static/js/flashMessage.js"></script>

</body>
</html>