<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_SESSION['user_id']))) {
    $voiture = new Vehicule();
    $voiture->add([
        'marque' => $_POST['marque'] ?? '',
        'modele' => $_POST['modele'] ?? '',
        'transmission' => $_POST['transmission'] ?? '',
        'type' => $_POST['type'] ?? '',
        'annee' => date('Y', strtotime($_POST['annee'])) ?? '',
        'prix_par_jour' => floatval($_POST['prix_par_jour']) ?? '',
        'carburant' => $_POST['carburant'] ?? '',
        'disponibilite' => $_POST['disponibilite']  ?? '',
        'agence_id' => intval($_SESSION['agence_id']),
        'etat' => $_POST['etat'] ?? '',
        'image_vehicule' => $_FILES['image_vehicule'] ?? [],
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
        <div class="container more-voiture offset-6">
            <div class="row mb-4 align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-12 sub-container card">
                    <form method="post" enctype="multipart/form-data" action="./ajouter.php">
                        <div class="row mb-3 mt-1">
                            <div class="col-4"><label for="marque"><strong>Marque :</strong></label></div>
                            <div class="col-8"><input type="text" id="marque" name="marque" class="form-control" placeholder="marque"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="modele"><strong>Modèle :</strong></label></div>
                            <div class="col-8"><input type="text" id="modele" class="form-control" name="modele" placeholder="modéle"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="annee"><strong>Année :</strong></label></div>
                            <div class="col-8"><input type="date" id="annee" name="annee" class="form-control" value="2024-02-02"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="type"><strong>Type :</strong></label></div>
                            <div class="col-8">
                                <select id="type" class="form-control" name="type">
                                    <option value="" disabled selected>Choisissez un type</option>
                                    <option value="berline">Berline</option>
                                    <option value="suv">SUV</option>

                                    <option value="utilitaire">Utilitaire</option>
                                    <option value="luxe">Luxe</option>
                                    <option value="monospaces">Monospaces</option>
                                    <option value="4x4">4x4</option>
                                    <option value="breaks">Breaks</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="transmission"><strong>Transmission :</strong></label></div>
                            <div class="col-8">
                                <select id="transmission" name="transmission" class="form-control" aria-placeholder="transmission">
                                    <option value="manuelle">Manuelle</option>
                                    <option value="automatique">Automatique</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="carburant"><strong>Carburant :</strong></label></div>
                            <div class="col-8">
                                <select id="carburant" class="form-control" name="carburant">
                                    <option value="essence">Essence</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electrique">Électrique</option>
                                    <option value="hybride">Hybride</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="prix"><strong>Prix par jour :</strong></label></div>
                            <div class="col-8"><input type="number" id="prix" class="form-control" name="prix_par_jour"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="disponibilite"><strong>Disponibilité :</strong></label></div>
                            <div class="col-8">
                                <select id="disponibilite" class="form-control" name="disponibilite">
                                    <option value='1'>Disponible</option>
                                    <option value='0'>Indisponible</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="etat"><strong>État :</strong></label></div>
                            <div class="col-8">
                                <select id="etat" class="form-control" name="etat">
                                    <option value="" disabled selected>Choisissez un état</option>
                                    <option value="excellent">Excellent</option>
                                    <option value="bon">Bon</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="hors_service">Hors service</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="image_vehicule"><strong>Photo :</strong></label>
                            </div>
                            <div class="col-8">
                                <label for="img-cars" class="btn btn-secondary"><i class="fas fa-upload"></i>&nbsp;Ajouter</label>
                                <input type="file" name="image_vehicule[]" data-prevent-submit="true" multiple id="img-cars" accept="image/*" style="display: none;">
                            </div>
                        </div>
                        <div class="row mb-3 text-center">
                            <div class="col-6"><button type="reset" class="btn btn-danger w-100"><i class="fas fa-times"></i>&nbsp;<strong>Annuler</strong></button></div>
                            <div class="col-6"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i>&nbsp;<strong>Enregistrer</strong></button></div>
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