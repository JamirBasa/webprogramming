<?php

require_once 'database.php';

class Account
{
    public $id = '';
    public $first_name = '';
    public $last_name = '';
    public $username = '';
    public $password = '';
    public $role = 'staff';
    public $is_staff = true;
    public $is_admin = false;


    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function add()
    {
        $sql = "INSERT INTO account (first_name, last_name, username, password, role, is_staff, is_admin) VALUES (:first_name, :last_name, :username, :password, :role, :is_staff, :is_admin);";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':username', $this->username);
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);
        $query->bindParam(':role', $this->role);
        $query->bindParam(':is_staff', $this->is_staff);
        $query->bindParam(':is_admin', $this->is_admin);

        return $query->execute();
    }

    function usernameExist($username, $excludeID)
    {
        $sql = "SELECT COUNT(*) FROM account WHERE username = :username";
        if ($excludeID) {
            $sql .= " and id != :excludeID";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);

        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }

        $count = $query->execute() ? $query->fetchColumn() : 0;

        return $count > 0;
    }

    function login($username, $password)
    {
        $sql = "SELECT * FROM account WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);

        if ($query->execute()) {
            $data = $query->fetch();
            if ($data && password_verify($password, $data['password'])) {
                return true;
            }
        }

        return false;
    }

    function fetch($username)
    {
        $sql = "SELECT * FROM account WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }

        return $data;
    }

    public function fetchAccount()
    {
        // Define the SQL query to select all columns from the 'category' table,
        // ordering the results by the 'role' column in ascending order.
        $sql = "SELECT * FROM account ORDER BY role ASC;";

        // Prepare the SQL statement for execution using a database connection.
        $query = $this->db->connect()->prepare($sql);

        // Initialize a variable to hold the fetched data. This will store the results of the query.
        $data = null;

        // Execute the prepared SQL query.
        // If the execution is successful, fetch all the results from the query's result set.
        // Use fetchAll() to retrieve all rows as an array of associative arrays.
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array.
        }

        // Return the fetched data. This will be an array of categories, where each category
        // is represented as an associative array with column names as keys.
        return $data;
    }


    public function showAll($keyword = '')
    {
        // If a keyword is provided, use it for filtering; otherwise, return all rows
        if (!empty($keyword)) {
            $sql = "SELECT * FROM account 
                    WHERE role LIKE CONCAT('%', :keyword, '%') 
                    OR first_name LIKE CONCAT('%', :keyword, '%')
                    OR last_name LIKE CONCAT('%', :keyword, '%')
                    OR username LIKE CONCAT('%', :keyword, '%') 
                    ORDER BY role ASC;";
        } else {
            $sql = "SELECT * FROM account ORDER BY role ASC;";
        }

        // Prepare the SQL statement
        $query = $this->db->connect()->prepare($sql);

        // Bind the keyword if it's not empty
        if (!empty($keyword)) {
            $query->bindParam(':keyword', $keyword);
        }

        $data = null; // Initialize the data holder

        // Execute the query and fetch the results
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
        }

        return $data; // Return the data
    }
}

//$obj = new Account();

//$obj->fetchAccount();

//var_dump($obj);