<?php
class Promotion extends Dbase
{
    protected array $data = [];
    protected array $datatype = [
        'id' => 'integer',
        'code_promo' => 'string',
        'description' => 'string',
        'reduction' => 'integer',
        'date_debut' => 'string',
        'date_fin' => 'string',
        'max_utilisations' => 'integer',
        'utilisations' => 'integer',
        'agence_id' =>  'integer',
    ];

    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'INSERT INTO Promotion ' . $assembler[0] . ' VALUES ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }

    public static function get(int $id): array
    {
        return parent::select("SELECT * FROM Promotion WHERE id = $id");
    }

    public static function delete(int $id): void
    {
        parent::instruction("DELETE FROM Promotion WHERE id = :id", ['id' => $id]);
    }

    public static function update(int $id, array $data): void
    {
        parent::instruction("UPDATE Promotion SET " . parent::equalizer($data) . " WHERE id = {$id}", $data);
    }

    public static function ShowCurrent($agence_id): void
    {
        $tables = parent::select("SELECT * FROM Promotion where date_fin>CURDATE() AND agence_id=:agence_id", ['agence_id' => $agence_id]);
        foreach ($tables as $table) {
            echo " <tr>
                <td>{$table['id']}</td>
                <td>{$table['max_utilisations']}</td>
                <td>{$table['reduction']}</td>
                <td>{$table['utilisations']}</td>
                <td>{$table['code_promo']}</td>
                <td>{$table['date_debut']}</td>
                <td>{$table['date_fin']}</td>
                <td><a href='./DetailPromo.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a></td>
            </tr>";
        }
    }
    public static function usingPlus(string $code_promo): int
    {
        if ($code_promo !== '') {
            $tables = parent::select("SELECT code_promo,utilisations,max_utilisations FROM Promotion");
            foreach ($tables as $table) {
                if (($table['code_promo'] === $code_promo) && ($table['utilisations'] < $table['max_utilisations'])) {
                    parent::select("UPDATE Promotion SET utilisations=:utilisations WHERE code_promo=:code_promo", ['utilisations' => intval($table['utilisations'] + 1), 'code_promo' => $table['code_promo']]);
                    return 1;
                }
            }
            return 0;
        }
        return 1;
    }
     
    public static function usingMinus(string $code_promo): int
    {
        if ($code_promo !== '') {
            $tables = parent::select("SELECT code_promo,utilisations,max_utilisations FROM Promotion");
            foreach ($tables as $table) {
                if (($table['code_promo'] === $code_promo) && ($table['utilisations'] > 0)) {
                    parent::select("UPDATE Promotion SET utilisations=:utilisations WHERE code_promo=:code_promo", ['utilisations' => intval($table['utilisations'] - 1), 'code_promo' => $table['code_promo']]);
                    return 1;
                }
            }
            return 0;
        }
        return 1;
    }

    public static function ShowPast($agence_id): void
    {
        $tables = parent::select("SELECT * FROM Promotion where date_fin<=CURDATE() AND agence_id=:agence_id", ['agence_id' => $agence_id]);
        foreach ($tables as $table) {
            echo " <tr>
                 <td>{$table['id']}</td>
                <td>{$table['max_utilisations']}</td>
                <td>{$table['reduction']}</td>
                <td>{$table['utilisations']}</td>
                <td>{$table['code_promo']}</td>
                <td>{$table['date_debut']}</td>
                <td>{$table['date_fin']}</td>
                <td><a href='./DetailPromo.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a></td>
            </tr>";
        }
    }
}
