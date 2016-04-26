<?php

use Phinx\Seed\AbstractSeed;
use Faker\Factory AS FakerFactory;
use Cocur\Slugify\Slugify;

/**
 * No need for granular seeding mechanism for such a simple application - lets do it all at once
 */
class CoreSchema extends AbstractSeed {

    private static $TAGS = ["defensive-programming", "programming-paradigms", "correctness", "universe", "activestate", "hci", "windows-live", "k2", "readprocessmemory", "control-structure", "adventure", "winmerge", "code-folding", "xfa", "intraweb", "journal", "platform-independent", "backup-strategies", "detail", "negation", "ancestor", "qvariant", "information-theory", "pluralize", "scalable", "hierarchyid", "executequery", "pisa", "subproject", "vb.net-to-c#", "printstream", "usertype", "background-foreground", "virtual-attribute", "splitcontainer", "batch-updates", "setattr", "domready", "uint", "rtsp-client", "captions", "sketchflow", "web-project", "gwtquery", ".app", "mersenne-twister", "strtol", "checkmark", "activity-stack", "double-checked-locking", "launchpad", "git-status", "bisection", "openvms", "libssh", "unicode-escapes", "video-conversion", "infovis", "application-bar", "inputview", "nl2br", "location-provider", "tipsy", "reentrantlock", "apache-commons-config", "mongodump", "jcalendar", "get-request", "nodeunit", "nsworkspace", "nsstringencoding", "munin", "auto-renewing", "tiny-tds", "nsrangeexception", "motorola-emdk", "usart", "derbyjs", "simperium", "sna", "solarium", "ngui", "right-join", "spring-data-redis", "quickfixj", "kendo-window", "atmelstudio", "setcontentview", "winrt-xaml-toolkit", "autoprefixer", "dynamics-ax-2012-r3", "ssas-tabular", "gridlayoutmanager", "wix3.9", "java-security", "fetch-api", "ubuntu-15.10", "recurrent-neural-network"];
    private static $USER_COUNT = 20;
    private static $QUESTION_COUNT = 1000;

    public function run() {

        /**
         * @var \Faker\Generator
         */
        $faker = FakerFactory::create();
        /**
         * @var \PDO
         */
        $pdo = $this->getAdapter()->getConnection();

        ################
        # Insert users #
        ################

        $stmt = $pdo->prepare("INSERT INTO core.users (email, password) VALUES (?, ?) RETURNING user_id;");
        $userIds = [];
        for ($i = 0; $i < self::$USER_COUNT; $i++) {
            $stmt->execute([$faker->userName . "@localhost", password_hash("password", PASSWORD_DEFAULT)]);
            $userIds[] = $stmt->fetch()["user_id"];
        }

        ###############
        # Insert tags #
        ###############

        $stmt = $pdo->prepare("INSERT INTO core.tags (name) VALUES (?) ON CONFLICT(name) DO NOTHING;");
        $query = $pdo->prepare("SELECT tag_id FROM core.tags WHERE tags.name = ?");
        $tagIds = [];
        foreach (self::$TAGS AS $tag) {
            $stmt->execute([$tag]);
            $query->execute([$tag]);
            $tagIds[] = $query->fetch()["tag_id"];
        }

        ####################
        # Insert questions #
        ####################

        $tcount = count($tagIds) - 1;
        $stmt = $pdo->prepare("INSERT INTO core.questions (user_id, title, content, slug) VALUES (?, ?, ?, ?) RETURNING question_id;");
        $attachTag = $pdo->prepare("INSERT INTO core.question_tags (tag_id, question_id) VALUES (?, ?);");
        for ($i = 0; $i < self::$QUESTION_COUNT; $i++) {
            $tags = $faker->randomElements($tagIds, $faker->numberBetween(1, 6));
            $userId = $faker->randomElement($userIds);
            $title = $faker->sentence(6);
            $content = $faker->paragraphs(10, true);
            $slug = $this->createSlug($title);
            $stmt->execute([$userId, $title, $content, $slug]);
            $questionId = $stmt->fetch()["question_id"];
            foreach ($tags AS $tag) {
                $attachTag->execute([$tag, $questionId]);
            }
        }
    }

    private function createSlug($title) {
        $slug = Slugify::create()->slugify($title);
        if (strlen($slug) > 64) {
            $slug = substr($slug, 0, 64);
            $slug = trim($slug, "-");
        }
        return $slug;
    }

}
