<?php
include 'includes/header.php';
//require_once 'model/EspecialidadeModel.php'; // Certifique-se de incluir o modelo

//$especialidadeModel = new EspecialidadeModel();
//$especialidades = $especialidadeModel->getAllEspecialidades();
?>

<h2>Lista de Especialidades</h2>

<a href="?action=cadastrarEspecialidade">Cadastrar Nova Especialidade</a>

<?php if (isset($mensagem)): ?>
    <p><?php echo $mensagem; ?></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($especialidades)): ?>
            <?php foreach ($especialidades as $especialidade): ?>
                <tr>
                    <td><?php echo $especialidade->id; ?></td>
                    <td><?php echo htmlspecialchars($especialidade->nome); ?></td>
                    <td>
                        <a href="?action=editarEspecialidade&id=<?php echo $especialidade->id; ?>">Editar</a>
                        <a href="?action=excluirEspecialidade&id=<?php echo $especialidade->id; ?>" onclick="return confirm('Tem certeza?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Nenhuma especialidade cadastrada.</td>
            </tr>
        <?php endif; ?>

    </tbody>
</table>

<?php include 'includes/footer.php'; ?>