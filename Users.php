<?php

class Users
{
	public $users = [];

	public function __construct(array $array)
	{

		foreach ($array as $item)
		{
			$user = new User($item);
			$this->users[] = $user->id;
		}
	}

	public function deleteUsers()
	{
		$ids = $this->users;

		$conn = self::getConnection();

		try {

				if(count($ids) > 0)
				{

					$sql = "DELETE FROM `users` WHERE `id` IN (" . implode(',', array_map('intval', $ids)) . ")";

					$stmt = $conn->prepare($sql);

        			$stmt->execute();
    			}
    		}

    	catch(PDOException $e) {
    		echo "Ошибка при удалении записи в базе данных: " . $e->getMessage();
		}

        $conn = null;

		return true;
	}

	public static function getConnection()
	{
		return $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
	}
}