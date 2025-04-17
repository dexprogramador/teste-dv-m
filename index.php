<?php include('partials-front/menu.php'); ?>

<!-- BOAS-VINDAS COM BG -->
<section class="food-search text-center">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: white; font-weight: bold; text-shadow: 1px 1px 5px black;">
            Bem-vindo à BK Tabacaria Delivery
        </h1>
        <p style="font-size: 1.2rem; color: white; margin-top: 10px; text-shadow: 1px 1px 5px black;">
            Peça sua essência, carvão, alumínio e acessórios aqui<br>
            e receba no conforto da sua casa.<br>
            Funcionamento: Segunda a Sábado, das 18:00 às 23:00
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
        <h2 class="text-center" style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700;">Escolha seu pedido na BK Lounge</h2>

        <?php
        // Buscar categorias ativas
        $sql_cat = "SELECT * FROM tbl_category WHERE active='Yes' ORDER BY title ASC";
        $res_cat = mysqli_query($conn, $sql_cat);

        if (mysqli_num_rows($res_cat) > 0) {
            while ($cat = mysqli_fetch_assoc($res_cat)) {
                $cat_id = $cat['id'];
                $cat_title = $cat['title'];
                echo "<h3 style='margin-top:40px; margin-bottom:20px; font-size:24px; font-weight:bold; font-family:Poppins, sans-serif; border-bottom: 2px solid #FFD700; padding-bottom: 5px;'>" . $cat_title . "</h3>";

                // Buscar produtos dessa categoria
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

                        <div class="food-menu-box" style="background: linear-gradient(to bottom right, rgba(255,255,255,0.07), rgba(0,0,0,0.07)); backdrop-filter: blur(5px); padding: 15px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                            <div class="food-menu-img">
                                <?php
                                if ($food_image == "") {
                                    echo "<div class='error'>Imagem não disponível</div>";
                                } else {
                                    echo "<img src='" . SITEURL . "images/food/" . $food_image . "' alt='" . $food_title . "' class='img-responsive img-curve' style='border-radius: 10px;'>";
                                }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #fff;"><?php echo $food_title; ?></h4>
                                <p class="food-price" style="font-size: 18px; font-weight: bold; color: #FFD700;">R$ <?php echo number_format($food_price, 2, ',', '.'); ?></p>
                                <p class="food-detail" style="color: #ddd; font-size: 14px;"> <?php echo $food_description; ?> </p>
                                <br>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $food_id; ?>" class="btn" style="background-color: #FFD700; color: #000; font-weight: bold; padding: 10px 20px; border-radius: 8px; text-decoration: none; transition: all 0.3s ease;">
                                    Adicionar ao Carrinho
                                </a>
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

<?php include('partials-front/footer.php'); ?>