<?php include_once('./connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../.././assets/css/styles.css" rel="stylesheet" />
    <link href="../.././assets/css/master.css?v=<?= time() ?>" rel="stylesheet" />
    <link href="../.././assets/css/main.css?v=<?= time() ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<?php
if (isset($_SESSION['user_id'])) {
    if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
        $gerant = new Gerant();
        if (isset($_POST['modifier'])) {
            if (!empty($_POST['mot_de_passe'])) {
                Autentification::changement_mdp($_SESSION['user_id']);
            }
            Gerant::update($_SESSION['user_id'], [
                'prenom' => $_POST['prenom'] ?? '',
                'nom' => $_POST['nom'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telephone' => $_POST['telephone'] ?? '',
                'mot_de_passe' => !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT) : '',
            ]);
        } else {
            Gerant::addPhoto($_FILES['photo'], $_SESSION['user_id'], $_SESSION['user']['photo']);
        }
        $_SESSION['user'] = array_map('convert_to_assoc', $gerant->get($_SESSION['user_id']))[0];
        header("Location:./parametre.php?id={$_SESSION['user_id']}");
        exit();
    }
?>

    <body class="sb-nav-fixed">
        <!-- Navbar -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="./gerant.php">
                <img src="../.././assets/img/logo.png" alt="Logo" class="custom-logo">
            </a>
            <!-- Sidebar Toggle -->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
                <i class="bi bi-list custom-menu-icon"></i> <!-- Icône de menu -->
            </button>

            <!-- Navbar Search - Aligner complètement à gauche -->
            <form class="d-none d-md-inline-block form-inline ms-0 me-auto my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Recherche..." aria-label="Recherche..."
                        aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>


            <!-- Navbar - Icônes à droite -->
            <ul class="navbar-nav ms-auto me-3 me-lg-4">


                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center position-relative" id="notificationsDropdown" href="#"
                        role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-warning  position-absolute top-0 start-100 translate-middle">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-center" href="./notification.php">Voir toutes les notifications</a></li>
                    </ul>
                </li>

                <!-- Messages -->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center position-relative" id="messagesDropdown" href="#"
                        role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-envelope"></i>
                        <span class="badge bg-warning ms-1 position-absolute top-0 start-100 translate-middle"><?= Client::getNbrMessage($_SESSION['agence_id']) ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown">
                        <?php Client::showMessage($_SESSION['agence_id']);  ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-center" href="./Client./messages.php">Voir tous les messages</a></li>
                    </ul>
                </li>

                <!--Agence-->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center position-relative" id="AgenceDropdown" href="#"
                        role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-building"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                        <!-- dynamic zone-->
                        <?php Agence::ShowAgences($_SESSION['agences']); ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-center" href="./profile.php">Voir la liste des agences</a></li>
                    </ul>
                </li>


                <!-- Profil -->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" id="profileDropdown" href="#" role="button"
                        data-bs-toggle="dropdown">
                        <img src="<?= $_SESSION['user']['photo'] ?>" class="rounded-circle me-2" alt="Profil" width="40" height="40">
                        <span class="d-none d-lg-inline"><?= $_SESSION['user']['prenom'] ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="./profile.php"><i class="bi bi-person"></i>&nbsp;&nbsp;Profil</a></li>
                        <li><a class="dropdown-item" href="./parametre.php"><i class="bi bi-gear"></i>&nbsp;&nbsp;Paramètres</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <form id="logout-form" action="./connect.php" method="POST" style="display: none;">
                            <input type="hidden" name="deconnect" value="true">
                        </form>
                        <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i>Déconnexion</a></li>
                    </ul>
                </li>

            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="./gerant.php">
                                <div class="sb-nav-link-icon"><i class="bi bi-bar-chart-line"></i></div>
                                Tableau de bord
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseVoitures" aria-expanded="false" aria-controls="collapseVoitures">
                                <div class="sb-nav-link-icon"><i class="bi bi-car-front"></i></div>
                                Voitures
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseVoitures" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./voitures/listes.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>listes
                                    </a>
                                    <a class="nav-link" href="./voitures/ajouter.php"><i class="fas fa-plus"></i>
                                        <pre> </pre>ajouter
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseClients" aria-expanded="false" aria-controls="collapseClients">
                                <div class="sb-nav-link-icon"><i class="bi-person"></i></div>
                                Clients
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseClients" aria-labelledby="headingTwo"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./Client./listes.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>listes
                                    </a>
                                    <a class="nav-link" href="./Client./historique.php"><i class="fas fa-history"></i>
                                        <pre> </pre>Historique
                                    </a>
                                    <a class="nav-link" href="./Client./messages.php"><i
                                            class="fas fa-comments"></i>
                                        <pre> </pre>messages
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation">
                                <div class="sb-nav-link-icon"><i class="bi-house"></i></div>
                                Offres de location
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLocation" aria-labelledby="headingThree"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./Offres/ajouter.php"><i class="fas fa-plus"></i>
                                        <pre> </pre>Ajouter
                                    </a>
                                    <a class="nav-link" href="./Offres/liste.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                    <a class="nav-link" href="./Offres/terminee.php"><i
                                            class="fas fa-check-circle"></i>
                                        <pre> </pre>Terminées
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseReservation" aria-expanded="false"
                                aria-controls="collapseReservation">
                                <div class="sb-nav-link-icon"><i class="bi-calendar-check"></i></div>
                                Réservations
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseReservation" aria-labelledby="headingFour"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./reservations/liste.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                    <a class="nav-link" href="./reservations/ajouter.php"><i class="fas fa-check-circle"></i>
                                        <pre> </pre>Ajouter
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsePaiements" aria-expanded="false" aria-controls="collapsePaiements">
                                <div class="sb-nav-link-icon"><i class="bi-credit-card"></i></div>
                                Paiements
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePaiements" aria-labelledby="headingFive"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./paiments/liste.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                    <a class="nav-link" href="./paiments/ajouter.php"><i
                                            class="fas fa-plus"></i>
                                        <pre> </pre>Ajouter
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseFactures" aria-expanded="false" aria-controls="collapseFactures">
                                <div class="sb-nav-link-icon"><i class="bi-receipt"></i></div>
                                Factures
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseFactures" aria-labelledby="headingSix"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./factures/liste.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                    <a class="nav-link" href="./factures/generee.php"><i
                                            class="fas fa-cogs"></i>
                                        <pre> </pre>Générer
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsePlaintes" aria-expanded="false" aria-controls="collapsePlaintes">
                                <div class="sb-nav-link-icon"><i class="bi-exclamation-triangle"></i></div>
                                Plaintes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePlaintes" aria-labelledby="headingSeven"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./plaintes/liste.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseEntretien" aria-expanded="false" aria-controls="collapseEntretien">
                                <div class="sb-nav-link-icon"><i class="bi-tools"></i></div>
                                Entretien
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseEntretien" aria-labelledby="headingEight"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./entretiens/liste.php"><i class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                    <a class="nav-link" href="./entretiens/ajouter.php"><i
                                            class="fas fa-plus"></i>
                                        <pre> </pre>Ajouter
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseRetards" aria-expanded="false" aria-controls="collapseRetards">
                                <div class="sb-nav-link-icon"><i class="bi-hourglass-split"></i></div>
                                Retards
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseRetards" aria-labelledby="headingNine"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./retards/listes.php"><i
                                            class="fas fa-clipboard-list"></i>
                                        <pre> </pre>liste
                                    </a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsePromotions" aria-expanded="false"
                                aria-controls="collapsePromotions">
                                <div class="sb-nav-link-icon"><i class="bi-megaphone"></i></div>Promotions
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePromotions" aria-labelledby="headingTen"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./promotions/en-cours.php"><i class="fas fa-tags"></i>
                                        <pre> </pre>En cours
                                    </a>
                                    <a class="nav-link" href="./promotions/terminee.php"><i class="fas fa-check-circle"></i>
                                        <pre> </pre>Terminées
                                    </a>
                                    <a class="nav-link" href="./promotions/ajouter.php"><i
                                            class="fas fa-plus"></i>
                                        <pre> </pre> Ajouter
                                    </a>
                                </nav>
                            </div>

                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="./charts.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>Graphes
                            </a>
                            <a class="nav-link" href="./notification.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Notifications
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><?php echo date('Y-m-d', time()) ?></div>
                    </div>
                </nav>
            </div>


            <div id="layoutSidenav_content">
                <main class="col-md-9 col-lg-10 p-4 pb-5">
                    <div class="container-fluid">
                        <div class="row g-4">


                            <!-- Sidebar Profil -->
                            <div class="col-md-4 col-xl-3">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <img src="<?= $_SESSION['user']['photo'] ?>"
                                            alt="Photo de profil"
                                            class="rounded-circle mb-3 object-fit-cover"
                                            width="140"
                                            height="140">
                                        <h2 class="h5 mb-1 fw-semibold"><?= $_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom'] ?></h2>
                                        <p class="text-muted small"><?= $_SESSION['user']['email'] ?></p>
                                    </div>

                                    <nav class="nav flex-column mb-3 border-top">
                                        <a href="./profile.php"
                                            class="nav-link py-3">
                                            <i class="fas fa-user me-2"></i>Profil
                                        </a>
                                        <a href="./parametre.php"
                                            class="nav-link active py-3 bg-light">
                                            <i class="fas fa-user-pen me-2"></i>Modifier
                                        </a>
                                    </nav>
                                </div>
                            </div>

                            <!-- Formulaire de modification -->
                            <div class="col-md-8 col-xl-9">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light border-bottom">
                                        <h3 class="card-title mb-0 fs-5">
                                            <i class="fas fa-user-gear me-2"></i>
                                            Paramétres
                                        </h3>
                                    </div>

                                    <form method="POST" enctype="multipart/form-data" class="card-body">
                                        <div class="row g-4">
                                            <!-- Colonne Gauche -->
                                            <div class="col-lg-6">
                                                <!-- Photo de profil -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-medium">Photo de profil</label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="position-relative">
                                                            <img src="<?= $_SESSION['user']['photo'] ?>"
                                                                class="rounded-circle preview-image"
                                                                width="80"
                                                                height="80">
                                                            <label class="btn btn-sm btn-primary position-absolute bottom-0 end-0 mb-1 me-1 p-1">
                                                                <i class="fas fa-camera"></i>
                                                                <input type="file"
                                                                    name="photo"
                                                                    class="d-none"
                                                                    id="img-cars"
                                                                    accept="image/*">
                                                            </label>
                                                        </div>
                                                        <small class="text-muted">Format JPG/PNG (max 2MB)</small>
                                                    </div>
                                                </div>

                                                <!-- Informations personnelles -->
                                                <fieldset class="border p-3 rounded-3">
                                                    <legend class="float-none w-auto fs-6 px-2">Identité</legend>

                                                    <div class="mb-3">
                                                        <label class="form-label">Prénom</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="prenom"
                                                            value="<?= $_SESSION['user']['prenom'] ?>"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Nom</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="nom"
                                                            value="<?= $_SESSION['user']['nom'] ?>"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email"
                                                            class="form-control"
                                                            name="email"
                                                            value="<?= $_SESSION['user']['email'] ?>"
                                                            required>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <!-- Colonne Droite -->
                                            <div class="col-lg-6">
                                                <!-- Informations professionnelles -->
                                                <fieldset class="border p-3 rounded-3 mb-4">
                                                    <legend class="float-none w-auto fs-6 px-2">Rôle</legend>

                                                    <div class="mb-3">
                                                        <label class="form-label">Rôle spécifique</label>
                                                        <input type="text"
                                                            class="form-control bg-light"
                                                            value="<?= ucfirst($_SESSION['user']['role_specifique']) ?>"
                                                            readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Statut</label>
                                                        <select class="form-select" name="role" disabled>
                                                            <option value="gerant" selected>Gerant</option>
                                                        </select>
                                                    </div>
                                                </fieldset>

                                                <!-- Sécurité -->
                                                <fieldset class="border p-3 rounded-3">
                                                    <legend class="float-none w-auto fs-6 px-2">Sécurité</legend>

                                                    <div class="mb-3">
                                                        <label class="form-label">Téléphone</label>
                                                        <input type="tel"
                                                            class="form-control"
                                                            name="telephone" Utilisateur
                                                            value="<?= $_SESSION['user']['telephone'] ?>"
                                                            pattern="[0-9]{2} [0-9]{3} [0-9]{2} [0-9]{2}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Nouveau mot de passe</label>
                                                        <div class="input-group">
                                                            <input type="password"
                                                                class="form-control"
                                                                name="mot_de_passe"
                                                                placeholder="••••••••">
                                                            <button type="button"
                                                                class="btn btn-outline-secondary password-toggle">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Date de création</label>
                                                        <input type="text"
                                                            class="form-control bg-light"
                                                            value="<?= date('d/m/Y', strtotime($_SESSION['user']['created_at'])) ?>"
                                                            readonly>

                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="d-flex justify-content-end gap-3 mt-4 border-top pt-4">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="fas fa-rotate-left me-2"></i>Annuler
                                            </button>
                                            <button type="submit" name="modifier" class="btn btn-primary">
                                                <i class="fas fa-floppy-disk me-2"></i>Modifier
                                            </button>
                                        <?php } ?>

                                        </div>
                                    </form>

                                </div>
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
        </div>
        <script src="../.././assets/js/master.js?v=<?= time() ?>"></script>
        <script src="../.././assets/js/scripts.js?v=<?= time() ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../.././assets/demo/chart-area-demo.js"></script>
        <script src="../.././assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
        <script src="../.././assets/js/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    </body>

</html>