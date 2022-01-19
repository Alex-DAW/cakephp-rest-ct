<?php

namespace App\Model\Table;


use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

class NotebooksTable extends AppTable
{
    public static function load(): NotebooksTable
    {
        /** @var NotebooksTable $table */
        $table = TableRegistry::getTableLocator()->get('Notebooks');
        return $table;
    }

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users')->setForeignKey('user_id');
    }

    public function findNotebooksByUser($userId) : Query
    {
        return $this->find()
            ->where(['user_id' => $userId]);
    }
}
