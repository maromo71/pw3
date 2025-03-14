<?php include 'includes/header.php'; ?>

<h2>Lista de Médicos</h2>

<a href="?action=cadastrarMedico">Cadastrar Novo Médico</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CRM</th>
            <th>Especialidades</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medicos as $medico): ?>
            <tr>
                <td><?php echo $medico->id; ?></td>
                <td><?php echo htmlspecialchars($medico->nome); ?></td>
                <td><?php echo htmlspecialchars($medico->crm); ?></td>
                <td>
                    <?php
                    $nomesEspecialidades = array_map(function ($e) {
                        return htmlspecialchars($e->nome);
                    }, $medico->especialidades);
                    echo implode(', ', $nomesEspecialidades);
                    ?>

                </td>
                <td>
                    <a href="?action=editarMedico&id=<?php echo $medico->id; ?>">Editar</a>
                    <a href="?action=excluirMedico&id=<?php echo $medico->id; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>