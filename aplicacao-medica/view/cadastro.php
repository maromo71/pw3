<?php
include 'includes/header.php';

//Verifica se é edição
$medico = $medico ?? null;
$medicoId = $medicoId ?? null;
if (isset($medicoId) && $medicoId != null) {
    if ($medico == null) {
        header("Location: ?action=listarMedicos"); //Redireciona se id inválido
        exit;
    }
}
?>

<h2><?php echo $medico ? "Editar Médico" : "Cadastrar Médico"; ?></h2>

<form action="?action=<?php echo $medico ? "atualizarMedico" : "salvarMedico"; ?>" method="post">

    <?php if ($medico): ?>
        <input type="hidden" name="id" value="<?php echo $medico->id; ?>">
    <?php endif; ?>

    <div>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required value="<?php echo $medico ? htmlspecialchars($medico->nome) : ''; ?>">
    </div>
    <div>
        <label for="crm">CRM:</label>
        <input type="text" name="crm" id="crm" required value="<?php echo $medico ? htmlspecialchars($medico->crm) : ''; ?>">
    </div>
    <div>
        <label>Especialidades:</label><br>

        <?php foreach ($especialidades as $especialidade): ?>
            <input type="checkbox" name="especialidades[]"
                value="<?php echo $especialidade->id; ?>"
                id="especialidade_<?php echo $especialidade->id; ?>"
                <?php
                if ($medico) {
                    foreach ($medico->especialidades as $medEsp) {
                        if ($medEsp->id == $especialidade->id) {
                            echo 'checked';
                            break;
                        }
                    }
                }
                ?>>
            <label for="especialidade_<?php echo $especialidade->id; ?>"><?php echo htmlspecialchars($especialidade->nome); ?></label><br>
        <?php endforeach; ?>

    </div>
    <button type="submit"><?php echo $medico ? "Atualizar" : "Salvar"; ?></button>
</form>

<?php include 'includes/footer.php'; ?>