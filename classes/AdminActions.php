<?php

class AdminActions {

    function __construct($db) {
        $this->db = $db;
    }

    function getAdminsList() {
        try {
            $sqlGetAdminsList = 'SELECT * FROM users';
            $query = $this->db->prepare($sqlGetAdminsList);
            $query->execute();
            $adminsList = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $adminsList;
    }

    function createAdmin($login, $password) {
        $unique = true;

        $adminsList = $this->getAdminsList();
        foreach ($adminsList as $admin) {
            if ($admin['login'] == $login) {
                $unique = false;
            }
        }

        if ($unique) {
            try {
                $sqlCreateAdmin = 'INSERT INTO users (user_id, login, password) VALUES (?,?,?)';
                $this->db->prepare($sqlCreateAdmin)->execute([NULL, $login, $password]);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    function deleteAdmin($id) {
        try {
            $sqlDeleteAdmin = 'DELETE FROM users WHERE user_id = ?';
            $this->db->prepare($sqlDeleteAdmin)->execute([$id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function setPassword($id, $password) {
        try {
            $sqlUpdatePassword = 'UPDATE users SET password = ? WHERE user_id = ?';
            $this->db->prepare($sqlUpdatePassword)->execute([$password, $id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}