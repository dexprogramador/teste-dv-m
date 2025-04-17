<?php
session_start();
include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK - Tabacaria Delivery</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Logo fixa sobre fundo grafite -->
    <div class="logo-container">
        <img src="images/logo-bk.png" alt="BK Lounge">
    </div>

    <!-- BOAS-VINDAS COM FUNDO GRAFITE -->
    <section class="hero-section">
        <div class="container text-center">
            <h2 class="hero-title">Peça sua essência, carvão, alumínio e acessórios aqui 🌟</h2>
            <p class="hero-subtitle">
                ✨ e receba no conforto da sua casa.<br>
                🕒 Funcionamento: Segunda a Sábado, das 18:00 às 23:00<br>
                🏠 Endereço: R. Natal, 127 - Centro, Campo Novo do Parecis - MT, 78360-000<br>
                📞 WhatsApp: <a href="https://wa.me/5565981431429" target="_blank">(65) 98143-1429</a><br>
                📸 Instagram: <a href="https://www.instagram.com/bkloungecnp/" target="_blank">@bkloungecnp</a> &nbsp;
                <a href="https://www.instagram.com/bktabacariacnp/" target="_blank">@bktabacariacnp</a>
            </p>
        </div>
    </section>

    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>

    <!-- PRODUTOS AGRUPADOS POR CATEGORIA -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Escolha os Itens do seu pedido:</h2>

            <?php
            $sql_cat = "SELECT * FROM tbl_category WHERE active='Yes' ORDER BY title ASC";
            $res_cat = mysqli_query($conn, $sql_cat);

            if (mysqli_num_rows($res_cat) > 0) {
                while ($cat = mysqli_fetch_assoc($res_cat)) {
                    $cat_id = $cat['id'];
                    $cat_title = $cat['title'];
                    echo "<h3>" . $cat_title . "</h3>";

                    $sql_food = "SELECT * FROM tbl_food WHERE active='Yes' AND category_id=$cat_id ORDER BY title ASC";
                    $res_food = mysqli_query($conn, $sql_food);

                    if (mysqli_num_rows($res_food) > 0) {
                        while ($food = mysqli_fetch_assoc($res_food)) {
                            $food_id = $food['id'];
                            $food_title = $food['title'];
                            $food_price = $food['price'];
                            $food_description = $food['description'];
                            $food_image = $food['image_name'];
            ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php if ($food_image == "") {
                                        echo "<div class='error'>Imagem não disponível</div>";
                                    } else {
                                        echo "<img src='images/food/$food_image' alt='$food_title' class='img-responsive img-curve'>";
                                    } ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $food_title; ?></h4>
                                    <p class="food-price">R$ <?php echo number_format($food_price, 2, ',', '.'); ?></p>
                                    <p class="food-detail"><?php echo $food_description; ?></p>
                                    <br>
                                    <a href="order.php?food_id=<?php echo $food_id; ?>" class="btn btn-yellow">Adicionar ao Carrinho</a>
                                </div>
                            </div>

            <?php
                        }
                    } else {
                        echo "<p class='error'>Nenhum produto encontrado nesta categoria.</p>";
                    }
                }
            } else {
                echo "<p class='error'>Nenhuma categoria cadastrada.</p>";
            }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>

    <!-- BOTÃO FIXO CARRINHO -->
    <div class="cart-button" onclick="window.location.href='checkout.php'">
        <img src="images/shopping-cart.svg" alt="Carrinho">
        <span class="cart-count">0</span>
    </div>

    <!-- BARRA INFORMATIVA FIXA -->
    <div id="cart-quantity" class="cart-notification">
        <span id="cart-items-count">Você tem 0 item(s) no carrinho</span>
        <button onclick="window.location.href='checkout.php'">Ver Carrinho e Finalizar Pedido</button>
    </div>

    <script>
        function updateCartUI() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let total = cart.reduce((sum, item) => sum + item.quantity, 0);

            document.querySelector('.cart-count').innerText = total;
            document.getElementById('cart-items-count').innerText = `Você tem ${total} item(s) no carrinho`;

            if (total > 0) {
                document.getElementById('cart-quantity').style.display = 'flex';
            } else {
                document.getElementById('cart-quantity').style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', updateCartUI);
    </script>

</body>

</html>