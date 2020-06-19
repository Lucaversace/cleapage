<?php
session_start();
if(isset($_SESSION['status']) && $_SESSION['status'] == 'connected')
{
    $_SESSION = [];
    header('Location: signin.php');
}