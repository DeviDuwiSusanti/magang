<div class="container mt-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuanaktif.php' ? 'active' : ''; ?>" href="pengajuanaktif.php">Kegiatan Aktif</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuanstatus.php' ? 'active' : ''; ?>" href="pengajuanstatus.php">Status Pengajuan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuan_histori.php' ? 'active' : ''; ?>" href="pengajuan_histori.php">Histori</a>
    </li>
  </ul>
</div>