<?php 
class Entretien extends Dbase
{
    protected array $data = [];
    protected array $datatype = [
        'id' => 'integer',
        'id_vehicule' => 'integer',
        'description' => 'string',
        'cout' => 'double',
        'date' => 'string',
        'type_entretien' => 'string',
        'responsable' => 'string'
    ];

    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'INSERT INTO Entretien ' . $assembler[0] . ' VALUES ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }

    public static function get(int $id): array
    {
        return parent::select("SELECT * FROM Entretien WHERE id=$id");
    }

    public static function delete(int $id)
    {
        parent::instruction("DELETE FROM Entretien WHERE id=:id", ['id' => $id]);
    }

    public static function update(int $id, array $data)
    {
        parent::instruction("UPDATE Entretien SET " . parent::equalizer($data) . " WHERE id={$id}", $data);
    }

    public static function ShowAll(int $id_agence)
    {
        $tables = parent::select("SELECT * FROM Entretien where id_vehicule IN (select id from Vehicule where agence_id=:agence_id)",['agence_id'=>$id_agence]);
        foreach ($tables as $table) {
            echo "<tr>
                <td>{$table['id']}</td>
                <td>{$table['id_vehicule']}</td>
                <td>{$table['responsable']}</td>
                <td>{$table['type_entretien']}</td>
                <td>{$table['cout']}</td>
                <td>{$table['date']}</td>
                <td>{$table['description']}</td>
                <td>
                    <a href='./DetailEntretien.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
                </td>
            </tr>";
        }
    }
}

?>