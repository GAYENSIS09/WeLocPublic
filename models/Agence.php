<?php 
class Agence extends Dbase
{
    protected array $data = [];
    protected array $datatype = [
        'id' => 'integer',
        'nom' => 'string',
        'adresse' => 'string',
        'telephone' => 'string',
        'email' => 'string',
        'openHours' => 'DateTime',
        'closeHours' => 'DateTime',
        'vehicule' => '?array' // Nullable array
    ];

    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'INSERT INTO Agence ' . $assembler[0] . ' VALUES ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }

    public static function get(int $id): array
    {
        return parent::select("SELECT * FROM Agence WHERE id=$id");
    }

    public static function delete(int $id)
    {
        parent::instruction("DELETE FROM Agence WHERE id=:id", ['id' => $id]);
    }

    public static function update(int $id, array $data)
    {
        parent::instruction("UPDATE Agence SET " . parent::equalizer($data) . " WHERE id={$id}", $data);
    }

    public static function ShowAgences(array $agences,bool $w_dot=false)
    {
        foreach($agences as $key => $agence){
            $dot= $w_dot ? '.' : '';

            echo '
            <li>
                <form id="formAgence'.$key.'" action="'.$dot.'./connect.php" method="post">
                    <input type="hidden" name="agence_id" value="'.$agence['id'].'">
                    <a href="#" class="dropdown-item" onclick="document.getElementById(\'formAgence'.$key.'\').submit(); return false;"><i class="fas fa-car-side"></i>&nbsp;&nbsp;'
                        . htmlspecialchars($agence['nom']) . 
                    '</a>
                </form>
            </li>';
        }
    }
    

    public static function ShowAll()
    {
        $tables = parent::select("SELECT * FROM Agence");
        foreach ($tables as $table) {
            echo "<tr>
                <td>{$table['id']}</td>
                <td>{$table['nom']}</td>
                <td>{$table['adresse']}</td>
                <td>{$table['telephone']}</td>
                <td>{$table['email']}</td>
                <td>{$table['openHours']}</td>
                <td>{$table['closeHours']}</td>
                <td>
                    <a href='./DetailAgence.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
                </td>
            </tr>";
        }
    }
}
?>