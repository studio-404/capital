<?php 
class modules
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("modules", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function selectInfoData($args)
	{
		$out['agreement'] = "";
		$select = "SELECT `description` FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `visibility`!=:one AND `status`!=:one ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":type"=>"info",
			":one"=>1,
			":lang"=>$args['lang']
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			$out['agreement'] = $fetch[3]['description'];
		}
		
		return $out;
	}

	private function selectParentUsefull($args)
	{
		$fetch = array();
		$select = "SELECT * FROM `usefull_modules` WHERE `lang`=:lang AND `status`!=:one ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1,
			":lang"=>$args['lang']
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $fetch;
	}

	private function parentModuleOptions($args)
	{
		$options = array();
		$fetch = $this->selectParentUsefull($args);
		foreach ($fetch as $val) {
			$options[$val['type']] = $val['title'];
		}
		$options["false"] = "- მიმაგრების მოხსნა";
		return $options;
	}

	private function selectInfo($args)
	{
		$out['phone'] = "";
		$out['contact1'] = "";
		$out['contact2'] = "";

		$select = "SELECT `description` FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `visibility`!=:one AND `status`!=:one ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":type"=>"info",
			":one"=>1,
			":lang"=>$args['lang']
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			$out['phone'] = @$fetch[0]['description'];
			$out['contact1'] = @$fetch[1]['description'];
			$out['contact2'] = @$fetch[2]['description'];
		}
		
		return $out;
	}

	private function selectBranches($args)
	{
		$fetch = array();
		$select = "SELECT `description` FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `visibility`!=:one AND `status`!=:one ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":type"=>"branches",
			":one"=>1,
			":lang"=>$args['lang']
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		
		return $fetch;
	}

	private function select($args)
	{
		$fetch = array();
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (($_GET['pn']-1)*$itemPerPage) : 0;
		$parsed_url = $args['parsed_url'];
		if(isset($parsed_url[2])){
			$select = "SELECT (SELECT COUNT(`id`) FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `status`!=:one) as counted, `idx`, `title`, `visibility`, `lang` FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `status`!=:one ORDER BY `id` ASC LIMIT ".$from.",".$itemPerPage;
			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":type"=>$parsed_url[2], 
				":lang"=>$args['lang'],
				":one"=>1
			));
			if($prepare->rowCount()){
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		return $fetch;
	}

	private function selectById($args)
	{
		$fetch = array();
		$select = "SELECT * FROM `usefull` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:one";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":idx"=>$args['idx'], 
			":lang"=>$args['lang'], 
			":one"=>1
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function edit($args)
	{
		$idx = $args["idx"];
		$lang = $args["lang"];
		$date = strtotime($args["date"]);
		$title = $args["title"];
		$description = $args["pageText"];
		$url = (!empty($args["link"])) ? $args["link"] : "";


		$update = "UPDATE `usefull` SET 
		`date`=:datex, 
		`title`=:title, 
		`description`=:description, 
		`url`=:url 
		WHERE `idx`=:idx AND `lang`=:lang";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":datex"=>$date,
			":title"=>$title,
			":description"=>$description,
			":url"=>$url,
			":idx"=>$idx, 
			":lang"=>$lang 
		));	
		if($prepare->rowCount()){
			return 1;	
		}
		return 0;
	}

	private function updateVisibility($args)
	{
		$visibility = ($args['visibility']==0) ? 1 : 0;
		$idx = (int)$args['idx'];

		$update = "UPDATE `usefull` SET `visibility`=:visibility WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":visibility"=>$visibility, 
			":idx"=>$idx
		));
		if($prepare->rowCount())
		{
			return 1;
		}
		return 0;
	}

	private function add($args)
	{
		$date = strtotime($args['date']);
		$type = $args['moduleSlug'];
		$title = $args['title'];
		$pageText = $args['pageText'];
		$link = (!empty($args["link"])) ? $args["link"] : "";

		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$max = "SELECT MAX(`idx`) as maxidx FROM `usefull` WHERE `status`!=:one";
		$prepare2 = $this->conn->prepare($max);
		$prepare2->execute(array(":one"=>1));
		$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
		$maxId = ($fetch2["maxidx"]) ? $fetch2["maxidx"] + 1 : 1;

		foreach ($fetch as $val) {
			$insert = "INSERT INTO `usefull` SET `idx`=:idx, `date`=:datex, `type`=:type, `title`=:title, `description`=:description, `url`=:url, `lang`=:lang";
			$prepare3 = $this->conn->prepare($insert);
			$prepare3->execute(array(
				":idx"=>$maxId, 
				":datex"=>$date, 
				":type"=>$type, 
				":title"=>$title, 
				":description"=>$pageText, 
				":url"=>$link,
				":lang"=>$val['title']
			)); 
		}
		return 1;
	}

	private function removeModule($args)
	{
		$idx = $args['idx'];

		$update = "UPDATE `usefull` SET `status`=:one WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update); 
		$prepare->execute(array(
			":one"=>1,
			":idx"=>$idx
		));
		if($prepare->rowCount()){
			return 1;
		}

		return 0;
	}
}