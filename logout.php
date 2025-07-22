<?php
session_start();
require_once 'utils/auth.util.php';

logout();

header("Location: index.php");
exit;