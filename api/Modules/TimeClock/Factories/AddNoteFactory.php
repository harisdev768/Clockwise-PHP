<?php
namespace App\Modules\TimeClock\Factories;

use App\Config\Container;
use App\Modules\TimeClock\Controllers\AddNoteController;
use App\Modules\TimeClock\Requests\AddNoteRequest;

class AddNoteFactory{
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function handleAddNotes(array $data){
        $controller = $this->container->get(AddNoteController::class);
        $controller->handleAddNote(new AddNoteRequest($data));
    }
}