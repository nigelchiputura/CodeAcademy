<div id="customModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" id="closeModalBtn">&times;</span>
    <h2>🚧 Work in Progress</h2>
    <br>
    <p>This module/functionality is still in development.</p>
    <p>You’ll be notified when it’s available and fully functional.</p>
    <p>Thank you for browsing through my work!</p>
    <p>If you’d like something similar built for your business or brand, feel free to reach out.</p>
    <br>
    <p><strong>— Nigel Chiputura</strong> (Software Developer)</p>
  </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    p {
        margin-bottom: 15px;
    }

    .modal-content {
        background: white;
        padding: 20px 30px;
        border-radius: 8px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.3s ease-in-out;
    }

    .close-btn {
        float: right;
        font-size: 1.5em;
        cursor: pointer;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<script>

    const modal = document.getElementById('customModal');
    const closeBtn = document.getElementById('closeModalBtn');
    // const moduleName = document.getElementById('moduleName');
    
    document.querySelectorAll('.openModalBtn').forEach(button => {
    button.addEventListener('click', () => {
        // const name = button.getAttribute('data-module');
        // moduleName.textContent = `Module: ${name}`;
        modal.style.display = 'flex';
    });
    });

    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

</script>