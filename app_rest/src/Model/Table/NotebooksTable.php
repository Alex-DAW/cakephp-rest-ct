<?php

namespace App\Model\Table;


use App\Lib\Consts\NotebookShapes;
use App\Lib\Validator\AppValidator;
use App\Model\Entity\Notebook;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

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
        $this->hasMany('Notes');
    }

    public function findNotebooksByUser($userId) : Query
    {
        return $this->find()
            ->where(['user_id' => $userId]);
    }

    public function findNotebookById($id) : Query
    {
        $notebook = $this->find()
            ->where(['id' => $id]);

        return $notebook;
    }

    public function validationDefault(Validator $validator): Validator
    {
        /** @var AppValidator $validator */
        $shapes = [
            NotebookShapes::TODO,
            NotebookShapes::NOTES
        ];

        return $validator
            ->inList('shape', $shapes);
    }
}
