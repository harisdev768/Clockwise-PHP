<?php
namespace App\Modules\TimeClock\Models\Mappers;

use App\Config\DB;
use App\Modules\TimeClock\Models\Note;

class NoteMapper {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = DB::getConnection();
    }

    public function addNote(Note $note): Note {
        $stmt = $this->pdo->prepare(
            "INSERT INTO note_entries (user_id, clock_id, note, added_at) 
             VALUES (:user_id, :clock_id, :note, :added_at)"
        );

        $stmt->bindValue(':user_id', $note->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $note->getClockId(), \PDO::PARAM_INT);
        $stmt->bindValue(':note', $note->getNote(), \PDO::PARAM_STR);
        $stmt->bindValue(':added_at', $note->getNotedAt(), \PDO::PARAM_STR);

        $stmt->execute();

        $note->setNoteId($this->pdo->lastInsertId());
        return $note;
    }

    public function getLastUnclosedEntry(Note $note): ?Note {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM clock_entries 
             WHERE id = :clock_id AND clock_out IS NULL 
             ORDER BY clock_in DESC LIMIT 1"
        );

        $stmt->bindValue(':clock_id', $note->getClockId(), \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            $note->setClockedIn(true);
        }

        return $note;
    }
}
