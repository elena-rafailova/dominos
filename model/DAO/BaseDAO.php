<?php

namespace model\DAO;
use model\DAO\DBManager;


class BaseDAO
{
    public function getPDO() {
        return DBManager::getInstance()->getConnection();
    }
}