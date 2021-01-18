<?php
declare(strict_types=1);
require_once "Database.php";
require_once "Cookies.php";

class Commission
{

    private int $id;
    private string $username;
    private int $countryId;
    private int $confirmed;
    private string $countryName;

    /**
     * Commission constructor.
     * @param int $id
     * @param string $username
     * @param int $countryId
     * @param int $confirmed
     * @param string $countryName
     */
    public function __construct(int $id, string $username, int $countryId, int $confirmed, string $countryName)
    {
        $this->id = $id;
        $this->username = $username;
        $this->countryId = $countryId;
        $this->confirmed = $confirmed;
        $this->countryName = $countryName;
    }

    static public function login(): int
    {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $database = new Database();
            $conn = $database->getConnection();

            if (isset($conn)) {
                $cookies = new Cookies();
                $username = $_POST["username"];
                $password = self::doEncrypt($_POST["password"]);

                $sql = "SELECT * FROM commission WHERE username='" . $username . "'  AND password = '" . $password . "' AND confirmed=1 AND role_type=0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $cookies->setCommissionId((int)$row["id"]);
                        $cookies->destroyAdminId();
                    }
                    return 1;
                } else {
                    return 3;
                }
            } else {
                return 4;
            }
            $conn->close();
        } else {
            return 2;
        }
    }

    static public function logout(): bool
    {
        $cookies = new Cookies();
        $cookies->destroyCommissionId();
        return true;
    }

    static public function register(): int
    {
        if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["country_id"])) {
            $database = new Database();
            $conn = $database->getConnection();

            if (isset($conn)) {
                $username = $_POST["username"];
                $password = self::doEncrypt($_POST["password"]);

                if (strlen($username) < 8 || strlen($password) < 8 || strlen($username) > 256 || strlen($password) > 256) {
                    return 5;
                }

                $countryId = $_POST["country_id"];

                $sql = "SELECT username FROM commission WHERE username='" . $username . "'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    return 3;
                } else {
                    $sql = "INSERT INTO commission(username, password, country_id) VALUES ('" . $username . "', '" . $password . "', '" . $countryId . "')";
                    $result = $conn->query($sql);
                    if ($result) {
                        return 1;
                    } else {
                        return 4;
                    }
                }
            } else {
                return 4;
            }
            $conn->close();
        } else {
            return 2;
        }
    }

    static public function getCommission() : Commission {
        $database = new Database();
        $cookies = new Cookies();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT commission.*, countries.name as country_name FROM commission LEFT JOIN countries ON countries.id = commission.country_id WHERE commission.id = ".$cookies->getCommissionId();
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return new Commission(
                        (int)$row["id"],
                        $row["username"],
                        (int)$row["country_id"],
                        (int)$row["confirmed"],
                        $row["country_name"]
                    );
                }
            } else {
                return new Commission(-1,"", -1, -1, "");
            }
        } else {
            return new Commission(-1,"", -1, -1, "");
        }
    }

    public function getHistory() : array {
        $database = new Database();
        $cookies = new Cookies();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT records.*, history.created, commission.username, candidates.name FROM history LEFT JOIN records ON history.id = records.history_id LEFT JOIN commission ON history.commission_id = commission.id LEFT JOIN candidates ON records.candidate_id = candidates.id WHERE commission.country_id=".$this->countryId." ORDER BY history.created DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $history = [];
                $id = -999;
                $record = new stdClass();
                while ($row = $result->fetch_assoc()) {
                    if ($id != (int)$row["history_id"]) {
                        if ($id != -999) {
                            $history[] = $record;
                        }
                        $record = new stdClass();
                        $id = (int)$row["history_id"];
                        $record->created = $row["created"];
                        $record->username = $row["username"];
                        $record->candidates = [];
                    }
                    $candidate = new stdClass();
                    $candidate->name = $row["name"];
                    $candidate->votes = (int)$row["votes"];
                    $record->candidates[] = json_encode($candidate);
                }
                $history[] = $record;
                return $history;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    static private function doEncrypt($plain_text)
    {
        return hash('sha256', $plain_text);
    }

    public function addVotes(): int
    {
        if (isset($_POST["votes"])) {
            $database = new Database();
            $cookies = new Cookies();
            $conn = $database->getConnection();

            if (isset($conn)) {
                $votes = $_POST["votes"];
                $conn->begin_transaction();
                $sql = "INSERT INTO history(created, commission_id) VALUES(now(), " . $cookies->getCommissionId() . ")";
                $conn->query($sql);
                $id = $conn->insert_id;

                $i = 1;
                foreach ($votes as $value) {
                    $sql = "INSERT INTO records(history_id, candidate_id, votes) VALUES(" . $id . ", " . $i . ", " . $value . ")";
                    $conn->query($sql);
                    $i++;
                }
                if ($conn->commit()) {
                    return 1;
                } else {
                    return 4;
                }
            } else {
                return 4;
            }
            $conn->close();
        } else {
            return 2;
        }
    }

    public function getCandidates() : array {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT * FROM candidates";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $names = [];
                while ($row = $result->fetch_assoc()) {
                    $names[] = $row["name"];
                }
                return $names;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function removeLastVotes(): int
    {
        $database = new Database();
        $conn = $database->getConnection();


        if (isset($conn)) {
            $cookies = new Cookies();
            $conn->begin_transaction();
            $sql = "SELECT * FROM history WHERE commission_id = " . $cookies->getCommissionId() . " ORDER BY created DESC LIMIT 1";
            $commissionId = -1;
            $historyId = -1;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $commissionId = (int)$row["commission_id"];
                    $historyId = (int)$row["id"];
                }
            } else {
                return 3;
            }

            if ($commissionId == $cookies->getCommissionId()) {
                $sql = "DELETE FROM records WHERE history_id=" . $historyId;
                $conn->query($sql);
                $sql = "DELETE FROM history WHERE id=" . $historyId;
                $conn->query($sql);
            }
            if ($conn->commit()) {
                return 1;
            } else {
                return 4;
            }
        } else {
            return 4;
        }
        $conn->close();
    }

    /**
     * @return Commission[]
     */
    static public function getCommissions(): array
    {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT commission.*, countries.name FROM commission LEFT JOIN countries ON countries.id = commission.country_id WHERE commission.role_type = 0";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $commissions = [];
                while ($row = $result->fetch_assoc()) {
                    $commission = new Commission(
                        (int)$row["id"],
                        $row["username"],
                        (int)$row["country_id"],
                        (int)$row["confirmed"],
                        $row["name"],
                    );
                    $commissions[] = $commission;
                }
                return $commissions;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    static public function changeConfirmed($id, $confirmed): void
    {
        if ($confirmed == 0) {
            $confirmed = 1;
        } else {
            $confirmed = 0;
        }
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "UPDATE commission SET confirmed=" . $confirmed . " WHERE id=" . $id;
            $conn->query($sql);
        }
    }



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
    }

    /**
     * @return int
     */
    public function getConfirmed(): int
    {
        return $this->confirmed;
    }

    /**
     * @param int $confirmed
     */
    public function setConfirmed(int $confirmed): void
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName(string $countryName): void
    {
        $this->countryName = $countryName;
    }


}