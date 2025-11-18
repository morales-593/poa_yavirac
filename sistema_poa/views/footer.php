    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <script src="../assets/js/main.js"></script>
    <script>
        // Manejo de alertas desde PHP
        <?php if(isset($_SESSION['alert'])): ?>
            showAlert('<?php echo $_SESSION['alert']['type']; ?>', '<?php echo $_SESSION['alert']['message']; ?>');
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
    </script>
</body>
</html>