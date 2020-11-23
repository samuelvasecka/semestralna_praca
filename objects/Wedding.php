<?php
declare(strict_types=1);
require_once "Database.php";
require_once "CookieManager.php";

class Wedding
{
    private int $id;
    private string $weddingDate;
    private string $place;
    private string $couple;
    private float $budget;

    /**
     * Wedding constructor.
     * @param int $id
     * @param string $weddingDate
     * @param string $place
     * @param string $couple
     * @param float $budget
     */
    public function __construct(int $id, string $weddingDate, string $place, string $couple, float $budget)
    {
        $this->id = $id;
        $this->weddingDate = $weddingDate;
        $this->place = $place;
        $this->couple = $couple;
        $this->budget = $budget;
    }

    /**
     * @return Wedding[]
     */
    public static function getMyWeddings(): array
    {
        $database = new Database();
        $conn = $database->getConnection();
        $cookieManager = new CookieManager();
        if (isset($conn)) {
            $sql = "SELECT weddings.id, weddings.wedding_date, weddings.place, weddings.couple, weddings.budget FROM administrators LEFT JOIN weddings ON weddings.id = administrators.wedding_id WHERE administrators.user_id=" . $cookieManager->getUserId();
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $weddings = [];
                while ($row = $result->fetch_assoc()) {
                    $weddings[] = new Wedding((int)$row["id"], $row["wedding_date"], $row["place"], $row["couple"], (float)$row["budget"]);
                }
                return $weddings;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public static function getWedding(int $id) : Wedding {
        $database = new Database();
        $conn = $database->getConnection();
        $cookieManager = new CookieManager();
        if (isset($conn)) {
            $sql = "SELECT weddings.id, weddings.wedding_date, weddings.place, weddings.couple, weddings.budget FROM administrators LEFT JOIN weddings ON weddings.id = administrators.wedding_id WHERE administrators.user_id=" . $cookieManager->getUserId()." AND weddings.id=".$id;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return new Wedding((int)$row["id"], $row["wedding_date"], $row["place"], $row["couple"], (float)$row["budget"]);
                }
            }
        }
    }

    public function getSmallWeddingHTML() : string {
        $date = strtotime($this->weddingDate);

        return '<div class="item">
        <form method="post">
        <button class="wedding" type="submit" name="choose_wedding" value="'.$this->id.'">
            <div class="decoration_left">
                <img src="images/corner_flower_top.png" alt="decoration" height="90">
            </div>
            <div class="title">
                <div class="couple">
                    '.$this->couple.'
                </div>
                <div>
                    '.date( "d.m.Y", $date).'
                </div>
            </div>
            <div class="decoration_right">
                <img src="images/corner_flower_bottom.png" alt="decoration" height="90">
            </div>
        </button>
</form>
    </div>';
    }

    public function getBigWeddingHTML() : string {
        $date = strtotime($this->weddingDate);

        return
        '<div class="item">
        <div class="overview">
            <div class="decoration_left">
                <img src="images/corner_flower_top.png" alt="decoration" height="90">
            </div>
            <div class="title">
                <div class="couple">
                    '.$this->couple.'
                </div>
                <div>
                    '.date( "d.m.Y", $date).'
                </div>
            </div>
            <div class="decoration_right">
                <img src="images/corner_flower_bottom_left.png" alt="decoration" height="90">
            </div>
            <div class="section">
                <div class="box">
                    <div class="box_title">
                        '.$this->couple.'
                    </div>
                    <div class="detail">
                        <i class="fa fa-home" aria-hidden="true"></i>
                       '.$this->place.'
                    </div>
                    <div class="detail">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        '.$this->couple.'
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Checklist
                    </div>
                    <div class="detail">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        Hotové - 12
                    </div>
                    <div class="detail">
                        <i class="fa fa-square-o" aria-hidden="true"></i>
                        V pláne - 3
                    </div>
                    <form action="checklist.php">
                        <button class="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
                <div class="box">
                    <div class="box_title">
                        Financie
                    </div>
                    <div class="detail">
                        <i class="fa fa-eur" aria-hidden="true"></i>
                        1550 / 3000
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Hostia
                    </div>
                    <div class="detail">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Potvrdený
                    </div>
                    <div class="detail">
                        <i class="fa fa-user-times" aria-hidden="true"></i>
                        Nepotvrdený
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Stoly
                    </div>
                    <div class="detail">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        Počet stolov - 7
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Správcovia
                    </div>
                    <div class="detail">
                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        Počet správcov 3
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>';
    }

    public function insertWedding() : bool {
        $database = new Database();
        $conn = $database->getConnection();
        $cookieManager = new CookieManager();
        if (isset($conn)) {
            $sql = "INSERT INTO weddings(wedding_date, place, couple, budget) VALUES ('".$this->weddingDate."', '".$this->place."', '".$this->couple."', '".$this->budget."')";
            $conn->begin_transaction();
            $conn->query($sql);
            $sql = "INSERT INTO administrators(user_id, wedding_id) VALUES ('" . $cookieManager->getUserId() . "', LAST_INSERT_ID())";
            $conn->query($sql);
            return $conn->commit();

        } else {
            return false;
        }
    }
}