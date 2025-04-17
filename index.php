<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Buscar produto..." required>
            <input type="submit" name="submit" value="Buscar" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php
if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}
?>

<!-- PRODUTOS AGRUPADOS POR CATEGORIA -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Escolha seu pedido na BK Lounge</h2>

        <?php
        // Buscar categorias ativas
        $sql_cat = "SELECT * FROM tbl_category WHERE active='Yes' ORDER BY title ASC";
        $res_cat = mysqli_query($conn, $sql_cat);

        if (mysqli_num_rows($res_cat) > 0) {
            while ($cat = mysqli_fetch_assoc($res_cat)) {
                $cat_id = $cat['id'];
                $cat_title = $cat['title'];
                echo "<h3 style='margin-top:40px; margin-bottom:15px; font-size:24px; font-weight:bold; color:#333;'>" . $cat_title . "</h3>";

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

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                if ($food_image == "") {
                                    echo "<div class='error'>Imagem não disponível</div>";
                                } else {
                                    echo "<img src='" . SITEURL . "images/food/" . $food_image . "' alt='" . $food_title . "' class='img-responsive img-curve'>";
                                }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $food_title; ?></h4>
                                <p class="food-price">R$ <?php echo number_format($food_price, 2, ',', '.'); ?></p>
                                <p class="food-detail"><?php echo $food_description; ?></p>
                                <br>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Fazer Pedido</a>
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