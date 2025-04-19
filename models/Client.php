<?php
class Client extends User
{
    protected array $data = [];
    protected array $datatype = [
        'id_utilisateur' => 'integer',
        'adresse' => 'string',
        'permit_de_conduire' => 'string',
        'status_compte' => 'string',
        'points_fidelite' => 'integer',
        'reservation' => 'array',
        'promotion' => 'array',
        'litige' => 'array',
        'favoris' => 'array',
        'avis' => 'array',
    ];
    public static function ShowAll(int $agenceId)
    {
        $query = "SELECT distinct U.id, U.prenom, U.nom, U.email, U.telephone, 
                     C.adresse, C.points_fidelite
              FROM Client C
              JOIN Utilisateur U ON C.id_utilisateur = U.id
              JOIN Reservation R ON U.id = R.id_client
              JOIN Offre_Location OL ON R.id_offre = OL.id
              JOIN Vehicule V ON OL.id_vehicule = V.id
              WHERE V.agence_id = :agenceId";
        $tables = parent::select($query, ['agenceId' => $agenceId]);
        foreach ($tables as $table) {
            echo " <tr>
            <td>
                {$table['id']}
            </td>
            <td>
                {$table['prenom']}
            </td>
            <td>
                {$table['nom']}
            </td>
            <td>
                {$table['email']}
            </td>
            <td>
                {$table['telephone']}
            </td>
            <td>
             {$table['adresse']}
            </td>
            <td>
             {$table['points_fidelite']}
            </td>
            <td>
                 <a href='./DetailClient.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
            </td>
        </tr>";
        }
    }


    public static function is_id(int $userId, $agence_id): int
    {
        $query = "SELECT distinct U.id
                    FROM Client C
                    JOIN Utilisateur U ON C.id_utilisateur = U.id
                    JOIN Reservation R ON U.id = R.id_client
                    JOIN Offre_Location OL ON R.id_offre = OL.id
                    JOIN Vehicule V ON OL.id_vehicule = V.id
                    WHERE V.agence_id = :agence_id";
        $tables = parent::select($query, ['agence_id' => $agence_id]);
        foreach ($tables as $table) {
            if ($table['id'] === $userId) {
                return 1;
            }
        }
        return 0;
    }

    public function getAttributs(int $userId): array
    {
        $query = "SELECT U.id,U.nom,U.prenom,U.email,U.telephone,U.created_at,C.permis_de_conduire,C.adresse,C.statut_compte,C.points_fidelite,U.photo FROM Utilisateur U JOIN Client C ON U.id=C.id_utilisateur where U.id=:userId";
        return  parent::select($query, ['userId' => $userId]);
    }
    public function delete(int $id_client)
    {

        parent::instruction("delete from Client Where id_utilisateur=:id", ['id' => $id_client]);
    }
    public function one_off(int $id_client, $state)
    {
        parent::instruction("UPDATE  Client SET statut_compte=:statut_compte Where id_utilisateur=:id", ['statut_compte' => $state, 'id' => $id_client]);
    }
    public static function History(int $agenceId)
    {
        $query = "SELECT C.id_utilisateur, R.id_offre,OL.id_vehicule, OL.tarif, OL.tarif,OL.date_debut,OL.date_fin	
              FROM Client C
              JOIN Utilisateur U ON C.id_utilisateur = U.id
              JOIN Reservation R ON U.id = R.id_client
              JOIN Offre_Location OL ON R.id_offre = OL.id
              JOIN Vehicule V ON OL.id_vehicule = V.id
              WHERE V.agence_id = :agenceId";
        $tables = parent::select($query, ['agenceId' => $agenceId]);
        foreach ($tables as $table) {
            echo " <tr>
            <td>
                {$table['id_offre']}
            </td>
            <td>
                {$table['id_vehicule']}
            </td>
            <td>
                {$table['id_utilisateur']}
            </td>
            <td>
                {$table['tarif']}
            </td>
            <td>
                {$table['date_debut']}
            </td>
            <td>
             {$table['date_fin']}
            </td>
        </tr>";
        }
    }
    static function getNbrMessage(int $agence_id)
    {
        $query = "SELECT COUNT(*) AS nombre_messages
                    FROM Client C
                    JOIN Utilisateur U ON C.id_utilisateur = U.id
                    JOIN Reservation R ON U.id = R.id_client
                    JOIN Support S ON S.id_utilisateur = U.id AND S.reponse IS NULL
                    JOIN Offre_Location OL ON R.id_offre = OL.id
                    JOIN Vehicule V ON OL.id_vehicule = V.id
                    WHERE V.agence_id = :agence_id;
                    ";
        return parent::select($query, ['agence_id' => $agence_id])[0][0];
    }
    public static function showMessage(int $agence_id, bool $w_dot = false): int
    {
        $query = "SELECT DISTINCT S.message
        FROM Client C
        JOIN Utilisateur U ON C.id_utilisateur = U.id
        JOIN Reservation R ON U.id = R.id_client
        JOIN Support S ON S.id_utilisateur=U.id AND S.reponse IS NULL
        JOIN Offre_Location OL ON R.id_offre = OL.id
        JOIN Vehicule V ON OL.id_vehicule = V.id
        WHERE V.agence_id = :agence_id";
        $ms = parent::select($query, ['agence_id' => $agence_id]);
        $resultat = [];
        $i = 0;
        foreach ($ms as $value) {
            $resultat[] = $value["message"];
            $i++;
            if ($i > 4) {
                break;
            }
        }
        foreach ($resultat as $value) {
            $dot = $w_dot ? '.' : '';
            echo '<li><a class="dropdown-item" href="' . $dot . './Client./messages.php">💬 "' . mb_substr($value, 0, 20, 'UTF-8') . '..."</a></li>';
        }
        return count($resultat);
    }
    public static function getNewMessages(int $agenceId)
    {
        $query = "SELECT DISTINCT U.prenom, U.nom, U.email,S.message,S.date,U.photo,U.id
        FROM Client C
        JOIN Utilisateur U ON C.id_utilisateur = U.id
        JOIN Reservation R ON U.id = R.id_client
        JOIN Support S ON S.id_utilisateur=U.id AND S.reponse IS NULL
        JOIN Offre_Location OL ON R.id_offre = OL.id
        JOIN Vehicule V ON OL.id_vehicule = V.id
        WHERE V.agence_id = :agenceId";
        return parent::select($query, ['agenceId' => $agenceId]);
    }
    public static function update(int $id, array $data)
    {
        parent::instruction("UPDATE Support SET " . parent::equalizer($data) . " WHERE id_utilisateur={$id}", $data);
    }
    //pour les attribut qui seront derivée d'autres classes je doit uitiliser des requettes sql .
}
