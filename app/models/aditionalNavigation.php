<?php 
class aditionalNavigation
{
	public $nav;
	public function __construct()
	{

	}

	public function index()
	{
		$out = "<div id=\"HomeMenu\" style=\"position:fixed; top:175px; left:100px; z-index: 99\">";
		$i = 1;
		foreach ($this->nav as $val) {
			$active = ($i==1) ? " active" : "";
			$out .= "<a href=\"#".$val['cssclass']."\" class=\"".$active."\">".$val['title']."</a><br/>";
			$i++;
		}
		$out .= "</div>";

		return $out;
	}
}