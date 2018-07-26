<?php

class AdminActions {
    function getAdminsList() {
        global $db;

        try {
            $sqlGetAdminsList = 'SELECT * FROM users';
            $query = $db->prepare($sqlGetAdminsList);
            $query->execute();
            $adminsList = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $adminsList;
    }

    function createAdmin($login, $password) {
        global $db;
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
                $db->prepare($sqlCreateAdmin)->execute([NULL, $login, $password]);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    function deleteAdmin($id) {
        global $db;

        try {
            $sqlDeleteAdmin = 'DELETE FROM users WHERE user_id = ?';
            $db->prepare($sqlDeleteAdmin)->execute([$id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function setPassword($id, $password) {
        global $db;

        try {
            $sqlUpdatePassword = 'UPDATE users SET password = ? WHERE user_id = ?';
            $db->prepare($sqlUpdatePassword)->execute([$password, $id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}