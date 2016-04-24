<?php

namespace app\process;

use app\dao\QuestionsDao;
use app\util\Result;
use app\domain\Question;
use Cocur\Slugify\Slugify;
use app\process\AttachTag;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class InsertNewQuestion {

    /**
     * @var QuestionsDao
     */
    private $questionsDao;

    /**
     * @var AttachTag
     */
    private $attachTag;

    public function insert($title, $content, $userId, array $tags) {

        $question = $this->createQuestion($title, $content, $userId);
        $questionId = $this->questionsDao->insertQuestion($question);
        $this->attachTags($questionId, $tags);

        return Result::success($questionId);
    }

    private function createSlug($title) {
        $slug = Slugify::create()->slugify($title);
        if (strlen($slug) > 64) {
            $slug = substr($slug, 0, 64);
            $slug = trim($slug, "-");
        }
        return $slug;
    }

    private function createQuestion($title, $content, $userId) {
        $question = new Question();
        $question->setContent($content);
        $question->setTitle($title);
        $question->setUserId($userId);
        $question->setSlug($this->createSlug($title));
        return $question;
    }

    private function attachTags($questionId, array $tags) {
        foreach ($tags AS $tagName) {
            $this->attachTag->toQuestion($questionId, $tagName);
        }
    }

    function getQuestionsDao() {
        return $this->questionsDao;
    }

    function setQuestionsDao(QuestionsDao $questionsDao) {
        $this->questionsDao = $questionsDao;
    }

    function getAttachTag() {
        return $this->attachTag;
    }

    function setAttachTag(AttachTag $attachTag) {
        $this->attachTag = $attachTag;
    }

}
