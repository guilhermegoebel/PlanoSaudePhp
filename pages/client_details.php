<?php
include '../includes/database.php';
session_start();

if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $parentesco = $_POST["parentesco"];
        $titular = $id;

        $sqlInserir = "INSERT INTO dependentes (nome, titular, parentesco) 
                       VALUES ('$nome', '$titular', '$parentesco')";

        if (mysqli_query($db, $sqlInserir)) {
            header("Location: client_details.php?id=$id");
            exit;
        } else {
            echo "Erro na inserção: " . mysqli_error($db);
        }
    }

    if (isset($_GET['delete_dependent'])) {
        $dependent_id = $_GET['delete_dependent'];

        $sqlDeleteDependent = "DELETE FROM dependentes WHERE id = $dependent_id";
        $resultDeleteDependent = mysqli_query($db, $sqlDeleteDependent);

        if ($resultDeleteDependent) {
            header("Location: client_details.php?id=$id");
            exit;
        } else {
            echo "Erro ao excluir o dependente.";
        }
    }

    if (isset($_GET['delete_client'])) {

        $sqlDeleteClient = "DELETE FROM cliente WHERE id = $id";
        $resultDeleteClient = mysqli_query($db, $sqlDeleteClient);

        if ($resultDeleteClient) {
            header("Location: client_list.php");
            exit;
        } else {
            echo "Erro ao excluir o cliente.";
        }
    }

    $sql = "SELECT * FROM cliente WHERE id = $id";

    $result = mysqli_query($db, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $cliente = mysqli_fetch_assoc($result);

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalhes do Cliente</title>
            <link rel="stylesheet" href="../css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../css/client_details.css">
        </head>

        <body>
            <header>
                <?php include '../includes/header.php'; ?>
            </header>
            <div class="container custom-div">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="cliente">Cliente</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="titulo">Dados</h2>
                        <div class="linha-cinza"></div>
                        <div class="dados-cliente">
                            <p><strong>Nome:</strong> <?php echo $cliente['nome']; ?></p>
                            <p><strong>Sexo:</strong> <?php echo $cliente['sexo']; ?></p>
                            <p><strong>Email:</strong> <?php echo $cliente['email']; ?></p>
                            <p><strong>Data de Nascimento:</strong> <?php echo $cliente['dt_nascimento']; ?></p>
                            <?php
                            $dtf = date('Y-m-d', strtotime(str_replace('/', '-', $cliente['dt_nascimento'])));
                            $dt = new DateTime($dtf);
                            $today = new DateTime();
                            $idade = $today->diff($dt)->y;
                            ?>
                            <p><strong>Idade:</strong> <?php echo $idade . ' anos'; ?></p>

                            <p><strong>Local de Nascimento:</strong> <?php echo $cliente['local_nascimento']; ?></p>
                            <p><strong>Telefone:</strong> <?php echo $cliente['telefone']; ?></p>
                            <p><strong>Empresa:</strong> <?php echo $cliente['empresa']; ?></p>
                            <p><strong>Endereço:</strong> <?php echo $cliente['endereco']; ?></p>
                            <p><strong>Plano:</strong> <?php echo $cliente['tipo_plano']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="titulo">Dependentes</h2>
                        <div class="linha-cinza"></div>
                        <div class="dependentes">

                            <?php

                            $sqlDependentes = "SELECT * FROM dependentes WHERE titular = $id";
                            $resultDependentes = mysqli_query($db, $sqlDependentes);

                            if ($resultDependentes && mysqli_num_rows($resultDependentes) > 0) {
                                while ($dependente = mysqli_fetch_assoc($resultDependentes)) {
                                    echo '<div class="dependente">';
                                    echo '<p class="nome"> ' . $dependente['nome'] . '</p>';
                                    echo '<p class="parentesco"> ' . $dependente['parentesco'] . '</p>';
                                    echo '<button type="button" class="btn btn-transparent" style="border:none;" data-bs-toggle="modal" data-bs-target="#confirmDeleteDependent' . $dependente['id'] . '"><i class="bi bi-trash"></i></button>';
                                    echo '</div>';
                                }
                            } else {
                                echo "Nenhum dependente encontrado.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <div class="buttons-footer">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Excluir Cliente</button>
                    <button type="button" class="btn btn-primary button-dependent" data-bs-toggle="modal" data-bs-target="#novoDependenteModal">Cadastrar Dependente</button>
                    <a class="btn btn-primary back-button" href="client_list.php">Voltar</a>
                </div>
                <?php include '../includes/footer.php' ?>
            </footer>

            <?php include '../includes/create_dependent_modal.php' ?>

            <?php include '../includes/delete_client_modal.php' ?>

            <?php

            $sqlDependentes = "SELECT * FROM dependentes WHERE titular = $id";
            $resultDependentes = mysqli_query($db, $sqlDependentes);

            if ($resultDependentes && mysqli_num_rows($resultDependentes) > 0) {
                while ($dependente = mysqli_fetch_assoc($resultDependentes)) {
                    $dependenteId = $dependente['id'];
                    echo '<div class="modal fade" id="confirmDeleteDependent' . $dependenteId . '" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteDependentLabel' . $dependenteId . '" aria-hidden="true">';
                    echo '<div class="modal-dialog" role="document">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="confirmDeleteDependentLabel' . $dependenteId . '">Excluir Dependente</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo 'Tem certeza de que deseja excluir este dependente?';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>';
                    echo '<form method="GET" action="client_details.php">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<input type="hidden" name="delete_dependent" value="' . $dependente['id'] . '">';
                    echo '<button type="submit" class="btn btn-danger">Confirmar Exclusão</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } 
            ?>

            <script src="../js/bootstrap.min.js"></script>
        </body>

        </html>
<?php
    } else {
        echo "Cliente não encontrado.";
    }
} else {
    echo "Id não especificado!";
}

mysqli_close($db);
?>