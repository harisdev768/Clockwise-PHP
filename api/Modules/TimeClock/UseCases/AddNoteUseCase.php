<?php
namespace App\Modules\TimeClock\UseCases;

use App\Modules\TimeClock\Exceptions\NotesException;
use App\Modules\TimeClock\Models\Note;
use App\Modules\TimeClock\Response\AddNoteResponse;
use App\Modules\TimeClock\Services\AddNoteService;

class AddNoteUseCase {
    private AddNoteService $service;
    public function __construct(AddNoteService $service) {
        $this->service = $service;
    }

    public function execute(Note $note): AddNoteResponse {

        $clockedIn = $this->service->isClockedIn($note);

        if(!$clockedIn->isClockedIn()){
            throw NotesException::notClockedIn();
        }

        $addedNote = $this->service->addNote($clockedIn);

        return AddNoteResponse::success($addedNote);
    }
}
