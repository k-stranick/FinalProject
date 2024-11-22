        <!-- Footer -->
        <footer class="text-center mt-5 bg-dark text-white py-3">
            <p>&copy; <?= date("Y") ?> Second Hand Herald. All rights reserved.</p>
        </footer>

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- Additional Global Scripts -->
        <!-- <script src="../js/global.js"></script> ADD LATER -->

        <!-- Page-Specific Scripts -->
        <?php if (!empty($scripts)): ?>
            <?php foreach ($scripts as $script): ?>
                <script src="<?= htmlspecialchars($script) ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>