<?php

namespace App\Controller;

use App\Model\Entity\Note;
use App\Model\Table\NotesTable;

/**
 * @property NotesTable $Notes
 */
class Api2NotesController extends Api2Controller
{

    public function initialize(): void
    {
        parent::initialize();
        $this->Notes = NotesTable::load();
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
        $note = $this->Notes->newEmptyEntity();
        /** @var Note $note */
        $note = $this->Notes->patchEntity($note, $data);

        $note->notebook_id = $this->request->getParam('notebookID');

        $saved = $this->Notes->saveOrFail($note);

        $this->return = $this->Notes->get($saved->id);
    }

     protected function getList()
     {
         $notebookId = $this->request->getParam('notebookID');
         $notes = $this->Notes->findNotesByNotebook($notebookId)->toArray();
         $this->return = $notes;
     }

     protected function getData($noteId)
     {
         $notes = $this->Notes->findNoteById($noteId)->toArray();
         $this->return = $notes;
     }

     protected function edit($notebookId, $data)
     {
         $note= $this->Notes->get($notebookId);
         $note = $this->Notes->patchEntity($note, $data);


         $saved = $this->Notes->saveOrFail($note);
         $this->return = $this->Notes->get($saved->id);
     }

    public function delete($id)
    {
        $this->Notes->get($id);
        $this->Notes->softDelete($id);
        $this->return = false;
    }
}
