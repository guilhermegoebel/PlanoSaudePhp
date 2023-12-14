<?php
include '../includes/database.php';

session_start();

if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("Location: login.php");
    exit;
}   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $sexo = $_POST["sexo"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $dt_nascimento = $_POST["dt_nascimento"];
    $local_nascimento = $_POST["local_nascimento"];
    $endereco = $_POST["endereco"];
    $empresa = $_POST["empresa"];
    $tipo_plano = $_POST["tipo_plano"];


    $sqlInserir = "INSERT INTO cliente (nome, sexo, email, telefone, dt_nascimento, local_nascimento, endereco, empresa, tipo_plano) 
                   VALUES ('$nome', '$sexo', '$email', '$telefone', '$dt_nascimento', '$local_nascimento', '$endereco', '$empresa', '$tipo_plano')";

    if (mysqli_query($db, $sqlInserir)) {
        header("Location: client_list.php");
        exit;
    } else {
        echo "Erro na inserção: " . mysqli_error($db);
    }
}

$sql = "SELECT * FROM cliente ORDER BY nome";

$result = mysqli_query($db, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/client_list.css">
    
</head>

<body>
    <header>
        <?php include '../includes/header.php'; ?>
    </header>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="clientes">Clientes</h1>
                <button type="button" class="btn btn-primary custom-button" data-bs-toggle="modal" data-bs-target="#novoClienteModal">Novo Cliente</button>
                <div class="table-container mx-auto">
                    <div class="table-responsive">
                        <?php
                        if ($result) {
                            echo '<table class="table table-bordered custom-table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Nome</th>';
                            echo '<th>Plano</th>';
                            echo '<th style="background-color: white;"> </th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td class="nome">' . $row['nome'] . '</td>';
                                echo '<td class="plano">' . $row['tipo_plano'] . '</td>';
                                echo '<td><a href="client_details.php?id=' . $row['id'] . '" class="btn btn-transparent" style="border:none;"><i class="bi bi-eye"></i></a></td>';
                                echo '</tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo "Erro na consulta: " . mysqli_error($db);
                        }
                        mysqli_close($db);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php include '../includes/footer.php'; ?>
    </footer>

    <?php include '../includes/create_client_modal.php' ?>
                 
    
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>