<?php
session_start();
include('config/constants.php');

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $description = $row['description'];
        $image_name = $row['image_name'];
    } else {
        header('location: index.php');
    }
} else {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - BK Tabacaria</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body style="background: url('images/bg-grafite.jpg') no-repeat center center; background-size: cover; color: white; font-family: 'Poppins', sans-serif;">

    <div class="container" style="margin-top: 100px; max-width: 600px; background-color: rgba(0,0,0,0.7); padding: 20px; border-radius: 15px;">
        <div style="text-align: center;">
            <?php
            if ($image_name != "") {
                echo "<img src='images/food/$image_name' alt='$title' style='width: 100%; border-radius: 10px; margin-bottom: 15px;'>";
            } else {
                echo "<div class='error'>Imagem não disponível</div>";
            }
            ?>
            <h2 style="margin-bottom: 10px; font-weight: 700;"><?php echo $title; ?></h2>
            <p style="margin-bottom: 10px; font-size: 14px; color: #ddd;"><?php echo $description; ?></p>
            <p style="font-weight: bold; color: #ffc107; font-size: 18px;">R$ <?php echo number_format($price, 2, ',', '.'); ?></p>

            <form id="cart-form">
                <label for="qty" style="font-weight: 600;">Quantidade:</label>
                <input type="number" id="qty" name="qty" value="1" min="1" required style="width: 60px; padding: 5px; margin: 10px;">
                <br>
                <button type="button" class="btn btn-yellow" onclick="addToCart(<?php echo $food_id; ?>)">Adicionar ao Carrinho</button>
                <a href="index.php" class="btn btn" style="margin-left: 10px; background-color: #555; color: white;">Cancelar</a>
            </form>
        </div>
    </div>

    <script>
        function addToCart(foodId) {
            const qty = parseInt(document.getElementById('qty').value);
            let cart = JSON.parse(localStorage.getItem('bk_cart')) || [];

            const existingItem = cart.find(item => item.id === foodId);

            if (existingItem) {
                existingItem.qty += qty;
            } else {
                cart.push({
                    id: foodId,
                    qty: qty
                });
            }

            localStorage.setItem('bk_cart', JSON.stringify(cart));
            alert('Item adicionado ao carrinho!');
            window.location.href = 'index.php';
        }
    </script>
</body>

</html>