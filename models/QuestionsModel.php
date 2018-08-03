<?php

class QuestionsModel {
    function __construct($db) {
        $this->db = $db;
    }

    /*
     * обработка вопроса от пользователя
     */
    function processUserQuestion($array) {
        $inputErrors = [];
        $wantedFields = ['question','email','name','category_id'];

        foreach ($wantedFields as $field) {
            if (empty($array[$field])) {
                array_push($inputErrors, $field);
            }
        }
        if (count($inputErrors) == 0) {
            try {
                $dateNow = date('Y-m-d')." ".date('H:i:s');
                $addQuestionQuery = 'INSERT INTO questions(question_id, author_name, author_email, category_id, status, question, date_added) 
                                  VALUES (?,?,?,?,?,?,?)';
                $this->db->prepare($addQuestionQuery)->execute([NULL, $array['name'], $array['email'], $array['category_id'], 'suspended', $array['question'], $dateNow]);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    /*
     * все опубликованные вопросы с ответами
     */
    function getQuestionsAll() {
        try {
            $questionsQuery = 'SELECT q.author_name, q.author_email, q.question, q.date_added, a.answer, a.author as answerer, c.category_name as category
                          FROM questions q
                          JOIN answers a ON a.question_id = q.question_id
                          JOIN categories c ON q.category_id = c.category_id
                          WHERE q.status = ?';
            $query = $this->db->prepare($questionsQuery);
            $query->execute(['published']);
            $questions = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $questions;
    }

    /*
     * опубликованные вопросы в определенной категории
     */
    function getQuestionsByCategory($category) {
        try {
            $questionsQuery = 'SELECT q.author_name, q.author_email, q.question, q.date_added, a.answer, a.author as answerer, c.category_name as category
                          FROM questions q
                          JOIN answers a ON a.question_id = q.question_id
                          JOIN categories c ON q.category_id = c.category_id
                          WHERE q.category_id = ? AND q.status = ?';
            $query = $this->db->prepare($questionsQuery);
            $query->execute([$category, 'published']);
            $questions = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $questions;
    }

    /*
     * вопросы без ответа
     */
    function getUnansweredQuestions() {
        try {
            $sqlGetSuspendedQuestions = 'SELECT q.author_name, q.question_id, q.author_email, q.question, q.date_added, c.category_name as category 
                                         FROM questions q
                                         JOIN categories c ON q.category_id = c.category_id';
            $query = $this->db->prepare($sqlGetSuspendedQuestions);
            $query->execute();
            $suspendedQuestions = $query->fetchAll();

            $sqlAllAnswers = 'SELECT * FROM answers';
            $query = $this->db->prepare($sqlAllAnswers);
            $query->execute();
            $answers = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        foreach ($suspendedQuestions as $key => $value) {
            foreach ($answers as $answer) {
                if ($answer['question_id'] == $value['question_id']) {
                    unset($suspendedQuestions[$key]);
                }
            }
        }

        return $suspendedQuestions;
    }

    /*
     * вопросы отсортированные по категории
     */
    function getSortedQuestions($categoryId) {
        try {
            $sqlSortQuestions = 'SELECT question_id, category_id, author_name, author_email, question, status, date_added FROM questions WHERE category_id = ?';
            $query = $this->db->prepare($sqlSortQuestions);
            $query->execute([$categoryId]);
            $sortedQuestions = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $sortedQuestions;
    }

    /*
     * удаление вопроса
     */
    function deleteQuestion($question_id) {
        try {
            $sqlDeleteQuestion = 'DELETE FROM questions WHERE question_id = ?';
            $this->db->prepare($sqlDeleteQuestion)->execute([$question_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * изменение категории вопроса
     */
    function changeCategory($string) {
        $result = explode(' ', $string);
        $question_id = $result[0];
        $category_id = $result[1];

        try {
            $sqlChangeCategory = 'UPDATE questions SET category_id = ? WHERE question_id = ?';
            $this->db->prepare($sqlChangeCategory)->execute([$category_id, $question_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * изменение статуса вопроса
     */
    function changeStatus($newStatus, $question_id) {
        try {
            $sqlCangeStatus = "UPDATE questions SET status = ? WHERE question_id = ?";
            $this->db->prepare($sqlCangeStatus)->execute([$newStatus, $question_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * добавление ответа на вопрос
     */
    function setAnswer($question_id, $answer, $author, $publish) {
        $dateNow = date('Y-m-d')." ".date('H:i:s');

        try {
            $sqlAddAnswer = 'INSERT INTO answers(answer_id, question_id, answer, author, date_added) VALUES (?,?,?,?,?)';
            $this->db->prepare($sqlAddAnswer)->execute([NULL, $question_id, $answer, $author, $dateNow]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        $this->changeStatus($publish, $question_id);
    }

    /*
     * получение вопроса и ответа на него для редактирования
     */
    function getQuestionToEdit($question_id) {
        try {
            $sqlGetQuestionToEdit = 'SELECT q.question_id, q.question, q.author_name, q.author_email, a.answer, a.answer_id
                                     FROM questions q
                                     JOIN answers a ON a.question_id = q.question_id
                                     WHERE q.question_id = ?';
            $query = $this->db->prepare($sqlGetQuestionToEdit);
            $query->execute([$question_id]);
            $questionToEdit = $query->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $questionToEdit;
    }

    /*
     * отправка отредактированного вопроса
     */
    function updateAnsweredQuestion($question_id, $answer_id, $author, $email, $question, $answer) {
        try {
            $sqlUpdateQuestion = 'UPDATE questions SET author_name = ?, author_email = ?, question = ? WHERE question_id = ?';
            $this->db->prepare($sqlUpdateQuestion)->execute([$author, $email, $question, $question_id]);

            $sqlUpdateAnswer = 'UPDATE answers SET answer = ? WHERE answer_id = ?';
            $this->db->prepare($sqlUpdateAnswer)->execute([$answer, $answer_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}