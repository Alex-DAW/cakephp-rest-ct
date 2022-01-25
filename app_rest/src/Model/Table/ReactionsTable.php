<?php

namespace App\Model\Table;

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
        $this->belongsTo('Notebooks')->setForeignKey('notebook_id');
    }

}
