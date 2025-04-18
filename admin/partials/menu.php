<?php
include('../config/constants.php');
include('login-check.php');
?>

<html>

<head>
    <title>BK Lounge - Painel Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
        crossorigin="anonymous">
</head>

<body>
    <!-- Menu Section Starts -->
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="painel.php">📦 Pedidos</a></li>
                <li><a href="manage-food.php">🍽️ Produtos</a></li>
                <li><a href="manage-category.php">📁 Categorias</a></li>
                <li><a href="manage-admin.php">👤 Administradores</a></li>
                <li><a href="logout.php">🚪 Sair</a></li>
            </ul>
        </div>
    </div>
    <!-- Menu Section Ends -->