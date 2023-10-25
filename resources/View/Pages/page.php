<?php
require_once '..\..\..\app\Controller\Pages\Autenticacao.php';

use \App\Controller\Pages\Autenticacao;

require '..\..\..\vendor\autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$Autenticacao = new Autenticacao;
$token_decode = new JWT();
$token = null;
if ($_COOKIE['token']) {
    $token = $_COOKIE['token'];
}

if ($token == null) {
    // Redireciona o usuário para a página de login
    header("Location: Login.php");
    exit();
}

// echo $token;
$chaveSecreta = 'sua_chave_secreta';
$decoded = JWT::decode($token, new Key($chaveSecreta, 'HS256'));


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skyllsync</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <header>

        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <img src="..\Assets\logo.png" alt="Logo da Empresa" width="100" height="100">
                    <strong>Skillsync</strong>
                </a>
                <!--            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">-->
                <!--                <span class="navbar-toggler-icon"></span>-->
                <!--                <button type="button" class="btn btn-primary">Primary</button>-->
                <!--            </button>-->
                <div class="navbar-toggler" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <a href="Logout.php" id="logoutLink">
                        <button type="button" class="btn btn-primary">Logout</button>
                    </a>
                </div>



            </div>
        </div>
    </header>


    <main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <!-- <h1 class="jumbotron-heading">Album example</h1>
            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
            <p> -->
                <?php
                if ($decoded->nivel == 1) {
                    echo '<a href="page.php?arquivo=CadastrarServiço&id=" class="btn btn-primary my-2">Meus Serviços</a>';
                    echo '<a href="page.php?arquivo=Home&id=" class="btn btn-secondary my-2">Buscar um serviço</a>';
                }
                ?>
                </p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <?php
                $arquivo = $_GET["arquivo"] ?? "Home";


                if (file_exists($arquivo . ".php")) {
                    include $arquivo . ".php";
                } else {
                    include "Home.php";
                }

                ?>


            </div>
        </div>
    </main>

    <footer class="container py-5">
        <div class="row">
            <div class="col-12 col-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                    <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                    <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                    <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                    <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                    <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                </svg>
                <small class="d-block mb-3 text-muted">© 2023</small>
            </div>
            <div class="col-6 col-md">
                <h5>Recursos</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Recursos legais</a></li>
                    <li><a class="text-muted" href="#">Recurso aleatório</a></li>
                    <li><a class="text-muted" href="#">Recurso da equipe</a></li>
                    <li><a class="text-muted" href="#">Coisas para desenvolvedores</a></li>
                    <li><a class="text-muted" href="#">Outro</a></li>
                    <li><a class="text-muted" href="#">Última vez</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Recursos</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Recurso</a></li>
                    <li><a class="text-muted" href="#">Nome do recurso</a></li>
                    <li><a class="text-muted" href="#">Outro recurso</a></li>
                    <li><a class="text-muted" href="#">Recurso final</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Sobre</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Equipe</a></li>
                    <li><a class="text-muted" href="#">Localizações</a></li>
                    <li><a class="text-muted" href="#">Privacidade</a></li>
                    <li><a class="text-muted" href="#">Termos</a></li>
                </ul>
            </div>
        </div>
    </footer>


</body>

</html>