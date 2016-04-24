<?php

namespace app\process;

use app\dao\TagsDao;
use app\process\InsertNewTag;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class AttachTag {

    /**
     * @var TagsDao
     */
    private $tagsDao;

    /**
     *
     * @var InsertNewTag
     */
    private $insertNewTag;

    public function toQuestion($questionId, $tagName) {
        $tagId = $this->insertNewTag->insertIfMissing($tagName);
        $this->tagsDao->attachTagToQuestion($tagId, $questionId);
        return $tagId;
    }

    function getTagsDao() {
        return $this->tagsDao;
    }

    function getInsertNewTag() {
        return $this->insertNewTag;
    }

    function setTagsDao(TagsDao $tagsDao) {
        $this->tagsDao = $tagsDao;
    }

    function setInsertNewTag(InsertNewTag $insertNewTag) {
        $this->insertNewTag = $insertNewTag;
    }

}
