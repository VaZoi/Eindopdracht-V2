<?php

require 'db.php';

class User 
{
    public $dbh;
    public $table = 'users';
    public $employeetable = 'staff';
    public $carstable = 'cars';
    public $locationstable = 'locations';

    public function __construct(DB $dbh)
    {
        $this->dbh = $dbh;
        session_start();
    }

    public function hash($password) : string 
    {
    return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getallcustomers() : array 
    {
        return $this->dbh->run("SELECT * from $this->table where type = 'klant")->fetchAll();
    }

    public function firstuser($id) : array 
    {
        return $this->dbh->run("SELECT * from $this->table where user_id = $id")->fetch();
    }

    public function adduser($firstname, $lastname, $dateofbirth, $email, $phonenumber, $postalcode, $country, $city, $street, $housenumber, $password) : int
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $hash = $this->hash($password);
        $this->dbh->run("INSERT INTO $this->table (firstname, lastname, date_of_birth, email, phonenumber, postalcode, country, city, street, housenumber, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$firstname, $lastname, $dateofbirth, $email, $phonenumber, $postalcode, $country, $city, $street, $housenumber, $hash]);
        return $this->dbh->lastId();
    }

    public function edituser($updatedFirstName, $updatedLastName, $updatedDateOfBirth, $updatedEmail, $updatedPhoneNumber, $updatedPostalCode, $updatedCountry, $updatedCity, $updatedStreet, $updatedHouseNumber, $updatedPassword, $user_id) : PDOStatement 
    {
        $hash = $this->hash($updatedPassword);
        return $this->dbh->run("UPDATE $this->table SET firstname ='$updatedFirstName', lastname ='$updatedLastName', dateofbirth = '$updatedDateOfBirth', email ='$updatedEmail', phonenumber ='$updatedPhoneNumber', postalcode ='$updatedPostalCode', country ='$updatedCountry', city ='$updatedCity', street ='$updatedStreet', housenumber ='$updatedHouseNumber', password = '$hash' WHERE user_id = $user_id");
    }

    public function deleteuser($id) : PDOStatement
    {
        return $this->dbh->run("DELETE FROM $this->table where user_id = $id");
    }

    public function getallemployees() : array 
    {
        return $this->dbh->run("SELECT * from $this->employeetable")->fetchAll();
    }

    public function addemployee($firstname, $lastname, $dateofbirth, $work_email, $private_email, $phonenumber, $salary, $department, $function, $postalcode, $country, $city, $street, $housenumber, $password) : int
    {
        $work_email = filter_var($work_email, FILTER_VALIDATE_EMAIL);
        $private_email = filter_var($private_email, FILTER_VALIDATE_EMAIL);

        $hash = $this->hash($password);
        $this->dbh->run("INSERT INTO $this->employeetable (firstname, lastname, date_of_birth, work_email, private_email, phonenumber, salary, department, function, postalcode, country, city, street, housenumber, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$firstname, $lastname, $dateofbirth, $work_email, $private_email, $phonenumber, $salary, $department, $function, $postalcode, $country, $city, $street, $housenumber, $hash]);
        return $this->dbh->lastId();
    }

    public function editemployee($updatedFirstName, $updatedLastName, $updatedDateOfBirth, $updatedWorkEmail, $updatedPrivateEmail, $updatedPhoneNumber, $updatedSalary, $updatedDepartment, $updatedFunction, $updatedPostalCode, $updatedCountry, $updatedCity, $udatedStreet, $updatedHouseNumber, $updatedPassword, $user_id) : PDOStatement 
    {
        $hash = $this->hash($updatedPassword);
        return $this->dbh->run("UPDATE $this->employeetable SET firstname ='$updatedFirstName', lastname ='$updatedLastName', dateofbirth ='$updatedDateOfBirth', work_email ='$updatedWorkEmail', private_email ='$updatedPrivateEmail', phonenumber ='$updatedPhoneNumber', salary ='$updatedSalary', department ='$updatedDepartment', function ='$updatedFunction', postalcode ='$updatedPostalCode', country ='$updatedCountry', city ='$updatedCity', street ='$udatedStreet', housenumber ='$updatedHouseNumber', password = '$hash' WHERE staff_id = $user_id");
    }

    public function deleteemployee($id) : PDOStatement
    {
        return $this->dbh->run("DELETE FROM $this->employeetable where staff_id = $id");
    }

    public function countStaff() : int
    {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->employeetable")->fetchColumn();
    }

    public function countCustomers() : int
    {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->table WHERE type = 'customer'")->fetchColumn();
    }

    public function countcars() : int
    {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->carstable")->fetchColumn();
    }

    public function countLocations() : int
    {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->locationstable")->fetchColumn();
    }


    // Authenticate user
    public function login($email, $password) : bool 
    {
        $stmt = $this->dbh->run("SELECT * FROM $this->table WHERE email = ?", [$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
        
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = htmlspecialchars($user['email']);
        
            // Check the "type" column
            if ($user['type'] === 'customer') {
                header("Location: home.php");
                exit();
            } elseif ($user['type'] === 'admin') {
                header("Location: admin.php");
                exit();
            }
        }

        return false;
    }

    // Check if a user is logged in
    public function isLoggedIn() : bool
    {
        return isset($_SESSION['user_id']);
    }

    public function isLoggedInAsAdmin() : bool
    {
        return $this->isLoggedIn() && $_SESSION['user_type'] === 'admin';
    }

    public function logout() : void
    {
        session_destroy();
        session_start();
    }

    public function generateCsrfToken() : string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
}

$myDb = new DB();
$user = new User($myDb);