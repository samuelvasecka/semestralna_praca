<?php
declare(strict_types=1);
require_once "Database.php";

class Country
{
    private int $id;
    private string $name;
    private int $voters;
    private int $electoralVotes;

    /**
     * Country constructor.
     * @param int $id
     * @param string $name
     * @param int $voters
     * @param int $electoralVotes
     */
    public function __construct(int $id, string $name, int $voters, int $electoralVotes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->voters = $voters;
        $this->electoralVotes = $electoralVotes;
    }

    /**
     * @return stdClass[]
     */
    static public function getCountries() : array {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT * FROM countries";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $countries = [];
                while ($row = $result->fetch_assoc()) {
                    $country = new stdClass();
                    $country->id = (int)$row["id"];
                    $country->name = $row["name"];
                    $countries[] = $country;
                }
                return $countries;
            } else {
                return [];
            }
            $conn->close();
        } else {
            return [];
        }
    }

    static public function getResults($countyId) : array {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT records.candidate_id, candidates.party, candidates.name, sum(records.votes) as total_votes FROM records LEFT JOIN candidates ON records.candidate_id = candidates.id LEFT JOIN history ON records.history_id = history.id LEFT JOIN commission ON history.commission_id = commission.id";
            if ($countyId != 0) {
                $sql.=" WHERE commission.country_id =".$countyId;
            }
            $sql .= " GROUP BY candidate_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $candidates = [];
                while ($row = $result->fetch_assoc()) {
                    $candidate = new stdClass();
                    $candidate->id = (int)$row["candidate_id"];
                    $candidate->name = $row["name"];
                    $candidate->votes = (int)$row["total_votes"];
                    $candidate->party = $row["party"];
                    $candidates[] = $candidate;
                }
                return $candidates;
            } else {
                $sql = "SELECT candidates.id as candidate_id, candidates.name, candidates.party FROM candidates";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $candidates = [];
                    while ($row = $result->fetch_assoc()) {
                        $candidate = new stdClass();
                        $candidate->id = (int)$row["candidate_id"];
                        $candidate->name = $row["name"];
                        $candidate->party = $row["party"];
                        $candidate->votes = 0;
                        $candidates[] = $candidate;
                    }
                    return $candidates;
                }else {
                    return [];
                }
            }
            $conn->close();
        } else {
            return [];
        }
    }

    static public function getElectoralResults() : array {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $sql = "SELECT countries.id, countries.name, countries.electoral_votes from countries";
            $result = $conn->query($sql);
            $countries = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $country = new stdClass();
                    $country->id = (int)$row["id"];
                    $country->name = $row["name"];
                    $country->electoral_votes = (int)$row["electoral_votes"];
                    $countries[] = $country;
                }
            }

            $candidatesVotes = [];
            for ($i = 0; $i < count($countries); $i++) {
                $candidates = self::getResults($countries[$i]->id);

                $id = -1;
                $max = 0;
                foreach ($candidates as $candidate) {
                    if ($i == 0) {
                        $candidateVotes = new stdClass();
                        $candidateVotes->id = $candidate->id;
                        $candidateVotes->name = $candidate->name;
                        $candidateVotes->electoral_votes = 0;
                        $candidatesVotes[] = $candidateVotes;
                    }
                    if ($candidate->votes > $max && $candidate->votes != 0) {
                        $id = $candidate->id;
                        $max = $candidate->votes;
                    }
                }
                if ($id != -1) {
                    $candidatesVotes[$id-1]->electoral_votes += $countries[$i]->electoral_votes;
                }
            }
            return $candidatesVotes;
            $conn->close();
        } else {
            return  [];
        }
    }
}