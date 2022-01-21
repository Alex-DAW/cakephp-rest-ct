<?php

namespace App\Model\Table;

use App\Model\Entity\Note;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

class NotesTable extends AppTable
{
    public static function load(): NotesTable
    {
        /** @var NotesTable $note */
        $note = TableRegistry::getTableLocator()->get('Notes');
        return $note;
    }

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Notebooks')->setForeignKey('notebook_id');
    }

    public function findNotesByNotebook($notebookId) : Query
    {
        return $this->find()
            ->where(['notebook_id' => $notebookId]);
    }

    public function findNoteById($id) : Query
    {
        $note = $this->find()
            ->where(['id' => $id]);

        return $note;
    }
}
