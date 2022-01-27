<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

class ReactionsTable extends AppTable
{
    public static function load(): ReactionsTable
    {
        /** @var ReactionsTable $reactions */
        $reactions = TableRegistry::getTableLocator()->get('Reactions');
        return $reactions;
    }

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Notes')->setForeignKey('note_id');
    }

    public function findReactionsByNoteId($noteId)  : Query
    {
        return $this->find()
            ->where(['note_id' => $noteId]);
    }

    public function findReactionById($id) : Query
    {
        $reaction = $this->find()
            ->where(['id' => $id]);

        return $reaction;
    }

}
