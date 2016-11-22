<?php 
class statements
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("statements", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function removeStatement($args)
	{
		$update = "UPDATE `statements` SET `status`=:one WHERE `id`=:id";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":id"=>$args['id'],
			":one"=>1
		)); 
		if($prepare->rowCount())
		{
			return 1;
		}
		return 0;
	}

	private function selectByPersonalNumber($args)
	{
		$fetch = array();
		$select = "SELECT * FROM `statements` WHERE `personal_number`=:personal_number AND `status`!=:one";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":personal_number"=>$args['pid'],
			":one"=>1 
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			if($fetch[0]["read"]==0){
				$this->updateRead($fetch[0]["id"]);
			}
		}
		return $fetch;
	}

	private function updateRead($id)
	{
		$update = "UPDATE `statements` SET `read`=:one WHERE `id`=:id";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":id"=>$id, 
			":one"=>1
		)); 
		if($prepare->rowCount())
		{
			return 1;
		}
		return 0;
	}

	private function select($args)
	{
		$fetch = array();
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (($_GET['pn']-1)*$itemPerPage) : 0;
		
		$select = "SELECT (SELECT COUNT(`id`) FROM `statements` WHERE `status`!=:one) as counted, `id`, `date`, `name`, `surname`, `personal_number`, `read` FROM `statements` WHERE `status`!=:one ORDER BY `date` DESC LIMIT ".$from.",".$itemPerPage;
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function insert($args)
	{
		require_once 'app/functions/server.php';
		$server = new functions\server();
		$ip = $server->ip();
		$out = 0;
		try{
			$insert = "INSERT INTO `statements` SET 
			`date`=:datex, 
			`ip`=:ip, 
			`loantype`=:loantype, 
			`name`=:name, 
			`surname`=:surname, 
			`personal_number`=:personal_number, 
			`dob`=:dob, 
			`gender`=:gender, 
			`email`=:email, 
			`phone`=:phone, 
			`city`=:city, 
			`street`=:street, 
			`house`=:house, 
			`room`=:room, 
			`postal_code`=:postal_code, 
			`monthly_income`=:monthly_income, 
			`loans`=:loans, 
			`password`=:password, 
			`agree`=:one, 
			`check_me`=:one, 
			`read`=:zero, 
			`status`=:zero 
			";
			$prepare = $this->conn->prepare($insert);
			$prepare->execute(array(
				":datex"=>time(),
				":ip"=>$ip,
				":loantype"=>$args['loanType'],
				":name"=>$args['name'],
				":surname"=>$args['surname'],
				":personal_number"=>$args['pid'],
				":dob"=>$args['dob'],
				":gender"=>$args['gender'],
				":email"=>$args['email'],
				":phone"=>$args['phone'],
				":city"=>$args['city'],
				":street"=>$args['street'],
				":house"=>$args['home'],
				":room"=>$args['flat'],
				":postal_code"=>$args['postal'],
				":monthly_income"=>$args['income'],
				":loans"=>$args['otherloan'],
				":password"=>$args['password'],
				":one"=>1,
				":zero"=>0
			));	
			if($prepare->rowCount()){
				$out = 1;	
			}			
		}catch(Exception $e){ $out = 0;	}
		return $out;
	}
}