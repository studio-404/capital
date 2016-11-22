<?php 
class Profile extends Controller
{
	public function __construct()
	{
		if(!isset($_SESSION["capex_user"]))
		{
			require_once 'app/functions/redirect.php';
			functions\redirect::url("/");
		}
	}

	public function index($name = '')
	{
		/* database */
		$modules = new Database('modules', array(
			"method"=>"selectAllFaq"
		));
		$contactData = new Database('modules', array(
			"method"=>"selectContactData",
			"lang"=>"ge"
		));
		$contactData = $contactData->getter();
		$page = new Database('page', array(
			"method"=>"selectAboutContent",
			"idx"=>2,
			"lang"=>"ge"
		)); 
		$cities = new Database("cities", array(
			"method"=>"select"
		));

		/* models */
		$auth = $this->model('auth');
		$loan = $this->model('loan');
		$loan->cities = $cities->getter(); 
		
		$question = $this->model('question');
		$question->questionsArray = $modules->getter();

		$about = $this->model('about');
		$about->content = $page->getter();

		$header = $this->model('header');
		$homepage = $this->model('homepage');
		$header->publicFolder = Config::PUBLIC_FOLDER;

		$header->contactNumber = strip_tags($contactData['phone']);
		$header->email = strip_tags($contactData['email']);

		/* view */
		$this->view('profile/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"public"=>Config::PUBLIC_FOLDER
			),
			"authModel"=>$auth->index(), 
			"loanModel"=>$loan->index(), 
			"questionModel"=>$question->index(), 
			"aboutModel"=>$about->index(), 
			"headerModel"=>$header->index(), 
			"homepageModel"=>$homepage->index(),
			"contactNumber"=>$header->contactNumber, 
			"email"=>$header->email 
		]);
	}
}