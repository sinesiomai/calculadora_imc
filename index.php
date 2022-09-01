<?php
    require_once("app/Models/Usuario.php");
    require_once("app/Controllers/ControllerUsuario.php");

    $usuarioDao = new ControllerUsuario();

    if ( !empty($_POST['nome']) &&  !empty($_POST['sexo']) && !empty($_POST['idade']) &&
    !empty($_POST['peso']) && !empty($_POST['altura'])) {
        //setando variáveis
        $nome = $_POST['nome'];
        $sexo = $_POST['sexo'];
        $idade = $_POST['idade'];
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];
        $usuario = new Usuario($nome, $sexo, $idade, $peso, $altura);

        // echo "<pre>".var_dump($usuario)."</pre>"; //mostrar o objeto criado se foi criado de fato
        // var_dump($usuario);

        $usuario->validarDados();
        if (empty($usuario->erro)) {
            if ($usuario->getMsg() == "Abaixo do peso") {
                $class = "alert-danger";
            } elseif ($usuario->getMsg() == "Peso Normal") {
                $class = "alert-success";
            } elseif ($usuario->getMsg() == "Sobrepeso") {
                $class = "alert-warning";
            } else {
                $class = "alert-danger";
            }
            $usuarioDao->createUsuario($usuario);
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-5">
    <div class="container border border-2 rounded-4 p-4 bg-white mb-5" style="max-width: 600px;">
        <!--formulário-->
        <form method="POST">
            <h1 class="mb-4 text-center">Calculadora IMC</h1>
            <div class="row">
                <div class="mb-3">
                    <label for="nome" class="form-label fw-bold">Informe seu nome</label>
                    <input type="text" name="nome" class="form-control form-control-lg bg-light" value="" required>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="sexo" class="form-label fw-bold">Sexo</label>
                    <select name="sexo" id="sexo" class="form-select form-select-lg bg-light" required>
                        <option value="">--</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="idade" class="form-label fw-bold">Idade</label>
                    <input type="text" name="idade" class="form-control form-control-lg bg-light" value="" required>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="peso" class="form-label fw-bold">Informe seu peso (kg)</label>
                    <input type="text" name="peso" class="form-control form-control-lg bg-light" value="" required>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="altura" class="form-label fw-bold">Informe sua altura (metro e cm)</label>
                    <input type="text" name="altura" class="form-control form-control-lg bg-light" value="" required>
                </div>
            </div>
            <div class="d-grid mb-4">
                <input type="submit" value="Calcular" class="btn btn-primary btn-lg">
            </div>

            <?php if (isset($usuario) && empty($usuario->erro)) {?>
            <div class="alert text-center fs-4 <?php echo $class?>" role="alert">
                <span class="d-block fw-bold">IMC: <?php echo round($usuario->getImc(), 2);?></span>
                <span> <?php echo $usuario->getMsg();?></span>
            </div>
            <?php }?>
        </form>
    </div>
    <?php if($usuarioDao->readUsuario()){ ?>
        <div class="container">
            <h1>Registros</h1>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th>Peso</th>
                        <th>Altura</th>
                        <th>IMC</th>
                        <th>Data Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarioDao->readUsuario() as $usuarios) {?>
                        <tr>
                            <td><?php echo $usuarios["nome"] ?> </td>
                            <td><?php echo $usuarios["sexo"] ?> </td>
                            <td><?php echo $usuarios["idade"] ?> </td>
                            <td><?php echo $usuarios["peso"] ?> </td>
                            <td><?php echo $usuarios["altura"] ?> </td>
                            <td><?php echo $usuarios["imc"] ?> </td>
                            <td><?php echo date('d/m/y', strtotime ($usuarios ["data_registro"] ))?> </td>
                        </tr>
                </tbody>
        </div>
        <?php } ?>
        <?php } ?>

    

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>