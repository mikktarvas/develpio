<?php

use Pimple\Container;
use app\dao\UsersDao;
use app\exec\RegistrationExecution;
use app\process\InsertNewUser;

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

##############
# Exec layer #
##############

$container["registrationExecution"] = function($container) {
    $execution = new RegistrationExecution();
    $execution->setInsertNewUser($container["insertNewUser"]);
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

return $container;
