<?php
class user
{
	public function index($conn, $args)
	{
		$out = 0;
		if(method_exists("user", $args["method"]))
		{
			$out = $this->$args["method"]($conn, $args['user'], $args['pass']);
		}
		return $out;
	}

	public function check($conn, $user, $pass){
		$sql = 'SELECT `id` FROM `users` WHERE `username`=:username AND `password`=:password';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":username"=>$user,
			":password"=>md5($pass)
		));
		$count = $prepare->rowCount();
		return $count;
	}
}
?>