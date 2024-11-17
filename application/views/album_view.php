<div class="main-container">
    <div class="gallery-grid">
        <?php foreach ($data as $index => $image): ?>
            <img src="<?= htmlspecialchars($image); ?>" alt="Gallery Image" onclick="openModal(<?= $index ?>)">
        <?php endforeach; ?>
    </div>

    <!-- Модальное окно для отображения изображения -->
    <div id="modal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modal-image">
        <a class="prev" onclick="changeImage(-1)">&#10094;</a>
        <a class="next" onclick="changeImage(1)">&#10095;</a>
    </div>
</div>

<script id="gallery-data" src="application/assets/js/galleryModal.js"><?= json_encode($data); ?></script>
