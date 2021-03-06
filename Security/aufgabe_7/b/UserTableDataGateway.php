<?php
class UserTableDataGateway
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findIdByCredentials(string $username, string $password)
    {
        try {

            $stmt = $this->pdo->prepare("SELECT id, username, passwd FROM user WHERE username=:username LIMIT 1");
            $stmt->execute(array(':username' => $username));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userRow !== false) {
                if (password_verify($password, $userRow['passwd'])) {
                    return (int)$userRow['id'];
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            printf("%s, User: %s was not found in the Database", $e->getMessage(), $username);
        }
    }

    public function findUserByUserName(string $username)
    {
        $sql = sprintf(
            "SELECT id, username, realname, email FROM user WHERE username=%s",
            $this->pdo->quote($username, PDO::PARAM_STR)
        );
        $result = $this->pdo->query($sql);
        if ($result->columnCount() != 1) {
            return false;
        }
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(int $id, string $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("UPDATE user SET passwd=:pass WHERE id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $hashedPassword, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result === false) {
            throw new RuntimeException("No record was updated");
        }
    }

}
