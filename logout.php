<?php
require_once 'utils/auth.util.php';

logout();

header("Location: login.php");
exit;