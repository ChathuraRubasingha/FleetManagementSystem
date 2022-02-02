<?php

class TestController extends Controller
{
	var $aUsers = array(
		"€dams, Egbert",
		"Altman, Alisha",
		"Archibald, Janna",
		"Auman, Cody",
		"Bagley, Sheree",
		"Ballou, Wilmot",
		"Bard, Cassian",
		"Bash, Latanya",
		"Beail, May",
		"Black, Lux",
		"Bloise, India",
		"Blyant, Nora",
		"Bollinger, Carter",
		"Burns, Jaycob",
		"Carden, Preston",
		"Carter, Merrilyn",
		"Christner, Addie",
		"Churchill, Mirabelle",
		"Conkle, Erin",
		"Countryman, Abner",
		"Courtney, Edgar",
		"Cowher, Antony",
		"Craig, Charlie",
		"Cram, Zacharias",
		"Cressman, Ted",
		"Crissman, Annie",
		"Davis, Palmer",
		"Downing, Casimir",
		"Earl, Missie",
		"Eckert, Janele",
		"Eisenman, Briar",
		"Fitzgerald, Love",
		"Fleming, Sidney",
		"Fuchs, Bridger",
		"Fulton, Rosalynne",
		"Fye, Webster",
		"Geyer, Rylan",
		"Greene, Charis",
		"Greif, Jem",
		"Guest, Sarahjeanne",
		"Harper, Phyllida",
		"Hildyard, Erskine",
		"Hoenshell, Eulalia",
		"Isaman, Lalo",
		"James, Diamond",
		"Jenkins, Merrill",
		"Jube, Bennett",
		"Kava, Marianne",
		"Kern, Linda",
		"Klockman, Jenifer",
		"Lacon, Quincy",
		"Laurenzi, Leland",
		"Leichter, Jeane",
		"Leslie, Kerrie",
		"Lester, Noah",
		"Llora, Roxana",
		"Lombardi, Polly",
		"Lowstetter, Louisa",
		"Mays, Emery",
		"Mccullough, Bernadine",
		"Mckinnon, Kristie",
		"Meyers, Hector",
		"Monahan, Penelope",
		"Mull, Kaelea",
		"Newbiggin, Osmond",
		"Nickolson, Alfreda",
		"Pawle, Jacki",
		"Paynter, Nerissa",
		"Pinney, Wilkie",
		"Pratt, Ricky",
		"Putnam, Stephanie",
		"Ream, Terrence",
		"Rumbaugh, Noelle",
		"Ryals, Titania",
		"Saylor, Lenora",
		"Schofield, Denice",
		"Schuck, John",
		"Scott, Clover",
		"Smith, Estella",
		"Smothers, Matthew",
		"Stainforth, Maurene",
		"Stephenson, Phillipa",
		"Stewart, Hyram",
		"Stough, Gussie",
		"Strickland, Temple",
		"Sullivan, Gertie",
		"Swink, Stefanie",
		"Tavoularis, Terance",
		"Taylor, Kizzy",
		"Thigpen, Alwyn",
		"Treeby, Jim",
		"Trevithick, Jayme",
		"Waldron, Ashley",
		"Wheeler, Bysshe",
		"Whishaw, Dodie",
		"Whitehead, Jericho",
		"Wilks, Debby",
		"Wire, Tallulah",
		"Woodworth, Alexandria",
		"Zaun, Jillie"
	);
	
	
	var $aInfo = array(
		"Bedfordshire",
		"Buckinghamshire",
		"Cambridgeshire",
		"Cheshire",
		"Cornwall",
		"Cumbria",
		"Derbyshire",
		"Devon", 
		"Dorset", 
		"Durham", 
		"East Sussex",
		"Essex",
		"Gloucestershire",
		"Hampshire",
		"Hertfordshire", 
		"Kent", 
		"Lancashire",
		"Leicestershire",
		"Lincolnshire",
		"Norfolk",
		"Northamptonshire",
		"Northumberland", 
		"North Yorkshire", 
		"Nottinghamshire",
		"Oxfordshire",
		"Shropshire",
		"Somerset",
		"Staffordshire",
		"Suffolk", 
		"Surrey",
		"Warwickshire",
		"West Sussex",
		"Wiltshire",
		"Worcestershire", 
		"Durham", 
		"East Sussex",
		"Essex",
		"Gloucestershire",
		"Hampshire",
		"Hertfordshire", 
		"Kent", 
		"Lancashire",
		"Leicestershire",
		"Lincolnshire",
		"Norfolk",
		"Northamptonshire",
		"Northumberland", 
		"North Yorkshire", 
		"Nottinghamshire",
		"Oxfordshire",
		"Shropshire",
		"Somerset",
		"Staffordshire",
		"Suffolk", 
		"Surrey",
		"Warwickshire",
		"West Sussex",
		"Wiltshire",
		"Worcestershire", 
		"Durham", 
		"East Sussex",
		"Essex",
		"Gloucestershire",
		"Hampshire",
		"Hertfordshire", 
		"Kent", 
		"Lancashire",
		"Leicestershire",
		"Lincolnshire",
		"Norfolk",
		"Northamptonshire",
		"Northumberland", 
		"North Yorkshire", 
		"Nottinghamshire",
		"Oxfordshire",
		"Shropshire",
		"Somerset",
		"Staffordshire",
		"Suffolk", 
		"Surrey",
		"Warwickshire",
		"West Sussex",
		"Wiltshire",
		"Worcestershire", 
		"Durham", 
		"East Sussex",
		"Essex",
		"Gloucestershire",
		"Hampshire",
		"Hertfordshire", 
		"Kent", 
		"Lancashire",
		"Leicestershire",
		"Lincolnshire",
		"Norfolk",
		"Northamptonshire",
		"Northumberland", 
		"North Yorkshire", 
		"Nottinghamshire"
	);
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'application.views.layouts.test_layout';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
		
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow all
				'users'=>array('*'),
			),
		);
	}

	private function processParams(){
		$input = strtolower(Yii::app()->request->getParam('input'));
		$len = strlen($input);
		$limit = Yii::app()->request->getParam('limit');
		
		$limit = $limit ? $limit : 0;
	
	
		$aResults = array();
		$count = 0;
	
		if ($len)
		{
			for ($i=0;$i<count($this->aUsers);$i++)
			{
				// had to use utf_decode, here
				// not necessary if the results are coming from mysql
				//
				if (strtolower(substr(utf8_decode($this->aUsers[$i]),0,$len)) == $input)
				{
					$count++;
					$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($this->aUsers[$i]), "info"=>htmlspecialchars($this->aInfo[$i]) );
				}
				
				if ($limit && $count==$limit)
					break;
			}
		}
		return $aResults;
	}
	public function actionAutocomplete(){
		

		
		$this->render('autocomplete');
		
		Yii::app()->end();
	}
	
	public function actionJson(){
		
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header ("Pragma: no-cache"); // HTTP/1.0
		
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		$matches = $this->processParams();
		
		for ($i=0;$i<count($matches);$i++)
		{
			$arr[] = "{\"id\": \"".$matches[$i]['id']."\", \"value\": \"".$matches[$i]['value']."\", \"info\":\"".$matches[$i]['info']."\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
		
		Yii::app()->end();
	}
	
	public function actionXml(){
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header ("Pragma: no-cache"); // HTTP/1.0
		
		header("Content-Type: text/xml");

		$matches = $this->processParams();
		
		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<count($matches);$i++)
		{
			echo "<rs id=\"".$matches[$i]['id']."\" info=\"".$matches[$i]['info']."\">".$matches[$i]['value']."</rs>";
		}
		echo "</results>";
		
	}
	
}
