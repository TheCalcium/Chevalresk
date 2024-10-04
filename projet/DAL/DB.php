<?php
include_once "DAL/tables/joueurs.php";
include_once "DAL/tables/niveaux.php";
include_once "DAL/tables/items.php";
include_once "DAL/tables/typesItems.php";
include_once "DAL/tables/armes.php";
include_once "DAL/tables/genres.php";
include_once "DAL/tables/armures.php";
include_once "DAL/tables/tailles.php";
include_once "DAL/tables/elements.php";
include_once "DAL/tables/typesElements.php";
include_once "DAL/tables/potions.php";
include_once "DAL/tables/typesPotions.php";
include_once "DAL/tables/difficultesEnigmes.php";
include_once "DAL/tables/enigmes.php";
include_once "DAL/tables/typeEnigmes.php";
include_once "DAL/tables/reponses.php";
include_once "DAL/tables/elementsPotions.php";
include_once "DAL/tables/Evaluations.php";
include_once "DAL/tables/statistiquesJoueurs.php";

class DB {
    private static $_instance = null;
    private $host;
    private $username;
    private $password;
    private $dbName;
    private $autoCommit;
    public $conn;

    public function __construct($host, $username, $password, $dbName)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->conn = new PDO("mysql:host={$host};dbname=$dbName", $username, $password);
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            $env = parse_ini_file(".env");
            self::$_instance = new DB($env["DB_HOST"], $env["DB_USERNAME"], $env["DB_PASSWORD"], $env["DB_NAME"]);
        }
        return self::$_instance;
    }

    public function tryExecute($statement, $args = []) {
        try {
            $statement->execute($args);
            return $statement->fetchAll();
        }
        catch(Exception $e) {
            echo 'Error: '. $e->getMessage();
            return [];
        }
    }
    
    public function selectAll($table) {
        $sql = "SELECT * FROM $table";
        $statement = $this->conn->prepare($sql);
        return $this->tryExecute($statement);
    }

    public function selectWhere($table, $conditions) {
        $sqlConditions = implode(" AND ", array_map(fn($c): string => "$c[0] $c[1] :$c[0]", $conditions));
        $sql = "SELECT * FROM $table WHERE " . $sqlConditions;
        
        $args = [];
        foreach($conditions as $c) {
            $args[$c[0]] = $c[2];
        }

        $statement = $this->conn->prepare($sql);

        return $this->tryExecute($statement, $args);
    }

    public function call($proc, $args) {
        $keys = array_map(fn($k): string => ":".$k, array_keys($args));
        $sql = "CALL $proc(". implode(", ", $keys).")";
        $statement = $this->conn->prepare($sql);

        return $this->tryExecute($statement, $args);
    }
}

function DB() {
    return DB::getInstance();
}
function Joueurs() {
    return new Joueurs(DB());
}
function Niveaux() {
    return new Niveaux(DB());
}
function Items() {
    return new Items(DB());
}
function TypesItems() {
    return new TypesItems(DB());
}
function Armes() {
    return new Armes(DB());
}
function Genres() {
    return new Genres(DB());
}
function Armures() {
    return new Armures(DB());
}
function Tailles() {
    return new Tailles(DB());
}
function Elements() {
    return new Elements(DB());
}
function TypesElements() {
    return new TypesElements(DB());
}
function Potions() {
    return new Potions(DB());
}
function TypesPotions() {
    return new TypesPotions(DB());
}
function TypesEnigmes(){
    return new TypesEnigmes(DB());
}
function DifficultesEnigmes(){
    return new DifficultesEnimges(DB());
}
function Enigmes(){
    return new enigmes(DB());
}
function Reponses(){
    return new Reponses(DB());
}
function ElementsPotions(){
    return new ElementsPotions(DB());
}
function Evaluations(){
    return new Evaluations(DB());
}
function StatistiquesJoueurs(){
    return new StatistiquesJoueurs(DB());
}