<?php

class CategoriesModel {

    function __construct($db) {
        $this->db = $db;
    }

    /*
     * список категорий для пользователя
     */
    function getUserCategories() {                                                                          //  категории для пользователя
        try {
            $categoriesQuery = 'SELECT category_id, category_name FROM categories';
            $query = $this->db->prepare($categoriesQuery);
            $query->execute();
            $categories = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $categories;
    }

    /*
     * список категорий для администратора
     */
    function getAllCategories() {
        try {
            $sqlGetCategoriesList = 'SELECT category_id, category_name FROM categories';
            $query = $this->db->prepare($sqlGetCategoriesList);
            $query->execute();
            $categoriesList = $query->fetchAll();

            $sqlGetQuestions = 'SELECT * FROM questions';
            $query = $this->db->prepare($sqlGetQuestions);
            $query->execute();
            $questionsList = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        $ultimateCategoriesList = [];
        foreach ($categoriesList as $category) {
            $overall = 0;
            $published = 0;
            $suspended = 0;
            foreach ($questionsList as $question) {
                if ($category['category_id'] == $question['category_id']) {
                    $overall += 1;
                    if ($question['status'] == 'published') {
                        $published += 1;
                    }
                    else {
                        $suspended += 1;
                    }
                }
            }
            $category['overall'] = $overall;
            $category['published'] = $published;
            $category['suspended'] = $suspended;
            array_push($ultimateCategoriesList, $category);
        }

        return $ultimateCategoriesList;
    }

    /*
     * создание новой категории
     */
    function addCategory($newCategory) {
        $unique = true;

        try {
            $sqlGetCategoriesList = 'SELECT category_id, category_name FROM categories';
            $query = $this->db->prepare($sqlGetCategoriesList);
            $query->execute();
            $categoriesList = $query->fetchAll();

            foreach ($categoriesList as $category) {
                if ($category['category_name'] == $newCategory) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sqlAddCategory = 'INSERT INTO categories (category_id, category_name) VALUES (?, ?)';
                $this->db->prepare($sqlAddCategory)->execute([NULL, $newCategory]);
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * удаление категории
     */
    function deleteCategory($categoryId) {
        try {
            $tables = ['categories', 'questions'];
            foreach ($tables as $table) {
                $sqlDeleteCategory = "DELETE FROM $table WHERE category_id = ?";
                $this->db->prepare($sqlDeleteCategory)->execute([$categoryId]);
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * вопросы из определенной категории
     */
    function getQuestionsByCategory($categoryId) {
        try {
            $sqlGetQuestions = 'SELECT question_id, category_id, author_name, author_email, question, status, date_added FROM questions WHERE category_id = ?';
            $query = $this->db->prepare($sqlGetQuestions);
            $query->execute([$categoryId]);
            $questionsList = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $questionsList;
    }
}