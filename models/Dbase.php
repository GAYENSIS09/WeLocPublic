<?php

use function PHPSTORM_META\type;

class Dbase
{
  
    protected static  $db ;
    static protected ?int $lastId=null;
    protected array $data = [];
    protected array $datatype = [];
    function __set($name, $value)
    {
        if (!isset($value) || !isset($name) || !$this->datatype[$name]) {
            throw new Exception("la valeur n'est pas definie");
        }
        if ($this->datatype[$name] !== gettype($value)) {
            throw new Exception("incorrecte : le type de $name doit etre {$this->datatype[$name]} != ".gettype($value));
        }
        $this->data[$name] = $value;
    }
    //definir les attributs
    public function setAttributs(array $data): void
    {
        foreach ($data as $name => $value) {
            $this->__set($name, $value);
        }
    }

    function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        throw new Exception("{$name} n'existe pas.");
    }

   
    private static function run($query, ?array $table):void
    {
        try {
            self::$db->beginTransaction();
            $query->execute($table);
            self::$lastId=self::$db->lastInsertId();
            self::$db->commit();
        } catch (PDOException $error) {
            self::$db->rollBack();
            die($error->getMessage());
        }
    }
    //fonction de selection directe d'une requete et le retour sous forme de talbeau

    public static function select(string $query, ?array $param = null): array
    {
        self::initDb();
        $query = self::$db->prepare($query);
        self::run($query, $param);
        return $query->fetchAll(PDO::FETCH_BOTH);
    }


    public static function instruction(string $query, array $param): void
    {
        self::initDb();
        $query = self::$db->prepare($query);
        self::run($query, $param);
    }

    private static function initDb(): void
    {
        if (self::$db === null) {
            try {
                self::$db = new PDO("mysql:host=localhost;dbname=WeLoc", "", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                error_log("Erreur de connexion PDO : " . $e->getMessage());
                die("Impossible de se connecter à la base de données.");
            }
        }
    }
    public static function equalizer(array $data):string{
        $result='';
        foreach($data as $name=>$value){
            $result.=$name.'=:'.$name;
            if(array_key_last($data)!==$name){
                $result.=',';
            }
        }
        return $result;
    }
    public static function assembler(array $data)
    {
        $concat_1 = '';
        $concat_2 = '';
        $table=[];
        if (!empty($data)) {
            foreach ($data as $name => $value) {
                if (gettype($value) !== 'array') {
                    $table[$name]=$value;
                    if ($name === array_key_first($data)) {
                        $concat_1 .= '(' . $name;
                        $concat_2 .= '(:' . $name;
                    }

                    if ($name !== array_key_first($data)) {
                        $concat_1 .= ',' . $name;
                        $concat_2 .= ',:' . $name;
                    }
                }
            }
            $concat_1 .= ')';
            $concat_2 .= ')';
        }
        return [$concat_1, $concat_2,$table];
    }
    function __destruct()
    {
        self::$db = null;
    }
}
