<?php
class Person
{
    private $conn;
    private $statement;
    public function __construct()
    {
        $host = 'localhost';
        $user = 'user_test_programmer';
        $pass = 'pass_test_programmer';
        $dbName = 'db_test_programmer';
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $str = "mysql:host=" . $host . ";dbname=" . $dbName;
            $this->conn = new PDO($str, $user, $pass, $option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Method To Get All Data person
    public function index()
    {
        $query = 'SELECT * FROM person';
        $this->exec([], $query);
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method For Data Binding, Use by store, update dan destroy
    public function exec($data, $query)
    {
        extract($data);
        unset($data);
        $this->statement = $this->conn->prepare($query);
        if (isset($person_id) && $person_id != null)
            $this->statement->bindValue(':person_id', $person_id, PDO::PARAM_INT);
        if (isset($name) && $name != null)
            $this->statement->bindValue(':name', $name, PDO::PARAM_STR);
        if (isset($gender) && $gender != null)
            $this->statement->bindValue(':gender', $gender, PDO::PARAM_STR);
        if (isset($parent_id) && $parent_id != null)
            $this->statement->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
        $this->statement->execute();
    }

    // Method To Create new Data Person
    public function store()
    {
        $_POST['parent_id'] = $_POST['parent_id'] == 'null' ? false : $_POST['parent_id'];
        if ($_POST['parent_id'])
            $query = "INSERT INTO person VALUES(:person_id, :name, :gender, :parent_id)";
        else
            $query = "INSERT INTO person(person_id, name, gender) VALUES(:person_id, :name, :gender)";
        $this->exec($_POST, $query);
        return $this->statement->rowCount();
    }

    // Method To Update new Data Person
    public function update()
    {
        $_POST['parent_id'] = $_POST['parent_id'] == 'null' ? false : $_POST['parent_id'];
        if ($_POST['parent_id'])
            $query = "UPDATE person SET name=:name, gender=:gender, parent_id=:parent_id WHERE person_id=:person_id";
        else
            $query = "UPDATE person SET name=:name, gender=:gender WHERE person_id=:person_id";
        $this->exec($_POST, $query);
        return $this->statement->rowCount();
    }

    // Method To Delete new Data Person
    public function destroy()
    {
        $person_id = $_GET['person_id'];
        $query = "DELETE FROM person WHERE person_id=:person_id";
        $this->exec(['person_id' => $person_id], $query);
        return $this->statement->rowCount();
    }

    // Method To Delete new Data Person
    public function show($person_id = null)
    {
        $person_id = isset($_GET['person_id']) ? $_GET['person_id'] : $person_id;
        $query = "SELECT * FROM person WHERE person_id=:person_id";
        $this->exec(['person_id' => $person_id], $query);
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    // Method For Generate data person and return to json to display person like tree / chart
    public function tree()
    {
        $query = 'SELECT a.name, a.gender, b.name as parent_name FROM person a LEFT JOIN person b ON a.parent_id=b.person_id';
        $this->exec([], $query);
        $data = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        $res = "";
        $conf = "";
        foreach ($data as $d) {
            $color = $d['gender'] == 'Laki-Laki' ? 'bg-primary' : 'bg-danger';
            $conf .= $d['name'] . ",";
            if ($d['parent_name'] == null)
                $res .= $d['name'] . "= { HTMLclass: '" . $color . "', text : { name : '" . $d['name'] . "',title : '" . $d['gender'] . "' }},";
            else
                $res .= $d['name'] . "= { HTMLclass: '" . $color . "',parent: " . $d['parent_name'] . ", text : { name : '" . $d['name'] . "',title : '" . $d['gender'] . "' }},";
        }
        $data = [
            'res' => $res,
            'conf' => rtrim($conf, ',')
        ];
        return $data;
    }
}
