<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>

    <div class="container custom">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <h2 class="titulo">Login</h2>
                <form action="../includes/login_process.php" method="post">
                    <div class="form-group">
                        <label for="username">Usuário:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary custom-button">Entrar</button>
                    <?php
                    if (isset($_GET['a'])) {
                        if ($_GET['a'] == 1) {
                            echo '<p class="wrong-password">Senha ou usuário incorretos!</p>';
                        }
                    }

                    ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>