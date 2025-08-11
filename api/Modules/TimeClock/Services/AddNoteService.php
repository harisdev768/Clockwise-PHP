<?php
namespace App\Modules\TimeClock\Services;

use App\Modules\TimeClock\Models\Mappers\NoteMapper;
use App\Modules\TimeClock\Models\Note;

class AddNoteService {
    private NoteMapper $mapper;

    public function __construct(NoteMapper $mapper) {
        $this->mapper = $mapper;
    }

    public function addNote(Note $note): Note {
        $note->setNotedAt((new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        return $this->mapper->addNote($note);
    }

    public function isClockedIn(Note $note): Note {
        return $this->mapper->getLastUnclosedEntry($note);
    }
}
