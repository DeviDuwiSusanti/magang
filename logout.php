<?php
session_start();
session_destroy(); // Hapus semua session
?>

<script>
    alert("Logout berhasil!"); 
    window.location.href = "login.php";
</script>

?>