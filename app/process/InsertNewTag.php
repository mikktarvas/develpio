<?php

namespace app\process;

use app\dao\TagsDao;
use Assert\Assertion;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class InsertNewTag {

    /**
     * @var TagsDao
     */
    private $tagsDao;

    public function insertIfMissing($name) {
        $this->tagsDao->insertIfMissing($name);
        $id = $this->tagsDao->findTagIdByName($name);
        Assertion::notNull($id);
        return $id;
    }

    function getTagsDao() {
        return $this->tagsDao;
    }

    function setTagsDao(TagsDao $tagsDao) {
        $this->tagsDao = $tagsDao;
    }

}
