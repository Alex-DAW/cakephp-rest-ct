<?php

namespace App\Controller;

use App\Model\Entity\Note;
use App\Model\Table\NotebooksTable;
use App\Model\Table\NotesTable;
use Cake\Http\Exception\ForbiddenException;

/**
 * @property NotesTable $Notes
 * @property NotebooksTable $Notebooks
 */
class Api2NotesController extends Api2Controller
{

    public function initialize(): void
    {
        parent::initialize();
        $this->Notebooks = NotebooksTable::load();
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
         $this->_checkNotebookAccess();
         $notebookId = $this->request->getParam('notebookID');
         $notes = $this->Notes->findNotesByNotebook($notebookId)->toArray();
         $this->return = $notes;
     }

     protected function getData($id)
     {
         /** @var Note $note */
         $this->_checkNotebookAccess();
         $note = $this->Notes->getNoteWithReactions($id);

         $this->return = $note;
     }

     protected function edit($id, $data)
     {
         $this->_checkNotebookAccess();
         $note= $this->Notes->get($id);
         $note = $this->Notes->patchEntity($note, $data);


         $saved = $this->Notes->saveOrFail($note);
         $this->return = $this->Notes->get($saved->id);
     }

    public function delete($id)
    {
        $this->_checkNotebookAccess();
        $this->Notes->get($id);
        $this->Notes->softDelete($id);
        $this->return = false;
    }
}
