<?php
declare(strict_types=1);
require_once "Database.php";

class Task
{
    private int $id;
    private string $title;
    private string $note;
    private int $done;
    private string $deadline;
    private int $important;
    private int $weddingId;

    /**
     * Task constructor.
     * @param int $id
     * @param string $title
     * @param string $note
     * @param int $done
     * @param string $deadline
     * @param int $important
     * @param int $weddingId
     */
    public function __construct(int $id, string $title, string $note, int $done, string $deadline, int $important, int $weddingId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->note = $note;
        $this->done = $done;
        $this->deadline = $deadline;
        $this->important = $important;
        $this->weddingId = $weddingId;
    }

    /**
     * @param int $id
     * @return Task[]
     */
    public static function getMyTasks(int $id): array
    {
        $database = new Database();
        $conn = $database->getConnection();
        $cookieManager = new CookieManager();
        if (isset($conn)) {
            $sql = "SELECT * FROM checklists WHERE wedding_id=". $id;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $checklists = [];
                while ($row = $result->fetch_assoc()) {
                    $checklists[] = new Task((int)$row["id"], $row["title"], $row["note"], (int)$row["done"], $row["deadline"], (int)$row["important"], (int)$row["wedding_id"]);
                }
                return $checklists;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public static function getTask(int $id): Task
    {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT * FROM checklists WHERE id=". $id;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return new Task((int)$row["id"], $row["title"], $row["note"], (int)$row["done"], $row["deadline"], (int)$row["important"], (int)$row["wedding_id"]);
                }
            }
        }
    }

    public function insertTask() : bool {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "INSERT INTO checklists(title, note, done, deadline, important, wedding_id) VALUES('" . $this->title . "', '" . $this->note . "', " . $this->done . ", '" . $this->deadline . "', " . $this->important . ", " . $this->weddingId . ")";
            return $conn->query($sql);
        }
    }

    public function getTaskHTML(): string {
        $icon = "fa fa-check-square";
        if ($this->done == 0) {
            $icon = "fa fa-square-o";
        }

        $important = '<button class="button_circle">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                    </button>';
        if ($this->important == 0) {
            $important = "";
        }

        $date = strtotime($this->deadline);

        return
        '<div class="item" id="task_'.$this->id.'">
        
                <div class="task">
                    <button class="button_circle" id="done_'.$this->id.'" value="'.$this->done.'" onclick="setDone(this)">
                        <i class="'.$icon.'" aria-hidden="true"></i>
                    </button>
                    '.$important.'
                    <button class="button_circle" id="delete_'.$this->id.'" onclick="deleteTask(this)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <div class="date">
                        <button class="change_button" id="deadline_'.$this->id.'" onclick="changeToDate(this)">
                            '.date( "d.m.Y", $date).'
                        </button>
                    </div>
                    <div class="checklist_title">
                        <button class="change_button" id="title_'.$this->id.'" onclick="changeToText(this)">
                            '.$this->title.'
                        </button>
                    </div>
                    <div class="checklist_note">
                        <button class="change_button" id="note_'.$this->id.'" onclick="changeToText(this)">
                            '.$this->note.'
                        </button>
                    </div>
                    <div class="hide" id="save_'.$this->id.'">
                        <button class="button" onclick="save(this)">
                            Uložiť
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
           
    </div>';
    }
}