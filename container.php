<?php

use Pimple\Container;
use app\dao\UsersDao;
use app\dao\QuestionsDao;
use app\dao\TagsDao;
use app\dao\VotesDao;
use app\exec\RegistrationExecution;
use app\process\InsertNewUser;
use app\exec\LoginExecution;
use app\process\VerifyPassword;

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

#################
# Process layer #
#################

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

####################
# Return container #
####################

return $container;
