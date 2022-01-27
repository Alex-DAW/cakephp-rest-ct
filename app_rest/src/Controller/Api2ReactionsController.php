<?php

namespace App\Controller;

use App\Model\Entity\Reaction;
use App\Model\Table\NotebooksTable;
use App\Model\Table\NotesTable;
use App\Model\Table\ReactionsTable;
use Cake\Http\Exception\ForbiddenException;

/**
 * @property ReactionsTable $Reactions
 * @property NotesTable $Notes
 * @property NotebooksTable $Notebooks
 */
class Api2ReactionsController extends Api2Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Notebooks = NotebooksTable::load();
        $this->Notes = NotesTable::load();
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
        $this->_checkReactionAccess();
        $reaction = $this->Reactions->newEmptyEntity();
        /** @var Reaction $reaction */
        $reaction = $this->Reactions->patchEntity($reaction, $data);

        $reaction->note_id = $this->request->getParam('noteID');

        $saved = $this->Reactions->saveOrFail($reaction);

        $this->return = $this->Reactions->get($saved->id);
    }

    protected function getList()
    {
        $this->_checkReactionAccess();
        $noteId = $this->request->getParam('noteID');
        $reactions = $this->Reactions->findReactionsByNoteId($noteId)->toArray();
        $this->return = $reactions;
    }

    protected function getData($id)
    {
        $this->_checkReactionAccess();
        $reactions = $this->Reactions->findReactionById($id)->firstOrFail();
        $this->return = $reactions;
    }

    public function delete($id)
    {
        $this->_checkReactionAccess();
        $this->Reactions->get($id);
        $this->Reactions->softDelete($id);
        $this->return = false;
    }

    private function _checkReactionAccess(): void
    {
        $userId = $this->request->getParam('userID');
        $notebookId = $this->request->getParam('notebookID');
        $noteId = $this->request->getParam('noteID');

        $notebook = $this->Notebooks->findNotebookByIdAndUser($notebookId, $userId)
        ->first();

        $note = $this->Notes->findNoteById($noteId)
            ->first();

        if (!$note || !$notebook) {
            throw new ForbiddenException('UserID, notebookID or noteID does not match');
        }
    }
}
