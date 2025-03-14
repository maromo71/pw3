<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Médicos</title>
    <!-- Adicione seus links para CSS aqui (se tiver) -->
    <!-- Exemplo: <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    <header>
        <h1>Sistema de Cadastro de Médicos</h1>
        <!--  Menu, se tiver  -->
        <?php if (isset($_SESSION['usuario'])): ?>
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="?action=listarMedicos">Listar Médicos</a></li>
                    <li><a href="?action=listarEspecialidades">Listar Especialidades</a></li>
                    <li><a href="?action=logout">Sair</a></li>
                </ul>
            </nav>
        <?php endif; ?>
    </header>
    <main>