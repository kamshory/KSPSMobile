<?php
$module = basename($_SERVER['PHP_SELF']);
?>
<ul>
  <li<?php if($module == 'index.php') echo ' class="active"';?>><a href="./">Awal</a></li>
  <li<?php if($module == 'tabungan.php') echo ' class="active"';?>><a href="tabungan.php">Tabungan</a></li>
  <li<?php if($module == 'transfer-dana.php') echo ' class="active"';?>><a href="transfer-dana.php">Transfer</a></li>
  <li<?php if($module == 'pembiayaan.php') echo ' class="active"';?>><a href="pembiayaan.php">Pembiayaan</a></li>
  <li<?php if($module == 'pengingat.php') echo ' class="active"';?>><a href="pengingat.php">Pengingat</a></li>
  <li<?php if($module == 'nasabah.php' || $module == 'daftar-rekening.php' || $module == 'sandi.php') echo ' class="active"';?>><a href="nasabah.php">Nasabah</a></li>
  <li<?php if($module == 'logout.php') echo ' class="active"';?>><a href="logout.php">Keluar</a></li>
</ul>