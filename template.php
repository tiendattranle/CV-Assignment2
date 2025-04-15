<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="template-container">
    <section class="templates">
        <div class="container">
            <h1><i class="fas fa-file-alt"></i> Choose Your Template</h1>
            <p>Select a beautiful template to start building your CV in minutes.</p>

            <div class="template-scroll-container">
                <div class="template-item">
                    <img src="images/tem1.jpg" alt="Template 1">
                    <a href="javascript:void(0);" class="btn" onclick="openModal('images/tem1.jpg')">
                        <i class="fas fa-eye"></i> Preview
                    </a>
                    <a href="?page=demo&id=1" class="btn btn-secondary">
                        <i class="fas fa-play"></i> Use Template
                    </a>
                </div>
                <div class="template-item">
                    <img src="images/tem2.jpg" alt="Template 2">
                    <a href="javascript:void(0);" class="btn" onclick="openModal('images/tem2.jpg')">
                        <i class="fas fa-eye"></i> Preview
                    </a>
                    <a href="?page=demo&id=2" class="btn btn-secondary">
                        <i class="fas fa-play"></i> Use Template
                    </a>
                </div>
                <div class="template-item">
                    <img src="images/tem3.jpg" alt="Template 3">
                    <a href="javascript:void(0);" class="btn" onclick="openModal('images/tem3.jpg')">
                        <i class="fas fa-eye"></i> Preview
                    </a>
                    <a href="?page=demo&id=3" class="btn btn-secondary">
                        <i class="fas fa-play"></i> Use Template
                    </a>
                </div>
                <!-- Add more templates if needed -->
            </div>
        </div>
    </section>
</div>

<!-- Modal Preview -->
<div id="previewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="Template Preview">
    </div>
</div>

<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('previewModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('previewModal').style.display = "none";
    }

    window.addEventListener('click', function (event) {
        const modal = document.getElementById('previewModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>