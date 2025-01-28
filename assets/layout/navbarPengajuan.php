<div class="container mt-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuan_aktif.php' ? 'active' : ''; ?>" href="pengajuan_aktif.php">Kegiatan Aktif</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuan_status.php' ? 'active' : ''; ?>" href="pengajuan_status.php">Status Pengajuan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuan_histori.php' ? 'active' : ''; ?>" href="pengajuan_histori.php">Histori</a>
    </li>
  </ul>
</div>