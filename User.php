<?php

class User
{
	public $id;
	public $name;
	public $surname;
	public $birthday;
	public $gender;
	public $city;

	public function __construct(int $id)
	{
		$data = $this->findById($id);

		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->surname = $data['surname'];
		$this->birthday = self::getAge($data['birthday']);
		$this->gender = self::getFormatGender($data['gender']);
		$this->city = $data['city'];

		//print_r(self::formatData($data));		

	}

	public static function formatData(array $data)
	{
		$obj_user = new stdClass;

		$obj_user->id = $data['id'];

		$obj_user->name = $data['name'];

		$obj_user->surname = $data['surname'];	

		$obj_user->age = self::getAge($data['birthday']);

		$obj_user->gender = self::getFormatGender($data['gender']);

		$obj_user->city = $data['city'];

		return $obj_user;

	}

	public function findById($id)
	{
		$conn = self::getConnection();

		$sql = "SELECT * FROM `users` WHERE id = :id LIMIT 1";

		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		$stmt->execute();

		$array = $stmt->fetch(PDO::FETCH_ASSOC);

		if($array)
		{
			return $array;
		}

		$conn = null;
	
		return false;
	}

	public function save()
	{
		$conn = self::getConnection();

		$sql = "INSERT INTO `users` 
		(`name`, `surname`, `birthday`, `gender`, `city`) 
		VALUES (:name, :surname, :birthday, :gender, :city)";

		$result = $conn->prepare($sql);

        $result->bindParam(':name', $name, PDO::PARAM_STR);

        $result->bindParam(':surname', $surname, PDO::PARAM_STR);

        $result->bindParam(':birthday', $birthday, PDO::PARAM_STR);

        $result->bindParam(':gender', $gender, PDO::PARAM_INT);

        $result->bindParam(':city', $city, PDO::PARAM_STR);

        if ($result->execute())
        {
            return true;
        }

        $conn = null;

        return false;
	}

	public function delete(int $id)
	{
		
		$conn = self::getConnection();

		$sql = "DELETE FROM `users` WHERE `id` = :id";

		$stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $conn = null;

		return true;
	}

	public static function getAge($data)
	{
		$born = new DateTime($data);
		$age = $born->diff(new DateTime)->format('%y');

		return $age;
	}

	public static function getFormatGender($gender)
	{		

		$array = ['Муж.', 'Жен.'];

		return $array[$gender];
	}

	public static function getConnection()
	{
		return $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
	}
}
