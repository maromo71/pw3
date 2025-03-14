<?php include 'includes/header.php'; ?>

<h2>Login</h2>

<?php if (isset($erro)): ?>
    <p style="color: red;"><?php echo $erro; ?></p>
<?php endif; ?>

<form action="?action=login" method="post">
    <div>
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required>
    </div>
    <div>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
    </div>
    <button type="submit">Entrar</button>
</form>

<?php include 'includes/footer.php'; ?>