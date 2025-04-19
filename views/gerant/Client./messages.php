<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
} ?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Messages des clients</h1>
            <ol class="breadcrumb mb-4">
                <!-- <li class="breadcrumb-item active">Nom de l'utilisateur</li> -->
            </ol>
            <div class="row">

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $Message = new email();
                    $Message->sendMessage($_POST);
                    Client::update($_POST['id'], ['reponse' => $_POST['contenue']]);
                }
                ?>
                <!--message -->
                <?php $data = Client::getNewMessages($_SESSION['agence_id']);
                foreach ($data as $key => $value) { ?>
                    <div class="col-md-6">
                        <form action="" method="POST" class="d-flex">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center">
                                    <img src="<?= $data[$key]['photo'] ?>" alt="Avatar du USER " class="rounded-circle me-3" width="50" height="50">
                                    <div>
                                        <h5 class="mb-$key"><?= $data[$key]['prenom'] . ' ' . $data[$key]['nom'] ?></h5>
                                        <small class="text-muted"><?= $data[$key]['date'] ?></small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p><?= $data[$key]['message'] ?></p>
                                </div>
                                <input type="hidden" name="prenom" value="<?= $data[$key]['prenom'] ?>">
                                <input type="hidden" name="sujet" value="Reponse equipe support WeLoc">
                                <input type="hidden" name="nom" value="<?= $data[$key]['nom'] ?>">
                                <input type="hidden" name="id" value="<?= $data[$key]['id'] ?>">
                                <input type="hidden" name="email" value="<?= $data[$key]['email'] ?>">
                                <div class="card-footer">
                                    <textarea name="contenue" class="form-control me-2" placeholder="Répondre" rows="1" required></textarea>
                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
                <!--/message -->
            </div>
        </div>
    </main>

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy;WeLoc 2025</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- /code -->

<!-- footer -->
<?php include_once(".././pages_sections/footer.php"); ?>
<!-- /footer -->