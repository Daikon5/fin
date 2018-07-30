<?php

class QuestionActions {
    function __construct($db) {
        $this->db = $db;
    }

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

    function getSortedQuestions($categoryId) {
        try {
            $sqlSortQuestions = 'SELECT * FROM questions WHERE category_id = ?';
            $query = $this->db->prepare($sqlSortQuestions);
            $query->execute([$categoryId]);
            $sortedQuestions = $query->fetchAll();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $sortedQuestions;
    }

    function deleteQuestion($question_id) {
        try {
            $sqlDeleteQuestion = 'DELETE * FROM questions WHERE question_id = ?';
            $this->db->prepare($sqlDeleteQuestion)->execute([$question_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function changeCategory($question_id, $category_id) {
        try {
            $sqlChangeCategory = 'UPDATE questions SET category_id = ? WHERE question_id = ?';
            $this->db->prepare($sqlChangeCategory)->execute([$category_id, $question_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function changeStatus($newStatus, $question_id) {
        try {
            $sqlCangeStatus = "UPDATE questions SET status = ? WHERE question_id = ?";
            $this->db->prepare($sqlCangeStatus)->execute([$newStatus, $question_id]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

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