<?php

namespace App\Controller;

use App\Model\Entity\Notebook;
use App\Model\Table\NotebooksTable;

/**
 * @property NotebooksTable $Notebooks
 */
class Api2NotebooksController extends Api2Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Notebooks = NotebooksTable::load();
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
        /** @var Notebook $notebook */
        $notebook = $this->Notebooks->newEmptyEntity();
        $notebook = $this->Notebooks->patchEntity($notebook, $data);

        $notebook->user_id = $this->request->getParam('userID');

        $saved = $this->Notebooks->saveOrFail($notebook);

        $this->return = $this->Notebooks->get($saved->id);
    }

    protected function getList()
    {
        $userId = $this->request->getParam('userID');
        $notebooks = $this->Notebooks->findNotebooksByUser($userId)->toArray();

        $this->return = $notebooks;
    }
}
