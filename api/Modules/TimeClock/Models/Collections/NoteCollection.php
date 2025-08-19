<?php
namespace App\Modules\TimeClock\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\TimeClock\Models\Note;

class NoteCollection extends AbstractCollection
{

    public function mapItemToArray($item): array
    {
        return [
            'note_id' => $item->getNoteId(),
            'note' => $item->getNote(),
            'note_at' => $item->getNotedAt(),
        ];
    }

}
