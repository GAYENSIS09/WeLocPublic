<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['envoyer'])) {
        $facture = new Facture();
        $data = $_POST;
        $array = [
            'id_paiement' => intval($data['id_paiement']),
            'date_emission' => date('Y-m-d', time()),
            'montant_total' => floatval($data['p_tot_location']) + floatval($data['p_tot_reservation']) + floatval($data['p_tot_sup']),
            'pdf_path' => "http://www/public/factures/facture_" . $data['id_paiement'] . ".pdf" ?? '',
        ];
        if (!Paiement::is_id(intval($data['id_paiement']), $_SESSION['agence_id'])) {
            echo 'id_paiement invalide';
            die();
        }
        $facture->add($array);
        $data['id'] = $facture->getLastId();
        foreach ($array as $name => $value) {
            $data[$name] = $value;
        }
        $userInfo = $facture->getUserInfo($data['id_paiement']);
        $data['nom'] = $userInfo[0]['nom'];
        $data['prenom'] = $userInfo[0]['prenom'];
        $data['email'] = $userInfo[0]['email'];
        $mail = new email();
        $mail->sendFacture($data);
    }
    header('Location:./liste.php');
    exit();
}
?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <form action="./generee.php" method="post">
                <h1 class="mt-4">
                    Envoie de Facture
                </h1>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Informations de base
                            </div>
                            <div class="card-body">

                                <div class="row mb-3 mt-1">
                                    <div class="col-4"><label for="id_paiement"><strong>ID paiement :</strong></label></div>
                                    <div class="col-8"><input type="number" id="id_paiement" name="id_paiement" class="form-control" min="0"></div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4"><label for="id_transaction"><strong>Date de depart :</strong></label></div>
                                    <div class="col-8"><input type="date" id="date_depart" name="date_depart" class="form-control" min="0"></div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4"><strong>Date d'arrivée:</strong></label></div>
                                    <div class="col-8"><input type="date" id="date_arrivee" name="date_arrivee" class="form-control" value="2022-11-09"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Prix de Réservation
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 mt-1">
                                    <div class="col-4"><label for="qte_reservation"><strong>Quantité :</strong></label></div>
                                    <div class="col-8"><input type="number" id="qte_reservation" name="qte_reservation" class="form-control" min="0"></div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4"><label for="p_unit"><strong>prix unitaire:</strong></label></div>
                                    <div class="col-8"><input type="number" id="p_unit_reservation" name="p_unit_reservation" class="form-control" min="0"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4"><label for="p_tot"><strong>Prix totale:</strong></label></div>
                                    <div class="col-8"><input type="number" id="p_tot_reservation" name="p_tot_reservation" class="form-control" value="2022-12-04" min='25000'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                prix location
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 mt-1">
                                    <div class="col-4"><label for="qte_location"><strong>Quantité :</strong></label></div>
                                    <div class="col-8"><input type="number" id="qte_location" name="qte_location" class="form-control" min="0"></div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4"><label for="p_unit"><strong>prix unitaire:</strong></label></div>
                                    <div class="col-8"><input type="number" id="p_unit_location" name="p_unit_location" class="form-control" min="0"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4"><label for="p_tot"><strong>Prix totale:</strong></label></div>
                                    <div class="col-8"><input type="number" id="p_tot_location" name="p_tot_location" class="form-control" value="2022-12-04" min='25000'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                supplement(s)
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 mt-1">
                                    <div class="col-4"><label for="qte_sup"><strong>Quantité :</strong></label></div>
                                    <div class="col-8"><input type="number" id="qte_sup" name="qte_sup" class="form-control" min="0"></div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4"><label for="p_unit"><strong>prix unitaire:</strong></label></div>
                                    <div class="col-8"><input type="number" id="p_unit_sup" name="p_unit_sup" class="form-control" min="0"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4"><label for="p_tot"><strong>Prix totale:</strong></label></div>
                                    <div class="col-8"><input type="number" id="p_tot_sup" name="p_tot_sup" class="form-control" value="2022-12-04" min='25000'></div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row mb-3 text-center">
                        <div class="col-2">
                            <button type="submit" name="envoyer" class="btn btn-primary w-100" onclick="if(!confirm('Voulez-vous Envoyer ?')){event.preventDefault();}">
                                <i class="fas fa-paper-plane"></i>&nbsp;<strong>Envoyer</strong>
                            </button>
                        </div>

                        <div class="col-2">
                            <button type="submit" name="annuler" onclick="if(!confirm('Voulez-vous annuler ?')){event.preventDefault();}" class="btn btn-danger w-100">
                                <i class="fas fa-times"></i>&nbsp;<strong>Annnuler</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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