<?php
use controllers\BaseController;
use models\Tutorials;
use classes\DHNavMenu;
use classes\HTML;
class TutorialsIndexController extends BaseController {
	private $tutorials;
	private $catagorySelectionMenu;
	private $tutorialSelectionMenu;
	private $articleSelectionMenu;
	private $tutorialarticle;
	public function __construct() {
		parent::__construct ();
		$this->tutorials = new Tutorials ();
		$this->view->assignSectionContent ( "pageTitle", "Tutorials" );
		$this->view->assignSectionContent ( "subTitle", "Catagories" );
		$this->view->assign("menuName", "main_menu");
		
		
		/*
		 * in tuts constructor read database of all catagories / tuts etc ? or allow foreach action function to do only whats needed? think the latter as (if) tut lists grow massive, intro huge overhead? and for now -- :D no db retieval. using hard copies of tuts
		 */
	}
	public function index($paramaterOne = null, $paramaterTwo = null) {
		$catagoryList = array ();
		
		if (! $paramaterOne) {
			
			if (isset ( $this->request->_action ['paramaters'] [0] )) {
				$paramaterOne = $this->request->_action ['paramaters'] [0];
				$paramaterOne=strtolower ( $paramaterOne );
			} else {
				$paramaterOne = "all";
			}
			
			if (isset ( $this->request->_action ['paramaters'] [1] )) {
				$paramaterTwo = $this->request->_action ['paramaters'] [1];
				$paramaterTwo=strtolower ( $paramaterTwo );
			}
		}
		
		
		$this->tutorialResult = $this->tutorials->search($paramaterOne,$paramaterTwo);
		$this->view->assignSectionContent ( "tutorialArticle", $this->tutorialResult['selection'] );
		
		$this->view->replaceSectionContent("subTitle", $this->tutorialResult['subTitle']);
		$this->view->show ( "main" );
		
			
		
		
	}

	
	public function recent(){
		$this->view->assignSectionContent ("inDevelopment","page will show all recently added tutorials. it may allow paramater in url to limit those showen by catagory");
		
		$this->view->show ( "main" );
	}
	
	public function search(){
		$this->view->assignSectionContent ("inDevelopment","page will allow for searching tutorials in some way. it may allow paramaters in url to create search result");
		
		$this->view->show ( "main" );
	}
}