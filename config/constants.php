<?php
// Só inicia a sessão se ainda não tiver sido iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Proteção para não redefinir as constantes
if (!defined('SITEURL')) define('SITEURL', 'http://localhost/food-order/');
if (!defined('LOCALHOST')) define('LOCALHOST', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_NAME')) define('DB_NAME', 'food-order');

// Conexão com o banco
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
