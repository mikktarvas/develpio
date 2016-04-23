<?php

use Pimple\Container;
use app\dao\UsersDao;

$container = new Container();

############
# Gerenics #
############

$container["pdo"] = function() {
    return getConnection();
};

#############
# DAO layer #
#############

$container["usersDao"] = function($container) {
    $dao = new UsersDao();
    $dao->setPdo($container["pdo"]);
    return $dao;
};

return $container;
