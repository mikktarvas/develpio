<?php

namespace app\exec;

use app\dao\TagsDao;
use app\util\Result;

/**
 * User: Mikk Tarvas
 * Date: 26/04/16
 */
class ListTagsExecution {

    /**
     *
     * @var TagsDao
     */
    private $tagsDao;

    public function execute() {
        $tags = $this->tagsDao->listTagsWithCounts();
        return Result::success($tags);
    }

    function getTagsDao() {
        return $this->tagsDao;
    }

    function setTagsDao(TagsDao $tagsDao) {
        $this->tagsDao = $tagsDao;
    }

}
