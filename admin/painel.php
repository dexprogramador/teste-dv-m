<?php include('partials/menu.php'); ?>
<?php include('../config/constants.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1 style="margin-bottom: 20px;">📦 Pedidos Recebidos - Hoje</h1>

    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>WhatsApp</th>
          <th>Tipo</th>
          <th>Endereço</th>
          <th>Itens</th>
          <th>Total</th>
          <th>Pagamento</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $hoje = date('Y-m-d');
        $sql = "SELECT * FROM tbl_order WHERE DATE(data_pedido) = '$hoje' ORDER BY id DESC";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $nome = $row['nome'];
            $whatsapp = $row['whatsapp'];
            $tipo = $row['tipo_pedido'];
            $endereco = $row['endereco'] . ', ' . $row['numero'] . ' - ' . $row['bairro'];
            $itens = nl2br($row['itens']);
            $total = 'R$ ' . number_format($row['total'], 2, ',', '.');
            $pagamento = $row['pagamento'];
            $status = isset($row['status']) ? $row['status'] : 'Novo';

            $statusClass = strtolower($status);

            echo "<tr>
              <td>$id</td>
              <td>$nome</td>
              <td><a href='https://wa.me/55$whatsapp' target='_blank'>📱 $whatsapp</a></td>
              <td>$tipo</td>
              <td>$endereco</td>
              <td>$itens</td>
              <td>$total</td>
              <td>$pagamento</td>
              <td><span class='status $statusClass'>$status</span></td>
              <td class='acoes'>
                <button onclick=\"alterarStatus($id, 'Aceito')\" class='btn-secondary'>✅ Aceitar</button>
                <button onclick=\"alterarStatus($id, 'Recusado')\" class='btn-danger'>❌ Recusar</button>
                <button onclick=\"imprimirPedido($id)\" class='btn-primary'>🖨️ Imprimir</button>";
            if ($status == 'Aceito') {
              echo "<button onclick=\"alterarStatus($id, 'Pronto')\" class='btn-success'>🚚 Pronto p/ Entrega</button>";
            }
            echo "</td></tr>";
          }
        } else {
          echo "<tr><td colspan='10' class='error'>Nenhum pedido hoje.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<style>
  .styled-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 14px;
  }

  .styled-table th,
  .styled-table td {
    border: 1px solid #ddd;
    padding: 10px;
    vertical-align: top;
    text-align: left;
  }

  .styled-table th {
    background-color: #333;
    color: #fff;
  }

  .status {
    padding: 5px 10px;
    border-radius: 10px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 12px;
  }

  .status.novo {
    background-color: #ffc107;
    color: #000;
  }

  .status.aceito {
    background-color: #28a745;
    color: #fff;
  }

  .status.recusado {
    background-color: #dc3545;
    color: #fff;
  }

  .status.pronto {
    background-color: #17a2b8;
    color: #fff;
  }

  .acoes button {
    display: block;
    margin-bottom: 6px;
    padding: 6px 10px;
    text-align: center;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    width: 100%;
  }

  .btn-secondary {
    background-color: #6c757d;
  }

  .btn-danger {
    background-color: #dc3545;
  }

  .btn-primary {
    background-color: #007bff;
  }

  .btn-success {
    background-color: #28a745;
  }

  .error {
    text-align: center;
    color: red;
    font-weight: bold;
  }
</style>

<script>
  function alterarStatus(id, status) {
    fetch('mudar_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&status=${encodeURIComponent(status)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert('Erro: ' + data.message);
        }
      })
      .catch(() => alert('Falha na conexão com o servidor.'));
  }

  function imprimirPedido(id) {
    window.open(`imprimir_pedido.php?id=${id}`, '_blank');
  }

  // Checagem de novos pedidos
  setInterval(() => {
    fetch('check_novos_pedidos.php')
      .then(res => res.json())
      .then(data => {
        if (data.novo) {
          const audio = new Audio('assets/audio/sininho.mp3');
          audio.play();
          location.reload();
        }
      });
  }, 15000);
</script>

<?php include('partials/footer.php'); ?>