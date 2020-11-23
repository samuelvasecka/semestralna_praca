<?php
declare(strict_types=1);
require_once "Database.php";
require_once "Task.php";
require_once "CookieManager.php";

class FilterChecklist
{
    private Database $database;
    private CookieManager $cookieManager;

    public function __construct()
    {
        $this->database = new Database();
        $this->cookieManager = new CookieManager();
    }

    /**
     * @return Task[]
     */
    public function searchBy(string $text, int $id): array
    {
        $conn = $this->database->getConnection();
        if (isset($conn)) {
            $checklists = [];
            $sql = "SELECT * FROM checklists WHERE title LIKE '%".$text."%' AND wedding_id=".$id;
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                $checklists[] = new Task((int)$row["id"], $row["title"], $row["note"], (int)$row["done"], $row["deadline"], (int)$row["important"], (int)$row["wedding_id"],);
            }
            return $checklists;
        } else {
            return [];
        }
    }

    /**
     * @return Task[]
     */
    public function multipleSort(int $done, int $important, int $asc, int $id) {
        $sql = "SELECT checklists.id, checklists.title, checklists.note, checklists.done, checklists.deadline, checklists.important, checklists.wedding_id FROM checklists LEFT JOIN users ON users.id = ".$this->cookieManager->getUserId()." WHERE wedding_id=".$id;
        if ($done == 0 || $done == 1) {
            $sql .= " AND done=".$done;
        }
        if ($important == 0 || $important == 1) {
            $sql .= " AND important=".$important;
        }
        if ($asc == 0) {
            $sql .= " ORDER BY deadline DESC";
        } else if ($asc == 1) {
            $sql .= " ORDER BY deadline ASC";
        }
        $conn = $this->database->getConnection();
        if (isset($conn)) {
            $checklists = [];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $checklists[] = new Task((int)$row["id"], $row["title"], $row["note"], (int)$row["done"], $row["deadline"], (int)$row["important"], (int)$row["wedding_id"],);
                }
            }
            return $checklists;
        } else {
            return [];
        }
    }
}