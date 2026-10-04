<?php if (isset($_SESSION['error_message'])) { ?>
<dialog class="error-modal" id="error_dialog" closedby="any" open>
    <?php
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    ?>
</dialog>
<script>
    window.addEventListener('load', function (e) {
        // Fading away after 13 seconds
        const dialog = document.getElementById("error_dialog");
        dialog.style.opacity = "0";
        setTimeout(() => { dialog.close(); }, 13000)
    })
</script>
<?php } ?>