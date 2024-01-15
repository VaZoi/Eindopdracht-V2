<?php

require 'db.php';

class User 
{
    public $dbh;
    public $table = 'users';

    public $employeetable = 'staff';
    public $carstable = 'cars';
    public $locationstable = 'locations';

    public $bookingstable = 'bookings';

    public function __construct(DB $dbh)
    {
        $this->dbh = $dbh;
        session_start();
    }

    public function hash($password) : string 
    {
    return password_hash($password, PASSWORD_DEFAULT);
    }

    // users

    public function getallcustomers() : array 
    {
        return $this->dbh->run("SELECT * from $this->table Where type = 'customer'")->fetchAll();
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

    public function deleteuser($car_id) : PDOStatement
    {
        return $this->dbh->run("DELETE FROM $this->table where user_id = $car_id");
    }

    // cars

    public function firstcar($id) : array 
    {
        return $this->dbh->run("SELECT * from $this->carstable where car_id = $id")->fetch();
    }

    public function getallcars() : array 
    {
        return $this->dbh->run("SELECT * from $this->carstable")->fetchAll();
    }

    public function addcars($brand, $model, $licence_plate, $year, $color, $fueltype, $image) : int
    {
        $this->dbh->run("INSERT INTO $this->carstable (brand, model, licence_plate, year, color, fueltype, image) VALUES (?, ?, ?, ?, ?, ?, ?)", [$brand, $model, $licence_plate, $year, $color, $fueltype, $image]);
        return $this->dbh->lastId();
    }

    public function editcars($updatedbrand, $updatedmodel, $updatedlicence_plate, $updatedyear, $updatedcolor, $updatedfueltype, $updatedavailability, $updatedimage, $car_id) : PDOStatement 
    {
        return $this->dbh->run("UPDATE $this->carstable SET brand = ?, model = ?, licence_plate = ?, year = ?, color = ?, fueltype = ?, availability = ?, image = ? WHERE car_id = ?", [$updatedbrand, $updatedmodel, $updatedlicence_plate, $updatedyear, $updatedcolor, $updatedfueltype, $updatedavailability, $updatedimage, $car_id]);
    }

    public function deletecar($car_id) : PDOStatement
    {
        return $this->dbh->run("DELETE FROM $this->carstable where car_id = $car_id");
    }

    // employees

    public function firstemployee($id) : array 
    {
        return $this->dbh->run("SELECT * from $this->employeetable where staff_id = $id")->fetch();
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

    public function editemployee($updatedFirstName, $updatedLastName, $updatedDateOfBirth, $updatedWorkEmail, $updatedPrivateEmail, $updatedPhoneNumber, $updatedSalary, $updatedDepartment, $updatedFunction, $updatedPostalCode, $updatedCountry, $updatedCity, $updatedStreet, $updatedHouseNumber, $updatedPassword, $employee_id) : PDOStatement 
    {
        $hash = $this->hash($updatedPassword);
        return $this->dbh->run("UPDATE $this->employeetable SET firstname ='$updatedFirstName', lastname ='$updatedLastName', dateofbirth ='$updatedDateOfBirth', work_email ='$updatedWorkEmail', private_email ='$updatedPrivateEmail', phonenumber ='$updatedPhoneNumber', salary ='$updatedSalary', department ='$updatedDepartment', function ='$updatedFunction', postalcode ='$updatedPostalCode', country ='$updatedCountry', city ='$updatedCity', street ='$updatedStreet', housenumber ='$updatedHouseNumber', password = '$hash' WHERE staff_id = $employee_id");
    }


    public function deleteemployee($id) : PDOStatement
    {
        return $this->dbh->run("DELETE FROM $this->employeetable where staff_id = $id");
    }

    /// locations 

    public function firstlocation($id) : array 
    {
        return $this->dbh->run("SELECT * from $this->locationstable where location_id = $id")->fetch();
    }

    public function getalllocations() : array 
    {
        return $this->dbh->run("SELECT * from $this->locationstable")->fetchAll();
    }

    public function addlocation($image, $name, $postalcode, $country, $city, $street, $housenumber, $phonenumber, $email) : int
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->dbh->run("INSERT INTO $this->locationstable (image, location_name, postalcode, country, city, street, housenumber, phonenumber, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [$image, $name, $postalcode, $country, $city, $street, $housenumber, $phonenumber, $email]);

        return $this->dbh->lastId();
    }


    public function editlocation($updatedimage, $updatedname, $updatedpostalcode, $updatedcountry, $updatedcity, $updatedstreet, $updatedhousenumber, $updatedphonenumber, $updatedemail, $location_id) : PDOStatement 
    {
        return $this->dbh->run("UPDATE $this->locationstable SET image ='$updatedimage', location_name ='$updatedname', postalcode ='$updatedpostalcode', country ='$updatedcountry', city ='$updatedcity', street ='$updatedstreet', housenumber ='$updatedhousenumber', phonenumber ='$updatedphonenumber', email ='$updatedemail' WHERE location_id = $location_id");
    }

    public function deletelocation($id) : PDOStatement
    {
        return $this->dbh->run("DELETE FROM $this->locationstable where location_id = $id");
    }

    /// bookings

    public function getCustomerBookings($customer_id): array
    {
        return $this->dbh->run("SELECT * FROM $this->bookingstable WHERE customer_id = ?", [$customer_id])->fetchAll();
    }

    public function firstbooking($id) : array 
    {
        return $this->dbh->run("SELECT * from $this->bookingstable where booking_id = $id")->fetch();
    }

    public function getallbookings() : array 
    {
        return $this->dbh->run("SELECT * from $this->bookingstable")->fetchAll();
    }

    public function addbooking($customerid, $carid, $pickupdate, $returndate, $pickuplocation, $returnlocation, $totalCost) : int
    {
        $car = $this->firstcar($carid);
        if (!$car || $car['availability'] === 0) {
            throw new \Exception("Selected car is not available.");
        }

        $this->dbh->run("UPDATE $this->carstable SET availability = 0 WHERE car_id = ?", [$carid]);

        $this->dbh->run("INSERT INTO $this->bookingstable (customer_id, car_id, pickup_date, return_date, pickup_location, return_location, total_cost) VALUES (?, ?, ?, ?, ?, ?, ?)", [$customerid, $carid, $pickupdate, $returndate, $pickuplocation, $returnlocation, $totalCost]);

        return $this->dbh->lastId();
    }

    public function editbooking($updatedcustomerid, $updatedcarid, $updatedpickupdate, $updatedreturndate, $updatedpickuplocation, $updatedreturnlocation, $updatedtotalcost, $updatedstatus, $booking_id) : PDOStatement 
    {
        $originalBooking = $this->firstbooking($booking_id);

        if ($originalBooking['status'] === 'Completed' || $originalBooking['status'] === 'Cancelled') {
            throw new \Exception("Cannot edit a completed or cancelled booking.");
        }

        $stmt = $this->dbh->run("UPDATE $this->bookingstable SET customer_id = ?, car_id = ?, pickup_date = ?, return_date = ?, pickup_location = ?, return_location = ?, total_cost = ?, status = ? WHERE booking_id = ?", [$updatedcustomerid, $updatedcarid, $updatedpickupdate, $updatedreturndate, $updatedpickuplocation, $updatedreturnlocation, $updatedtotalcost, $updatedstatus, $booking_id]);

        if (($originalBooking['status'] !== $updatedstatus) && ($updatedstatus === 'Completed' || $updatedstatus === 'Cancelled')) {
            $this->dbh->run("UPDATE $this->carstable SET availability = 1 WHERE car_id = ?", [$originalBooking['car_id']]);
        }

        return $stmt;
    }

    public function deletebooking($id) : PDOStatement
    {
        $bookingInfo = $this->firstbooking($id);

        if ($bookingInfo['status'] === 'active') {
            $this->dbh->run("UPDATE $this->carstable SET availability = 1 WHERE car_id = ?", [$bookingInfo['car_id']]);
        }

        return $this->dbh->run("DELETE FROM $this->bookingstable WHERE booking_id = ?", [$id]);
    }


    /// count

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

    public function getReservedCars() : int {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->carstable WHERE availability = 0")->fetchColumn();
    }

    public function countLocations() : int
    {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->locationstable")->fetchColumn();
    }

    public function getActiveBookingCount() : int {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->bookingstable WHERE status = 'active'")->fetchColumn();
    }

    public function gettotalbookings() : int {
        return $this->dbh->run("SELECT COUNT(*) FROM $this->bookingstable")->fetchColumn();
    }

    /// get all ids

    public function getcustomerid($id) {
        return $this->dbh->run("SELECT * from $this->table where user_id = $id AND WHERE type = 'customer'")->fetchall();
    }

    public function getcarid($id) {
        return $this->dbh->run("SELECT * from $this->carstable where car_id = $id")->fetchall();
    }

    public function getlocationid($id) {
        return $this->dbh->run("SELECT * from $this->locationstable where location_id = $id")->fetchall();
    }

    // Authenticate user
    public function login($email, $password): bool
    {
        $stmt = $this->dbh->run("SELECT * FROM $this->table WHERE email = ?", [$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = htmlspecialchars($user['type']);

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

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function isLoggedInAsAdmin(): bool
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