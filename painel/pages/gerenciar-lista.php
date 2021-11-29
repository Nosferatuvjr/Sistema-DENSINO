<div class="box-content">
    <?php
    if (isset($_POST['acao'])) {
        $nome_lista = $_POST['nome_lista'];
        $sql = \MySql::conectar()->prepare("INSERT INTO `tb_admin.listas_email` VALUES (null,?)");
        $sql->execute(array($nome_lista));
        Painel::alert('sucesso', 'A lista foi criada com sucesso!');
    }
    ?>
    <h2><i class="fa fa-pencil"></i> Adicionar nova lista</h2>

    <form method="post">
        <div class="form-group">
            <label>Nome da Lista:</label>
            <input type="text" name="nome_lista">
        </div>
        <!--form-group-->
        <div class="form-group">
            <input type="submit" name="acao" value="Adicionar lista!">
        </div>
        <!--form-group-->
    </form>

    <h2><i class="fa fa-pencil"></i> Listas Disponíveis</h2>
    <div class="wraper-table">
        <table>
            <tr>
                <td>Nome</td>
                <td>#</td>
            </tr>

            <?php
            $listas = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.listas_email`");
            $listas->execute();
            $listas = $listas->fetchAll();
            foreach ($listas as $key => $value) {
            ?>
                <tr>
                    <td><?php echo $value['nome_lista']; ?></td>
                    <!-- <td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-lista?excluir=<?php echo $value['id']; ?>"><i class="fa fa-times"></i> Excluir</a></td> -->
                </tr>
            <?php } ?>
        </table>
    </div>
</div>