<?php

class AdminModel {

    function __construct($db) {
        $this->db = $db;
    }

    /*
     * аутентификация администратора
     */
    function auth($login,$password) {
        try {
            $sqlAuth = 'SELECT user_id, login, password FROM users WHERE login=? AND password=?';
            $query = $this->db->prepare($sqlAuth);
            $query->execute([$login, $password]);
            $result = $query->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        if ($login == $result['login'] && $password == $result['password']) {
            $_SESSION['user_id'] = $result['user_id'];
            header('location: index.php');
        }
    }

    /*
     * логаут
     */
    function logout() {
        session_destroy();
        header('Location: index.php');
    }

    /*
     * получение списка администраторов
     */
    function getAdminsList() {
        try {
            $sqlGetAdminsList = 'SELECT user_id, login, password FROM users';
            $query = $this->db->prepare($sqlGetAdminsList);
            $query->execute();
            $adminsList = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $adminsList;
    }

    /*
     * создание нового админа
     */
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

    /*
     * удаление администратора
     */
    function deleteAdmin($id) {
        try {
            $sqlDeleteAdmin = 'DELETE FROM users WHERE user_id = ?';
            $this->db->prepare($sqlDeleteAdmin)->execute([$id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * смена пароля администратора
     */
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