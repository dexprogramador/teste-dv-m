<?php
$conn = mysqli_connect('localhost', 'root', '', 'food-order');

if ($conn) {
  echo "✅ Conectado com sucesso!";
} else {
  echo "❌ Falha na conexão.";
}
