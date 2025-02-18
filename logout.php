<?php
session_start();
session_destroy();
?>

<script>
    alert("Logout berhasil!"); 
    window.location.href = "login.php";
</script>

?>