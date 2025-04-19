<?php
class Facture extends Dbase
{
    protected array $datatype = [
        'id' => 'integer',
        'montant_total' => 'double',
        'id_paiement' => 'integer',
        'date_emission' => 'string',
        'pdf_path' => 'string'
    ];

    public static function ShowAll(int $agence_id)
    {
        $tables = parent::select("SELECT F.* FROM Facture F JOIN Paiement P ON F.id_paiement=P.id JOIN Reservation R ON P.id_reservation=R.id JOIN Offre_Location O ON O.id=R.id_offre JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id",['agence_id'=>$agence_id]);
        foreach ($tables as $table) {
            echo "<tr>
                <td>{$table['id']}</td>
                <td>{$table['id_paiement']}</td>
                <td>{$table['date_emission']}</td>
                <td>{$table['montant_total']}</td>
                <td>
                    <a href='{$table['pdf_path']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
                </td>
            </tr>";
        }
    }

    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'INSERT INTO Facture ' . $assembler[0] . ' VALUES ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }

    function getUserInfo(int $id_paiement):array
    {
        return parent::select("SELECT u.nom, u.prenom, u.email
                        FROM Utilisateur u
                        JOIN Reservation r ON u.id = r.id_client
                        JOIN Paiement p ON r.id = p.id_reservation
                        WHERE p.id = :id_paiement;
                        ",['id_paiement'=>$id_paiement]);
    }
    function getLastId(){
        return Facture::$lastId;
    }

}
