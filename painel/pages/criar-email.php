<div class="box-content">
    <?php
    if (isset($_POST['acao'])) {
        $conteudo = $_POST['conteudo'];
        $assunto = $_POST['assunto'];
        $contatos = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.contatos` WHERE lista_id = ?");
        $contatos->execute(array($_POST['lista_id']));
        $contatos = $contatos->fetchAll();
        foreach ($contatos as $key => $value) {
            $mail = new \Email('smtp.hostinger.com', 'contato@amazonasdev.com', 'Vivaldojunior01.', 'Vivaldo');
            $mail->formatarEmail(array('assunto' => $assunto, 'corpo' => $conteudo));
            $email_atual = $value['email'];
            $mail->addAdress($email_atual, '');
            $mail->enviarEmail();
            sleep(1);
        }
        Painel::alert('sucesso', 'E-mail enviado com sucesso!');
    }

    ?>

    <h2><i class="fa fa-pencil"></i> Enviar e-mail para lista</h2>

    <form method="post">

        <div class="form-group">
            <label>Escolha a lista:</label>
            <select name="lista_id">
                <?php
                $listas = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.listas_email`");
                $listas->execute();
                $listas = $listas->fetchAll();
                foreach ($listas as $key => $value) {
                ?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value['nome_lista'] ?></option>
                <?php } ?>
            </select>
        </div>
        <!--form-group-->
        <div class="form-group">
            <label>Assunto:</label>
            <input type="text" name="assunto">
        </div>
        <div class="form-group">
            <label>Texto do seu e-mail:</label>
            <textarea name="conteudo"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" name="acao" value="Disparar!">
        </div>
        <!--form-group-->
    </form>
</div>