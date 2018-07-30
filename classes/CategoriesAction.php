<?php

class CategoriesAction {

    function __construct($db) {
        $this->db = $db;
    }

    function getAllCategories() {
        try {
            $sqlGetCategoriesList = 'SELECT * FROM categories';
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

    function addCategory($newCategory) {
        $unique = true;

        try {
            $sqlGetCategoriesList = 'SELECT * FROM categories';
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

    function getQuestionsByCategory($categoryId) {
        try {
            $sqlGetQuestions = 'SELECT * FROM questions WHERE category_id = ?';
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