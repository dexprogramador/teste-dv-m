<?php
function conectar()
{
  $host = 'localhost';
  $usuario = 'root';
  $senha = ''; // padrão no XAMPP é sem senha
  $banco = 'bk_lounge'; // seu banco de dados

  $conn = new mysqli($host, $usuario, $senha, $banco);

  if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
  }

  return $conn;
}
