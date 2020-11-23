<?php
declare(strict_types=1);
require_once "CookieManager.php";
require_once "Database.php";

class User
{
    private int $id;
    private string $fullName;
    private string $email;
    private string $password;
    private int $actualWedding;

    /**
     * User1 constructor.
     * @param int $id
     * @param string $fullName
     * @param string $email
     * @param string $password
     * @param int $actualWedding
     */
    public function __construct(int $id, string $fullName, string $email, string $password, int $actualWedding)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->actualWedding = $actualWedding;
    }

    public static function getUserFromArray(array $user): User
    {
        return new User(
            (int)$user["id"],
            $user["full_name"],
            $user["email"],
            $user["password"],
            (int)$user["actual_wedding"]
        );
    }

    public static function getUser() : array {
        $database = new Database();
        $conn = $database->getConnection();
        if (isset($conn)) {
            $cookieManager = new CookieManager();
            $sql = "SELECT * FROM users WHERE id=".$cookieManager->getUserId();
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            } else {
                return [];
            }
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
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getActualWedding(): int
    {
        return $this->actualWedding;
    }

    /**
     * @param int $actualWedding
     */
    public function setActualWedding(int $actualWedding): void
    {
        $this->actualWedding = $actualWedding;
    }

    public function updateActualWedding(): bool {
        $database = new Database();
        $conn = $database->getConnection();
        if (!isset($conn)) {
            return false;
        } else {
            $sql = "UPDATE users SET actual_wedding='".$this->actualWedding."' WHERE id = ".$this->id;
            return $conn->query($sql);
        }
    }
}