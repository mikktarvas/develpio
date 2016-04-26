<?php

use Pimple\Container;
use app\dao\UsersDao;
use app\dao\QuestionsDao;
use app\dao\TagsDao;
use app\dao\VotesDao;
use app\exec\RegistrationExecution;
use app\exec\AskQuestionExecution;
use app\process\InsertNewUser;
use app\exec\LoginExecution;
use app\process\VerifyPassword;
use app\process\InsertNewQuestion;
use app\process\AttachTag;
use app\process\InsertNewTag;
use app\exec\FindQuestionExecution;
use app\exec\ListQuestionsExecution;
use app\exec\ListTagsExecution;
use app\exec\AnswerQuestionExecution;
use app\dao\AnswersDao;
use app\process\InsertAnswer;

$container = new Container();

############
# Gerenics #
############

$container["pdo"] = function() {
    return getConnection();
};

$container["session"] = function() {
    return getSession();
};

#############
# DAO layer #
#############

$container["usersDao"] = function($container) {
    $dao = new UsersDao();
    $dao->setPdo($container["pdo"]);
    return $dao;
};

$container["questionsDao"] = function($container) {
    $dao = new QuestionsDao();
    $dao->setPdo($container["pdo"]);
    return $dao;
};

$container["tagsDao"] = function($container) {
    $dao = new TagsDao();
    $dao->setPdo($container["pdo"]);
    return $dao;
};

$container["votesDao"] = function($container) {
    $dao = new VotesDao();
    $dao->setPdo($container["pdo"]);
    return $dao;
};

$container["answersDao"] = function($container) {
    $dao = new AnswersDao();
    $dao->setPdo($container["pdo"]);
    return $dao;
};

##############
# Exec layer #
##############

$container["registrationExecution"] = function($container) {
    $execution = new RegistrationExecution();
    $execution->setInsertNewUser($container["insertNewUser"]);
    return $execution;
};

$container["loginExecution"] = function($container) {
    $execution = new LoginExecution();
    $execution->setVerifyPassword($container["verifyPassword"]);
    $execution->setUsersDao($container["usersDao"]);
    return $execution;
};

$container["askQuestionExecution"] = function($container) {
    $execution = new AskQuestionExecution();
    $execution->setInsertNewQuestion($container["insertNewQuestion"]);
    $execution->setQuestionsDao($container["questionsDao"]);
    return $execution;
};

$container["findQuestionExecution"] = function($container) {
    $execution = new FindQuestionExecution();
    $execution->setQuestionsDao($container["questionsDao"]);
    $execution->setUsersDao($container["usersDao"]);
    $execution->setTagsDao($container["tagsDao"]);
    $execution->setAnswersDao($container["answersDao"]);
    return $execution;
};

$container["listQuestionsExecution"] = function($container) {
    $execution = new ListQuestionsExecution();
    $execution->setQuestionsDao($container["questionsDao"]);
    $execution->setTagsDao($container["tagsDao"]);
    return $execution;
};

$container["listTagsExecution"] = function($container) {
    $execution = new ListTagsExecution();
    $execution->setTagsDao($container["tagsDao"]);
    return $execution;
};

$container["answerQuestionExecution"] = function($container) {
    $execution = new AnswerQuestionExecution();
    $execution->setInsertAnswer($container["insertAnswer"]);
    return $execution;
};

#################
# Process layer #
#################

$container["insertNewTag"] = function($container) {
    $insertNewTag = new InsertNewTag();
    $insertNewTag->setTagsDao($container["tagsDao"]);
    return $insertNewTag;
};

$container["insertNewUser"] = function($container) {
    $insertNewUser = new InsertNewUser();
    $insertNewUser->setUsersDao($container["usersDao"]);
    return $insertNewUser;
};

$container["verifyPassword"] = function($container) {
    $verifyPassword = new VerifyPassword();
    $verifyPassword->setUsersDao($container["usersDao"]);
    return $verifyPassword;
};

$container["insertNewQuestion"] = function($container) {
    $insertNewQuestion = new InsertNewQuestion();
    $insertNewQuestion->setQuestionsDao($container["questionsDao"]);
    $insertNewQuestion->setAttachTag($container["attachTag"]);
    return $insertNewQuestion;
};

$container["attachTag"] = function($container) {
    $attachTag = new AttachTag();
    $attachTag->setInsertNewTag($container["insertNewTag"]);
    $attachTag->setTagsDao($container["tagsDao"]);
    return $attachTag;
};

$container["insertAnswer"] = function($container) {
    $insertAnswer = new InsertAnswer();
    $insertAnswer->setAnswersDao($container["answersDao"]);
    $insertAnswer->setQuestionsDao($container["questionsDao"]);
    $insertAnswer->setUsersDao($container["usersDao"]);
    return $insertAnswer;
};

####################
# Return container #
####################

return $container;
