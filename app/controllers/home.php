<?php
class Home extends Controller
{
	public $currency; 
	public function __construct()
	{
		require_once("app/functions/currency.php"); 
		$this->currency = new currency();
	}

	public function index($name = '')
	{
		/* database */
		$top = new Database('page', array(
			"method"=>"select",
			"cid"=>0,
			"nav_type"=>0, 
			"lang"=>"ge", 
			"status"=>0
		)); 
		$dbNavigation = $top->getter();


		$side = new Database('page', array(
			"method"=>"select",
			"cid"=>0,
			"nav_type"=>1, 
			"lang"=>"ge", 
			"status"=>0
		)); 
		$sideNavigation = $side->getter();

		$selectPictures = new Database('page', array(
			"method"=>"selectPhotos",
			"fetch"=>$sideNavigation
		)); 
		$pictures = $selectPictures->getter();


		$info = new Database('modules', array(
			"method"=>"selectInfo",
			"lang"=>"ge"
		)); 
		$selectInfo = $info->getter();

		$branches = new Database('modules', array(
			"method"=>"selectBranches",
			"lang"=>"ge"
		)); 
		$selectBranches = $branches->getter();

		$cities = new Database("cities", array(
			"method"=>"select"
		));

		/* model */
		$loan = $this->model('loan');
		$loan->cities = $cities->getter(); 
		$calculator = $this->model('calculator');
		$calculator->types = $sideNavigation;
		$navigation = $this->model('navigation');
		$aditionalNavigation = $this->model('aditionalNavigation');
		$aditionalNavigation->nav = $sideNavigation;
		

		/* view */
		$this->view('home/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"website_"=>Config::WEBSITE_,
				"public"=>Config::PUBLIC_FOLDER
			),
			"navigationDB"=>$dbNavigation, 
			"sideNavigation"=>$sideNavigation, 
			"pictures"=>$pictures, 
			"selectInfo"=>$selectInfo, 
			"selectBranches"=>$selectBranches, 
			"currency"=>$this->currency->index(),
			"loanModel"=>$loan->index(),
			"calculatorModel"=>$calculator->index(),
			"navigationModel"=>$navigation->index(), 
			"aditionalNavigationModel"=>$aditionalNavigation->index()  
		]);
	}

}