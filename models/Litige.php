<?php

class Litige extends Dbase
{
    protected array $data = [];
    protected array $datatype = [
        'id' => 'integer',
        'id_client' => 'integer',
        'id_reservation' => 'integer',
        'description' => 'string',
        'statut' => 'string',
        'date_ouverture' => 'string',
        'date_cloture' => 'string',
        'solution' => 'string',
    ];


    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'insert into Litige ' . $assembler[0] . ' values ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }


    public static function get(int $id): array
    {
        return parent::select("select * from Litige where id=$id");
    }


    public static function delete(int $id)
    {
        parent::instruction("delete from Litige where id=:id", ['id' => $id]);
    }


    public static function update(int $id, array $data)
    {
        parent::instruction("update Litige set " . parent::equalizer($data) . " where id={$id}", $data);
    }


    public static function ShowAll(int $agence_id)
    {
        $tables = parent::select("SELECT 
        L.id AS id, 
        L.id_client, 
        L.id_reservation, 
        L.description, L.statut, L.date_ouverture, L.date_cloture, L.solution
        FROM Litige L
        JOIN Reservation R ON L.id_reservation = R.id
        JOIN Offre_Location O ON O.id = R.id_offre
        JOIN Vehicule V ON V.id = O.id_vehicule
        WHERE V.agence_id = :agence_id
", ['agence_id' => $agence_id]);
        foreach ($tables as $table) {
            echo " <tr>
                    <td>{$table['id']}</td>
                    <td>{$table['id_client']}</td>
                    <td>{$table['id_reservation']}</td>
                    <td>{$table['date_ouverture']}</td>
                    <td>{$table['date_cloture']}</td>
                    <td>{$table['description']}</td>                   
                    <td>{$table['solution']}</td>
                    <td>
                        <a href='./DetailPlainte.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
                    </td>
                </tr>";
        }
    }
}
