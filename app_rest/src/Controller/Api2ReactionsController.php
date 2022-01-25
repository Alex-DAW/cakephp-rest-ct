<?php

namespace App\Controller;

use App\Model\Table\ReactionsTable;

/**
 * @property ReactionsTable $Reactions
 */
class Api2ReactionsController extends Api2Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Reactions = ReactionsTable::load();
    }

    public function isPublicController(): bool
    {
        return true;
    }

    protected function getMandatoryParams(): array
    {
        return [];
    }

    protected function addNew($data)
    {

    }

    protected function getList()
    {

    }

    protected function getData($id)
    {

    }

    protected function edit($id, $data)
    {

    }

    public function delete($id)
    {

    }

    private function _checkEmojiAccess(): void
    {

    }
}
