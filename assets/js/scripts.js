window.addEventListener('DOMContentLoaded', event => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.toggle('sb-sidenav-toggled');
        }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


// script.js (extrait)
(function () {
    'use strict';

    // ==========================================================
    // MODULE MESSAGES CLIENTS 
    // ==========================================================
    (function clientMessagesModule() {
        const forms = document.querySelectorAll('form');

        if (!forms.length) return;

        // Initialisation
        init();

        function init() {
            forms.forEach((form) => {
                const textarea = form.querySelector('textarea[name="contenue"]');

                if (!textarea) return;

                form.addEventListener('submit', function (e) {
                    if (!validateTextarea(textarea)) {
                        e.preventDefault();
                        alert('Le champ de réponse ne peut pas être vide ou ne contenir que des espaces.');
                        textarea.focus();
                    }
                });
            });
        }

        function validateTextarea(field) {
            return field.value.trim().length > 0;
        }

    })();

})();


// script.js (extrait)
(function () {
    'use strict';

    // ==========================================================
    // MODULE LISTE CLIENTS (page contenant le tableau de clients)
    // ==========================================================
    (function clientListModule() {
        const clientTable = document.querySelector('#datatablesSimple');
        if (!clientTable) return;

        // Initialisation
        init();

        function init() {
            bindActionButtons();
        }

        function bindActionButtons() {
            const actionCells = clientTable.querySelectorAll('tbody tr td:last-child');

            actionCells.forEach((cell, index) => {
                const button = cell.querySelector('button, a');

                if (button) {
                    button.addEventListener('click', function (e) {
                        // Exemple : intercepter le clic "plus"
                        console.log(`Action sur la ligne ${index + 1}`);
                        // e.preventDefault(); // à décommenter si on veut stopper le comportement par défaut
                    });
                }
            });
        }

    })();

})();


// script.js (extrait)
(function () {
    'use strict';

    // ==========================================================
    // MODULE HISTORIQUE LOCATIONS (page avec le tableau d’historique)
    // ==========================================================
    (function locationHistoryModule() {
        const historyTable = document.querySelector('#datatablesSimple');
        if (!historyTable) return;

        // Initialisation
        init();

        function init() {
            highlightRecentRentals();
        }

        function highlightRecentRentals() {
            const rows = historyTable.querySelectorAll('tbody tr');
            const today = new Date();

            rows.forEach((row) => {
                const dateFinCell = row.cells[5];
                if (!dateFinCell) return;

                const dateFinText = dateFinCell.textContent.trim();
                const dateFin = new Date(dateFinText);

                if (!isNaN(dateFin.getTime())) {
                    const diffDays = (today - dateFin) / (1000 * 60 * 60 * 24);
                    if (diffDays <= 7) {
                        row.style.backgroundColor = '#fff3cd'; // Jaune clair pour les locations récentes
                    }
                }
            });
        }

    })();

})();


// script.js (extrait)
(function () {
    'use strict';

    // ==========================================================
    // MODULE DETAIL CLIENT (page avec la fiche d’un client)
    // ==========================================================
    (function clientDetailModule() {
        const detailForm = document.querySelector('form[action="./DetailClient.php"]');
        if (!detailForm) return;

        // Sélecteurs des boutons
        const selectors = {
            activateBtn: 'button[name="on_off"][value="Activer"]',
            deactivateBtn: 'button[name="on_off"][value="Désactiver"]',
            deleteBtn: 'button[name="erase"]',
            backBtn: 'a.btn-secondary'
        };

        init();

        function init() {
            setupConfirmationHandlers();
            setupBackNavigation();
        }

        function setupConfirmationHandlers() {
            const activateBtn = detailForm.querySelector(selectors.activateBtn);
            const deactivateBtn = detailForm.querySelector(selectors.deactivateBtn);
            const deleteBtn = detailForm.querySelector(selectors.deleteBtn);

            if (activateBtn) {
                activateBtn.addEventListener('click', function (e) {
                    if (!confirm("Voulez-vous activer ce client ?")) {
                        e.preventDefault();
                    }
                });
            }

            if (deactivateBtn) {
                deactivateBtn.addEventListener('click', function (e) {
                    if (!confirm("Voulez-vous désactiver ce client ?")) {
                        e.preventDefault();
                    }
                });
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function (e) {
                    if (!confirm("Confirmez-vous la suppression de ce client ? Cette action est irréversible.")) {
                        e.preventDefault();
                    }
                });
            }
        }

        function setupBackNavigation() {
            const backBtn = document.querySelector(selectors.backBtn);
            if (backBtn) {
                backBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.history.back();
                });
            }
        }

    })();

})();



