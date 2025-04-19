<?php

class Paiement extends Dbase
{
    protected array $data = [];
    protected array $datatype = [
        'id' => 'integer',
        'id_reservation' => 'integer',
        'montant' => 'double',
        'mode_paiement' => 'string',
        'statut' => 'string',
        'date_paiement' => 'string',
        'transaction_id' => 'integer',
    ];

    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'insert into Paiement ' . $assembler[0] . ' values ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }

    public static function is_id(int $id_paiement,$agence_id):int{
        $tables = parent::select("select P.id from Paiement P JOIN Reservation R ON P.id_reservation=R.id JOIN Offre_Location O ON O.id=R.id_offre JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id",['agence_id'=>$agence_id]);
        foreach($tables as $table){
            if($table['id']===$id_paiement){
                return 1;
            }
        }
        return 0;
    }
    public static function is_transac(int $id_transaction,$agence_id):int{
        $tables = parent::select("select P.transaction_id from Paiement P JOIN Reservation R ON P.id_reservation=R.id JOIN Offre_Location O ON O.id=R.id_offre JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id",['agence_id'=>$agence_id]);
        foreach($tables as $table){
            if($table['transaction_id']===$id_transaction){
                return 1;
            }
        }
        return 0;
    }
    
    public static function ShowAll(int $agence_id)
    {
        $tables = parent::select("select P.* from Paiement P JOIN Reservation R ON P.id_reservation=R.id JOIN Offre_Location O ON O.id=R.id_offre JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id",['agence_id'=>$agence_id]);
        foreach ($tables as $table) {
            echo " <tr>
                    <td>{$table['id']}</td>
                    <td>{$table['id_reservation']}</td>
                    <td>{$table['transaction_id']}</td>
                    <td>{$table['mode_paiement']}</td>
                    <td>{$table['date_paiement']}</td>
                    <td>{$table['statut']}</td>
                    <td>{$table['montant']}</td>
                </tr>";
        }
    }
}
