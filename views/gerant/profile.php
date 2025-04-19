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
    $gerant = new Gerant();



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
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
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

                <main class="col-md-9 col-lg-10 p-4">
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
                                            class="nav-link py-3 bg-light">
                                            <i class="fas fa-user me-2"></i>Profil
                                        </a>
                                        <a href="./parametre.php"
                                            class="nav-link active py-3 ">
                                            <i class="fas fa-user-pen me-2"></i>Modifier
                                        </a>
                                    </nav>
                                </div>
                            </div>

                            <!-- Contenu principal -->
                            <div class="col-md-8 col-lg-9">
                                <!-- Section Informations -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-light border-bottom">
                                        <h3 class="card-title mb-0 fs-5">
                                            <i class="fas fa-circle-info me-2"></i>
                                            Informations détaillées
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-4">
                                            <!-- Colonne gauche -->
                                            <div class="col-md-6">
                                                <dl class="row border-bottom pb-2 mb-3">
                                                    <dt class="col-sm-4 text-muted">Prénom</dt>
                                                    <dd class="col-sm-8 fw-medium"><?= $_SESSION['user']['prenom'] ?></dd>

                                                    <dt class="col-sm-4 text-muted">Rôle</dt>
                                                    <dd class="col-sm-8 "><?= $_SESSION['user']['role_specifique'] ?></dd>

                                                    <dt class="col-sm-4 text-muted">Téléphone</dt>
                                                    <dd class="col-sm-8">
                                                        <a href="tel:<?= $_SESSION['user']['telephone'] ?>" class="text-decoration-none">
                                                            <?= $_SESSION['user']['telephone'] ?>
                                                        </a>
                                                    </dd>
                                                </dl>
                                            </div>

                                            <!-- Colonne droite -->
                                            <div class="col-md-6">
                                                <dl class="row border-bottom pb-2 mb-3">
                                                    <dt class="col-sm-4 text-muted">Nom</dt>
                                                    <dd class="col-sm-8 fw-medium"><?= $_SESSION['user']['nom'] ?></dd>

                                                    <dt class="col-sm-4 text-muted">Création</dt>
                                                    <dd class="col-sm-8">
                                                        <?= date('d/m/Y H:i', strtotime($_SESSION['user']['created_at'])) ?>
                                                    </dd>

                                                    <dt class="col-sm-4 text-muted">Email</dt>
                                                    <dd class="col-sm-8">
                                                        <a href="mailto:<?= $_SESSION['user']['email'] ?>" class="text-decoration-none">
                                                            <?= $_SESSION['user']['email'] ?>
                                                        </a>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Agences -->
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                                        <h3 class="card-title mb-0 fs-5">
                                            <i class="fas fa-sitemap me-2"></i>
                                            Gestion des agences
                                        </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatablesSimple" class="table table-hover align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Adresse</th>
                                                        <th>Email</th>
                                                        <th>Ouverture</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $gerant->ShowAgence($_SESSION['user_id']); ?>
                                                </tbody>
                                            <?php } ?>
                                            <tfoot>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Adresse</th>
                                                    <th>Email</th>
                                                    <th>Ouverture</th>
                                                </tr>
                                            </tfoot>
                                            </table>
                                        </div>
                                    </div>
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
        <script src="../.././assets/js/scripts.js"></script>
        <script src="../.././assets/js/master.js"></script>
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