// script.js (ajouter entretien)
(function () {
    'use strict';

    // ==========================================================
    // MODULE AJOUT ENTRETIEN
    // ==========================================================
    (function entretienFormModule() {
        const form = document.querySelector('form[action="./ajouter.php"]');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            // Récupération des champs
            const idVehicule = form.querySelector('#id_vehicule');
            const description = form.querySelector('#description');
            const date = form.querySelector('#date');
            const cout = form.querySelector('#cout');
            const responsable = form.querySelector('#responsable');

            // Messages d'erreur personnalisés
            if (!idVehicule.value.trim()) {
                alert('Veuillez renseigner l\'ID du véhicule.');
                idVehicule.focus();
                e.preventDefault();
                return;
            }

            if (!description.value.trim()) {
                alert('Veuillez fournir une description de l\'entretien.');
                description.focus();
                e.preventDefault();
                return;
            }

            if (!date.value) {
                alert('Veuillez sélectionner une date.');
                date.focus();
                e.preventDefault();
                return;
            }

            if (!cout.value || parseFloat(cout.value) <= 0) {
                alert('Le coût doit être un nombre positif.');
                cout.focus();
                e.preventDefault();
                return;
            }

            if (!responsable.value.trim()) {
                alert('Veuillez indiquer le nom du responsable.');
                responsable.focus();
                e.preventDefault();
                return;
            }

            // Formulaire valide
        });

    })();

})();


(function () {
    'use strict';

    (function detailEntretienModule() {
        const form = document.querySelector('form[action="./DetailEntretien.php"]');
        if (!form) return;

        const supprimerBtn = form.querySelector('button[name="supprimer"]');
        const modifierBtn = form.querySelector('button[name="modifier"]');

        form.addEventListener('submit', function (e) {
            // Détection du bouton cliqué
            const clickedButton = document.activeElement;

            const idVehicule = form.querySelector('#id_vehicule');
            const description = form.querySelector('#description');
            const date = form.querySelector('#date');
            const cout = form.querySelector('#cout');
            const responsable = form.querySelector('#responsable');

            if (clickedButton === supprimerBtn) {
                const confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cet entretien ?");
                if (!confirmDelete) {
                    e.preventDefault();
                    return;
                }
            }

            if (clickedButton === modifierBtn) {
                // Validation des champs obligatoires
                if (!idVehicule.value.trim()) {
                    alert("L'ID du véhicule est requis.");
                    idVehicule.focus();
                    e.preventDefault();
                    return;
                }

                if (!description.value.trim()) {
                    alert("La description est obligatoire.");
                    description.focus();
                    e.preventDefault();
                    return;
                }

                if (!date.value) {
                    alert("Veuillez spécifier une date.");
                    date.focus();
                    e.preventDefault();
                    return;
                }

                if (!cout.value || parseFloat(cout.value) <= 0) {
                    alert("Le coût doit être un nombre positif.");
                    cout.focus();
                    e.preventDefault();
                    return;
                }

                if (!responsable.value.trim()) {
                    alert("Le champ responsable est requis.");
                    responsable.focus();
                    e.preventDefault();
                    return;
                }
            }
        });
    })();
})();




(function () {
    'use strict';

    (function listeEntretienModule() {
        const table = document.querySelector('#datatablesSimple');
        if (!table) return;

        // Si tu as un bouton de suppression dans chaque ligne (par exemple avec un data-id)
        table.addEventListener('click', function (e) {
            const target = e.target;
            if (target.matches('.btn-supprimer')) {
                const id = target.getAttribute('data-id') || 'cet élément';
                const confirmation = confirm(`Êtes-vous sûr de vouloir supprimer l'entretien #${id} ?`);
                if (!confirmation) {
                    e.preventDefault();
                }
            }
        });
    })();
})();

