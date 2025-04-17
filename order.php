<?php
include('config/constants.php');

if (!isset($_GET['food_id'])) {
    header('location: index.php');
    exit;
}

$food_id = $_GET['food_id'];
$sql = "SELECT * FROM tbl_food WHERE id=$food_id AND active='Yes'";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) != 1) {
    echo "<p style='color:white; text-align:center;'>Produto não encontrado.</p>";
    exit;
}

$food = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar ao Carrinho - BK Lounge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .order-container {
            background: #111;
            color: #fff;
            min-height: 100vh;
            padding: 30px 20px;
            font-family: 'Poppins', sans-serif;
        }

        .order-box {
            max-width: 500px;
            margin: 0 auto;
            background: linear-gradient(145deg, #1a1a1a, #222);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .order-box img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .order-box h2 {
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .order-box p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: none;
        }

        .btn-yellow {
            width: 100%;
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="order-container">
        <div class="order-box">
            <?php if ($food['image_name']) { ?>
                <img src="images/food/<?= $food['image_name']; ?>" alt="<?= $food['title']; ?>">
            <?php } ?>
            <h2><?= $food['title']; ?></h2>
            <p><?= $food['description']; ?></p>
            <p><strong>R$ <?= number_format($food['price'], 2, ',', '.'); ?></strong></p>

            <label>Quantidade:</label>
            <input type="number" id="qtd" min="1" value="1">

            <button class="btn btn-yellow" onclick="adicionarCarrinho()">Adicionar ao Carrinho</button>
            <a href="index.php" class="cancel-link">Cancelar</a>
        </div>
    </div>

    <script>
        const produto = {
            id: <?= $food['id']; ?>,
            title: "<?= addslashes($food['title']); ?>",
            price: <?= $food['price']; ?>,
            image: "<?= $food['image_name']; ?>"
        };

        function adicionarCarrinho() {
            const qtd = parseInt(document.getElementById('qtd').value) || 1;
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            const index = cart.findIndex(item => item.id === produto.id);
            if (index !== -1) {
                cart[index].quantity += qtd;
            } else {
                cart.push({
                    ...produto,
                    quantity: qtd
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            // Redireciona de volta para o index.php
            window.location.href = 'index.php';
        }
    </script>

</body>

</html>