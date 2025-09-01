<?php
namespace App\Modules\TimeClock\Controllers;

use App\Modules\TimeClock\Models\Note;
use App\Modules\TimeClock\Requests\AddNoteRequest;
use App\Modules\TimeClock\UseCases\AddNoteUseCase;

class AddNoteController {

    private AddNoteUseCase $useCase;
    public function __construct(AddNoteUseCase $useCase){
        $this->useCase = $useCase;
    }

    public function handleAddNote(AddNoteRequest $Request) {
        $note = new Note();
        $note->setUserId($Request->getUserId());
        $note->setClockId($Request->getClockId());
        $note->setNote($Request->getNote());
        $this->useCase->execute($note);
    }
}