(function () {
    'use strict';

    // Fonction pour vérifier si un nombre est positif
    function isPositiveNumber(value) {
        return !isNaN(value) && value > 0;
    }

    

    // Gestion des confirmations pour l'envoi et l'annulation
    document.addEventListener('DOMContentLoaded', function () {
        const envoyerBtn = document.querySelector('button[name="envoyer"]');
        const annulerBtn = document.querySelector('button[name="annuler"]');

        // Confirmation avant envoi
        if (envoyerBtn) {
            envoyerBtn.addEventListener('click', function (e) {
                if (!validateForm()) {
                    e.preventDefault(); // Empêcher l'envoi du formulaire en cas d'erreur
                    return;
                }
                const confirmation = confirm('Voulez-vous vraiment envoyer la facture ?');
                if (!confirmation) {
                    e.preventDefault();
                }
            });
        }

        // Confirmation avant annulation
        if (annulerBtn) {
            annulerBtn.addEventListener('click', function (e) {
                const confirmation = confirm('Voulez-vous vraiment annuler ?');
                if (!confirmation) {
                    e.preventDefault();
                }
            });
        }
    });
})();

    (function() {
        // Fonction pour valider le formulaire
        function validateForm() {
            // Récupérer les valeurs des champs du formulaire
            let idVehicule = document.getElementById('id-voiture').value;
            let dateDebut = document.getElementById('date-debut').value;
            let dateFin = document.getElementById('date-fin').value;
            let tarif = document.getElementById('prix').value;
            let condition = document.getElementById('condition').value;
            let description = document.getElementById('etat').value;

            // Vérifier que l'ID du véhicule est valide
            if (idVehicule.trim() === "") {
                alert("L'ID du véhicule est obligatoire.");
                return false;
            }

            // Vérifier que la condition est remplie
            if (condition.trim() === "") {
                alert("La condition du véhicule est obligatoire.");
                return false;
            }

            // Vérifier que le tarif est un nombre positif
            if (isNaN(tarif) || tarif <= 0) {
                alert("Le tarif doit être un nombre positif.");
                return false;
            }

            // Vérifier que la date de début et de fin sont valides
            let startDate = new Date(dateDebut);
            let endDate = new Date(dateFin);
            if (startDate >= endDate) {
                alert("La date de fin doit être postérieure à la date de début.");
                return false;
            }

            // Si tout est valide, on soumet le formulaire
            return true;
        }

        // Attacher l'événement de validation lors de la soumission du formulaire
        document.querySelector('form').addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault(); // Empêcher l'envoi du formulaire si la validation échoue
            }
        });
    })();

    
    (function() {
        // Fonction de validation des saisies
        function validateForm() {
            // Récupérer les valeurs des champs
            let idReservation = document.getElementById('id_reservation').value;
            let idTransaction = document.getElementById('id_transaction').value;
            let datePaiement = document.getElementById('date_paiement').value;
            let montant = document.getElementById('montant').value;
            let status = document.getElementById('status').value;
            let modePaiement = document.getElementById('mode_paiement').value;

            // Vérification des champs requis
            if (idReservation.trim() === "") {
                alert("L'ID de réservation est obligatoire.");
                return false;
            }

            if (idTransaction.trim() === "") {
                alert("L'ID de transaction est obligatoire.");
                return false;
            }

            if (datePaiement.trim() === "") {
                alert("La date de paiement est obligatoire.");
                return false;
            }

            if (isNaN(montant) || montant < 25000) {
                alert("Le montant doit être un nombre supérieur ou égal à 25 000.");
                return false;
            }

            if (status.trim() === "") {
                alert("Le statut est obligatoire.");
                return false;
            }

            if (modePaiement.trim() === "") {
                alert("Le mode de paiement est obligatoire.");
                return false;
            }

            // Si tout est valide
            return true;
        }

        // Attacher l'événement de soumission
        document.querySelector('form').addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault(); // Empêcher la soumission si la validation échoue
            }
        });

    })();


    
    (function() {
        // Fonction de validation avant la soumission du formulaire
        function validateForm() {
            // Récupérer les valeurs des champs
            let statut = document.getElementById('statut').value;
            let description = document.getElementById('description').value;
            let solution = document.getElementById('solution').value;

            // Vérifier si la description est remplie
            if (description.trim() === "") {
                alert("La description est obligatoire.");
                return false;
            }

            // Vérifier si la solution est remplie
            if (solution.trim() === "") {
                alert("La solution est obligatoire.");
                return false;
            }

            // Si tout est valide
            return true;
        }

        // Attacher les événements de confirmation aux boutons
        document.querySelector('button[name="supprimer"]').addEventListener('click', function(event) {
            if (!confirm('Voulez-vous vraiment supprimer cette plainte ?')) {
                event.preventDefault();
            }
        });

        document.querySelector('button[name="modifier"]').addEventListener('click', function(event) {
            if (!confirm('Voulez-vous enregistrer cette plainte ?')) {
                event.preventDefault();
            } else {
                if (!validateForm()) {
                    event.preventDefault(); // Empêcher la soumission si la validation échoue
                }
            }
        });

    })();


    (function() {
        // Fonction de validation avant la soumission du formulaire
        function validateForm() {
            const codePromo = document.getElementById('code_promo').value.trim();
            const reduction = parseFloat(document.getElementById('reduction').value);
            const dateDebut = document.getElementById('date_debut').value;
            const dateFin = document.getElementById('date_fin').value;

            // Vérifier si le code promo est vide
            if (codePromo === "") {
                alert("Le code promo est obligatoire.");
                return false;
            }

            // Vérifier si la réduction est valide
            if (isNaN(reduction) || reduction <= 0 || reduction > 100) {
                alert("La réduction doit être un nombre compris entre 0 et 100.");
                return false;
            }

            // Vérifier si la date de début et la date de fin sont valides
            if (new Date(dateDebut) > new Date(dateFin)) {
                alert("La date de début ne peut pas être postérieure à la date de fin.");
                return false;
            }

            // Si tout est valide
            return true;
        }

        // Attacher les événements de confirmation aux boutons
        document.querySelector('button[name="annuler"]').addEventListener('click', function(event) {
            if (!confirm('Voulez-vous vraiment annuler ?')) {
                event.preventDefault();
            }
        });

        document.querySelector('button[name="ajouter"]').addEventListener('click', function(event) {
            if (!confirm('Voulez-vous enregistrer ce code promo ?')) {
                event.preventDefault();
            } else {
                if (!validateForm()) {
                    event.preventDefault(); // Empêcher la soumission si la validation échoue
                }
            }
        });

    })();


    (function() {
        // Fonction pour valider les champs avant soumission
        function validateForm() {
            const idClient = document.getElementById('id_client').value.trim();
            const idOffre = document.getElementById('id_offre').value.trim();
            const dateDebut = document.getElementById('date_debut').value;
            const dateFin = document.getElementById('date_fin').value;
            const total = parseFloat(document.getElementById('total').value);

            // Vérifier que l'ID Client et l'ID Offre sont valides
            if (idClient === "" || idOffre === "") {
                alert("Les champs 'ID Client' et 'ID Offre' sont obligatoires.");
                return false;
            }

            // Vérifier que la date de début et de fin sont valides
            if (new Date(dateDebut) > new Date(dateFin)) {
                alert("La date de début ne peut pas être après la date de fin.");
                return false;
            }

            // Vérifier que le total est un nombre valide et supérieur à 0
            if (isNaN(total) || total <= 0) {
                alert("Le total doit être un nombre positif.");
                return false;
            }

            // Si tout est valide
            return true;
        }

        // Ajouter les confirmations pour les boutons "Annuler" et "Ajouter"
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            if (!event.target.name) {
                return; // Ne rien faire si le bouton n'a pas de nom
            }

            if (event.target.name === 'ajouter') {
                // Si l'utilisateur clique sur "Ajouter", valider d'abord le formulaire
                if (!validateForm()) {
                    event.preventDefault(); // Empêcher la soumission si la validation échoue
                } else {
                    if (!confirm('Voulez-vous enregistrer cette réservation ?')) {
                        event.preventDefault(); // Empêcher la soumission si l'utilisateur annule
                    }
                }
            } else if (event.target.name === 'annuler') {
                // Si l'utilisateur clique sur "Annuler"
                if (!confirm('Voulez-vous annuler ?')) {
                    event.preventDefault(); // Empêcher l'annulation si l'utilisateur annule
                }
            }
        });

    })();

    
    (function() {
        // Fonction pour valider le formulaire
        function validateForm() {
            const marque = document.getElementById('marque').value.trim();
            const modele = document.getElementById('modele').value.trim();
            const prix = parseFloat(document.getElementById('prix').value);
            const type = document.getElementById('type').value;
            const transmission = document.getElementById('transmission').value;
            const carburant = document.getElementById('carburant').value;
            const etat = document.getElementById('etat').value;

            // Vérifier que tous les champs requis sont remplis
            if (marque === "" || modele === "" || type === "" || transmission === "" || carburant === "" || etat === "") {
                alert("Tous les champs doivent être remplis.");
                return false;
            }

            // Vérifier que le prix est un nombre valide
            if (isNaN(prix) || prix <= 0) {
                alert("Le prix par jour doit être un nombre positif.");
                return false;
            }

            // Si tout est valide
            return true;
        }

        // Ajouter les confirmations pour les boutons "Annuler" et "Enregistrer"
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            // Si l'utilisateur clique sur "Enregistrer", valider d'abord le formulaire
            if (!validateForm()) {
                event.preventDefault(); // Empêcher la soumission si la validation échoue
            } else {
                if (!confirm('Voulez-vous enregistrer ce véhicule ?')) {
                    event.preventDefault(); // Empêcher la soumission si l'utilisateur annule
                }
            }
        });

        // Confirmation pour le bouton "Annuler"
        document.querySelector('button[type="reset"]').addEventListener('click', function(event) {
            if (!confirm('Voulez-vous réinitialiser le formulaire ?')) {
                event.preventDefault(); // Empêcher la réinitialisation si l'utilisateur annule
            }
        });
    })();





    