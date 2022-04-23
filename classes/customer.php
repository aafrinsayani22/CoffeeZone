<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-18 Created classes folder and files
// Aafrin Sayani (2030150) 2022-04-18 Added singular class.
// Aafrin Sayani (2030150) 2022-04-18 completed singular class customer.


class customer {

    const EMPLOYEE_ID_MAX_LENGTH = 20;
    const FIRSTNAME_MAX_LENGTH = 20;
    const LASTNAME_MAX_LENGTH = 20;
    const ADDRESS_MAX_LENGTH = 25;
    const CITY_MAX_LENGTH = 25;
    const PROVINCE_MAX_LENGTH = 25;
    const POSTAL_CODE = 7;
    const USERNAME_MAX_LENGTH = 20;
    const PASSWORD_MAX_LENGTH = 255;

    private $customer_id = "";
    private $firstname = "";
    private $lastname = "";
    private $address = "";
    private $city = "";
    private $province = "";
    private $postal_code = "";
    private $username = "";
    private $password = "";
    private $avatar = "";
    
    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getAddress() {
        return $this->address;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function getProvince() {
        return $this->province;
    }
    
    public function getPostal_code() {
        return $this->postal_code;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
    
    public function getAvatar() {
        return $this->avatar;
    }

    public function setFirstname($newFirstname) {

        if (mb_strlen($newFirstname) == 0) {
            return "Please enter a firstname..";
        }
        if (mb_strlen($newFirstname) > self::FIRSTNAME_MAX_LENGTH) {
            return "The firstname must be less than 20.";
        }
        else {
            $this->firstname = $newFirstname;
        }
    }
    
    public function setLastname($newLastname) {

        if (mb_strlen($newLastname) == 0) {
            return "Please enter a lastname.";
        } 
        if (mb_strlen($newLastname) > self::LASTNAME_MAX_LENGTH) {
            return "The lastname must be less than 20 char";
        } 
        else {
            $this->lastname = $newLastname;
        }
    }
    
    public function setCity($newCity) {

        if (mb_strlen($newCity) == 0) {
            return "Please enter a City.";
        }
        if (mb_strlen($newCity) > self::CITY_MAX_LENGTH) {
            return "The city must be less than 25";
        }
        else {
            $this->city = $newCity;
        }
    }
    
    public function setAddress($newAddress) {

        if (mb_strlen($newAddress) == 0) {
            return "Please enter address.";
        }
        
        if (mb_strlen($newAddress) > self::ADDRESS_MAX_LENGTH) {
            return "The address must be less than 25 ";
        }
        else {
            $this->address = $newAddress;
        }
    }
    public function setPostal_code($newPostal_code) {

        if (mb_strlen($newPostal_code) == 0) {
            return "Please enter postal code.";
        }
        if (mb_strlen($newPostal_code) > self::POSTAL_CODE ) {
            return "The postal code must be less than 7";
        }
        else {
            $this->postal_code = $newPostal_code;
        }
    }
    public function setProvince($newProvince) {

        if (mb_strlen($newProvince) == 0) {
            return "Please enter province..";
        }
        if (mb_strlen($newProvince) > self::PROVINCE_MAX_LENGTH) {
            return "The province must be less than 25 char";
        }
        else {
            $this->province = $newProvince;
        }
    }
        public function setUsername($newUsername) {

        if (mb_strlen($newUsername) == 0) {
            return "Please enter Username.";
        }
        if (mb_strlen($newUsername) > self::USERNAME_MAX_LENGTH) {
            return "The username is empty";
        }
        else {
            $this->username = $newUsername;
        }
    }
    public function setPassword($newPassword) {

        if (mb_strlen($newPassword) == 0) {
            return "Please enter Password.";
        }
        if (mb_strlen($newPassword) > self::PASSWORD_MAX_LENGTH) {
            return "The password must be 255 char";
        }
        else {
            $this->password = $newPassword;
        }
    }
    public function setAvatar($newAvatar) {

        if (mb_strlen($newAvatar) == 0) {
            return "The avatar is empty";
        }
        else {
            $this->avatar = $newAvatar;
        }
    }
    
    #optional gettter PK

//    public function setCustomerId($newCustomer_id) {
//
//        if (mb_strlen($newCustomer_id) == 0) {
//            return "The primary ....... empty";
//        } else {
//            $this->employee_id = $newCustomer_id;
//        }
//    }

    public function _construct( $firstname, $lastname, $address, $city,$province, $postal_code, $username, $password, $avatar) {
 
        
        if ($firstname != "") {
            $this->setFirstname($firstname);
        }
        
        if ($lastname != "") {
            $this->setLastname($lastname);
        }
        
        if ($address != "") {
            $this->setAddress($address);
        }
        
        if ($city != "") {
            $this->setCity($city);
        }
        
        if ($province == "") {
            $this->setProvince(NULL);
        }
        
        if ($postal_code != "") {
            $this->setPostal_code($postal_code);
        }
        
        if ($username != "") {
            $this->setUsername($username);
        }
        
        if ($password != "") {
            $this->setPassword($password);
        }
        
        if ($avatar != "") {
            $this->setAvatar($avatar);
        }
        
    }

    public function load($customer_id) {
        global $connection;
        //$sql = "call customer_all()";
        $sql = "CALL customer_select(:cutomer_id)";
//        $sql = "SELECT * FROM customers WHERE customer_id = " .
//                " = :customer_id";

        $PDOobject = $connection->prepare($sql);
        $PDOobject->bindParam(':customer_id', $customer_id);
        $PDOobject->execute();

        if ($row = $PDOobject->fetch(PDO::FETCH_ASSOC)) {
            $this->customer_id = $row["customer_id"];
            $this->firstname = $row["firstname"];
            $this->lastname = $row["lastname"];
            $this->address = $row["address"];
            $this->city = $row["city"];
            $this->province = $row["province"];
            $this->postal_code = $row["postal_code"];
            $this->username = $row["username"];
            $this->password = $row["password"];
            $this->avatar = $row["avatar"];
            return true;
        }
    }

    public function save() {

        global $connection;

        if (($this->firstname != "")&& ($this->lastname != "") && ($this->address != "") && ($this->city != "")
                && ($this->postal_code != "")&& ($this->province != "") && ($this->username != "")&& ($this->password != "")&& ($this->avatar != "")) {
            
            $sql = "call customer_insert(:firstname, :lastname, :address, :city, :province, :postal_code, :province, :username, :password, :avatar)";
            
            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':firstname', $this->firstname);
            $PDOobject->bindParam(':lastname', $this->lastname);
            $PDOobject->bindParam(':address', $this->address);
            $PDOobject->bindParam(':city', $this->city);
            $PDOobject->bindParam(':province', $this->province);
            $PDOobject->bindParam(':postal_code', $this->postal_code);
            $PDOobject->bindParam(':username', $this->username);
            $PDOobject->bindParam(':password', $this->password);
            $PDOobject->bindParam(':avatar', $this->avatar);
            $PDOobject->execute();
            return true;
        }
        else
        {
           $sql =  "call customer_update(:customer_id,:firstname, :lastname, :address, :city, :province, :postal_code, :province, :username, :password, :avatar)";


            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':firstname', $this->firstname);
            $PDOobject->bindParam(':lastname', $this->lastname);
            $PDOobject->bindParam(':address', $this->address);
            $PDOobject->bindParam(':city', $this->city);
            $PDOobject->bindParam(':province', $this->province);
            $PDOobject->bindParam(':postal_code', $this->postal_code);
            $PDOobject->bindParam(':username', $this->username);
            $PDOobject->bindParam(':password', $this->password);
            $PDOobject->bindParam(':avatar', $this->avatar);
            $PDOobject->execute();
            
            return true;
        }


    }
    
        public function delete() {

        global $connection;

        if ($this->customer_id != "") {
            
            $sql = "call customer_delete(:customer_id)";

            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':customer_id', $this->customer_id);
            $PDOobject->execute();
            return true;
        }

    }

}
