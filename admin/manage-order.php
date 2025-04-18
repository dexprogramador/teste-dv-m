<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Pedidos Recebidos</h1>
        <br><br>

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>WhatsApp</th>
                <th>Tipo</th>
                <th>Endereço</th>
                <th>Pagamento</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Data</th>
            </tr>

            <?php
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);
                $sn = 1;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $nome = $row['nome'];
                        $whatsapp = $row['whatsapp'];
                        $tipo = $row['tipo_pedido'];
                        $pagamento = $row['pagamento'];
                        $endereco = $tipo == 'Delivery' ? $row['endereco'] . ', Nº ' . $row['numero'] . ' - ' . $row['bairro'] : 'Retirada na Loja';
                        $referencia = $row['referencia'];
                        if ($referencia) {
                            $endereco .= "<br><small>Ref: $referencia</small>";
                        }
                        $itens = nl2br($row['itens']);
                        $total = 'R$ ' . number_format($row['total'], 2, ',', '.');
                        $data = date('d/m/Y H:i', strtotime($row['data_pedido']));
            ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $whatsapp; ?></td>
                            <td><?php echo $tipo; ?></td>
                            <td><?php echo $endereco; ?></td>
                            <td><?php echo $pagamento; ?></td>
                            <td><?php echo $itens; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $data; ?></td>
                        </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='9' class='error'>Nenhum pedido encontrado.</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>