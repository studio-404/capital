<?php 
class callapi
{
	public $out;

	public function index()
	{
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$userid = functions\request::index("POST","userid");
		$_SESSION['capex_user'] = $userid;

		$json = file_get_contents(Config::WEBSITE."gio.json");
		$jj = json_decode($json, true);

		$this->out = $jj;

		return $this->out;
	}
}