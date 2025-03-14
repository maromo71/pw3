<?php include 'includes/header.php'; ?>

<h2><?php echo isset($especialidade) ? 'Editar Especialidade' : 'Cadastrar Especialidade'; ?></h2>

<form action="?action=<?php echo isset($especialidade) ? 'atualizarEspecialidade' : 'salvarEspecialidade'; ?>" method="post">

    <?php if (isset($especialidade)): ?>
        <input type="hidden" name="id" value="<?php echo $especialidade->id; ?>">
    <?php endif; ?>

    <div>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required value="<?php echo isset($especialidade) ? htmlspecialchars($especialidade->nome) : ''; ?>">
    </div>
    <button type="submit"><?php echo isset($especialidade) ? 'Atualizar' : 'Salvar'; ?></button>
</form>

<?php include 'includes/footer.php'; ?>