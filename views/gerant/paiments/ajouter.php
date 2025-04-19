<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paiement = new Paiement();
    if (!Reservation::is_id(intval($_POST['id_reservation']), $_SESSION['agence_id'])) {
        echo 'id_reservation invalide';
        die();
    }
    if (!Paiement::is_transac(intval($_POST['id_transaction']), $_SESSION['agence_id'])) {
        echo 'id_transaction invalide';
        die();
    }
    $paiement->add([
        'id_reservation' => intval($_POST['id_reservation']),
        'montant' => floatval($_POST['montant']) ?? '',
        'mode_paiement' =>  $_POST['mode_paiement'] ?? '',
        'statut' => $_POST['statut'] ?? '',
        'date_paiement' => date('Y-m-d', strtotime($_POST['date_paiement'])) ?? '',
        'transaction_id' =>  intval($_POST['id_transaction']),
    ]);
}
?>

<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container more-voiture">
            <div class="row mb-4 align-items-center">
                <!-- Informations de paiement -->
                <div class="col-lg-6 col-md-8 col-sm-12 sub-container mb-3 card p-4">
                    <form action="./ajouter.php" method="post">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="id_reservation"><strong>ID réservation :</strong></label>
                            </div>
                            <div class="col-8">
                                <input type="number" id="id_reservation" class="form-control" min="0" name="id_reservation">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="id_transaction"><strong>ID transaction :</strong></label>
                            </div>
                            <div class="col-8">
                                <input type="number" id="id_transaction" class="form-control" min="0" name="id_transaction">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="date_paiement"><strong>Date :</strong></label>
                            </div>
                            <div class="col-8">
                                <input type="date" id="date_paiement" name="date_paiement" class="form-control" value="<?= date('Y-d-m', time()) ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="montant"><strong>Montant :</strong></label>
                            </div>
                            <div class="col-8">
                                <input type="number" id="montant" class="form-control" min="25000" name="montant">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="status"><strong>Status :</strong></label>
                            </div>
                            <div class="col-8">
                                <select id="status" class="form-control" name="statut">
                                    <option value="en_attente">En attente</option>
                                    <option value="complete">Complète</option>
                                    <option value="echec">Échec</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="mode_paiement"><strong>Mode de paiement :</strong></label>
                            </div>
                            <div class="col-8">
                                <select id="mode_paiement" class="form-control" name="mode_paiement">
                                    <option value="carte">Carte</option>
                                    <option value="espece">Espèce</option>
                                    <option value="virement">Virement</option>
                                </select>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="row mb-3 text-center">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger w-100" onclick="if(!confirm('Voulez-vous annuler ?')){event.preventDefault();}">
                                    <i class="fas fa-times"></i>&nbsp;<strong>Annuler</strong>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100" onclick="if(!confirm('Voulez-vous l\'ajouter ?')){event.preventDefault();}">
                                    <i class="fas fa-save"></i>&nbsp;<strong>Ajouter</strong>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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