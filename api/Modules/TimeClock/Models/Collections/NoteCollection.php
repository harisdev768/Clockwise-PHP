<?php
namespace App\Modules\TimeClock\Models\Collections;

use App\Modules\TimeClock\Models\Note;

class NoteCollection{
    private array $notes = [];

    public function add(Note $note): void
    {
        $this->notes[] = $note;
    }

    public function toArray(): array
    {
        return array_map(function (Note $note) {
            return [
                'note_id' => $note->getNoteId(),
                'note' => $note->getNote(),
                'note_at' => $note->getNotedAt(),
            ];
        }, $this->notes);
    }

    public function all(): array
    {
        return $this->notes;
    }
}
