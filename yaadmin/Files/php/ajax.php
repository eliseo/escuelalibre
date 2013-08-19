<?

$email = "yourmail@gmail.com";
$password = "PASSWORD";
$report_id = 34583510; // $report_id is the Google report ID for the selected account

if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'){
	if($_POST['get'] == 'statistic'){
		$stats = array();
		$visits = array();
		$vis_stats = array();
		$vis_pv = array();
		require 'gapi.class.php';
		$ga = new gapi($email, $password);

		$time_start = date("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
		$time_end  = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
		
		$ga->requestReportData($report_id, array('date'), array('pageviews', 'visits'), array("date"), $filter=null, $time_start, $time_end);
		foreach($ga->getResults() as $result){
			$metrics = $result->getMetrics();
			$dimesions = $result->getDimesions();
			$date = $dimesions["date"];
			list($year, $month, $day) = array(substr($date, 0, 4), substr($date, 4, 2), substr($date, 6, 2));
			$timestamp = mktime(0, 0, 0, $month, $day, $year);
			$stats[] = array($timestamp*1000, $metrics['visits']);
			$vis_stats[] = array($month.'/'.$day.'/'.$year, $metrics['visits'], $result->getPageviews());
		}
		
		for($i=0;$i<count($stats);$i++) $visits[] = $stats[$i][1];
		$max = max($visits);
		$min = min($visits);
		$medium = $min + ($max - $min)/2;
		$max_new = $medium*2;
		if($max_new>100 && $max_new < 1000) $roundFigure = 100;
		elseif($max_new>=1000 && $max_new < 10000) $roundFigure = 500;
		else $roundFigure = 1000;
		$output = $max_new - fmod($max_new, $roundFigure) + $roundFigure;
		$min = 0;
		if(!$_POST['type'] == 'visualize'){
			$return = array("stats" => $stats, "ticks" => array($min, $output/2, $output), "max" => $output, "min" => $min);
			echo json_encode($return);
			//print_r($return);
		}else{
			echo json_encode($vis_stats);
			//print_r($pageviews);
		}
	}
}
?>