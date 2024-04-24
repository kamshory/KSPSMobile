<?php
require_once __DIR__."/inc.app/config.php";
require_once __DIR__."/inc.app/session.php";
@session_destroy();
header("Location: index.php");
?>