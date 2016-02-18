<?php

	$input = json_decode(file_get_contents ("php://input"));

	//$user_id = $_SESSION['user_id'];
	//$employeeType = $_SESSION['employee_type'];
	$employeeType = 'cem';
	$user_id = 6;
	$route = explode("/",$_SERVER[REQUEST_URI]);
	
	$SR_id = intval($route['2']);
	
	
	if ($route[2] == 'picked' || $route[2] == 'match' || $route[2] == 'meeting' || $route[2] == 'demo' || $route[2] == 'done'|| $route[2] == 'open' || $route[2] == '24hours') {
		
		$status = $route['2'];
		serviceRequestView($status, $user_id, $db_handle);
	}
	elseif (is_int($SR_id)) {
		
		if ($route['3'] == 'pick') {
			pickServiceRequest($SR_id, $user_id, $db_handle);
		}
		elseif ($route['3'] == 'add_note') {
			addNote($input, $SR_id, $user_id, $db_handle, $employeeType);
		}
	}
	else {

	}

	function addNote ($input, $SR_id, $user_id, $db_handle, $employeeType) {

		if ($employeeType == 'cem') {
			echo "inside if";
			$about  = "client_request";
		}
		else {
			echo "inside else";
			$about  = "worker";
		}

		$sql = "INSERT INTO bluenethack_v0.notes (`id`, `sr_id`, `note`, `cem_id`, `about`) VALUES 
					(NULL, '$SR_id', '".$input->root->note."', '$user_id', '$about');";
		
		$updateRequest = mysqli_query ($db_handle, $sql);

		if(mysqli_connect_errno()){
			// send 500 html header
		}
	}

	function pickServiceRequest ($SR_id, $user_id, $db_handle) {
		
		$sql = "UPDATE bluenethack_v0.service_request SET cem_id= $user_id, last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
		
		$updateRequest = mysqli_query ($db_handle, $sql);
	
		$sql ="INSERT INTO bluenethack_v0.updates (`id`, `user_id`, `update_time`, `request_id`, `old_status`, `new_status`) 
													VALUES (NULL, $user_id, CURRENT_TIMESTAMP, $SR_id, 'open', 'picked');";
		$updates = mysqli_query ($db_handle, $sql);
		if(mysqli_connect_errno()){
			// send 500 html header
		}

	}

	function serviceRequestView ($status, $user_id, $db_handle) {

		$condition = "";

		switch ($status) {
			case 'picked':
				$condition = " sr.cem_id = " .$user_id. " AND sr.status = 'open'";
				break;
			case 'match':
				 $condition = " sr.cem_id = 0 AND sr.me_id != 0 AND status = 'open' AND (sr.match_id != 0 OR sr.match2_id != 0)" ;
				 break;
			case 'meeting':
				$condition = " sr.status = 'meeting' AND sr.cem_id = " .$user_id ;
				break;
			case 'demo':
				 $condition = " sr.status='demo' AND sr.cem_id = " .$user_id ;
				break;
			case 'done':
				$condition = " sr.status='done' AND sr.cem_id = " .$user_id ;
				break;
			case '24hours':
				 $condition = " sr.cem_id = 0 AND sr.match_id = 0 AND sr.match2_id = 0 AND sr.status = 'open' AND sr.work_time = 24 " ;
				break;
			case 'open':
				$condition = " sr.cem_id = 0 AND sr.match_id = 0 AND sr.match2_id = 0 AND sr.status = 'open' " ;
				break;
			default:
				$condition = " sr.cem_id = 0 AND sr.match_id = 0 AND sr.match2_id = 0 AND sr.status = 'open' AND sr.work_time != 24 " ;
				break;
		}

		$service_requests = mysqli_query($db_handle, "SELECT bluenethack_v0.sr.* FROM service_request as sr WHERE ".$condition." ; ") ;

		$rows = array();

		while ($service_requestsRow = mysqli_fetch_assoc($service_requests)) {
			
			$sr_id = $service_requestsRow['id'];
			$match1_id = $service_requestsRow['match_id'];
			$match2_id = $service_requestsRow['match2_id'];
			$me_id = $service_requestsRow['me_id'];
			$cem_id = $service_requestsRow['cem_id'];

			if ( $match1_id !=0 OR $match2_id !=0 ) {
				if ($match1_id != 0) {
					$match_1 = mysqli_query ($db_handle, "SELECT * FROM workers WHERE id = $match1_id ;");
					$match1Row = mysqli_fetch_assoc($match_1) ;
				}
				if ($match2_id !=0) {
					$match_2 = mysqli_query ($db_handle, "SELECT * FROM workers WHERE id = $match2_id ;");
					$match2Row = mysqli_fetch_assoc($match_2) ;
				}
			}

			if ($me_id != 0) {
				$picked_by_me = mysqli_query ($db_handle, "SELECT * FROM user WHERE id = $me_id ;");
				$picked_by_meRow = mysqli_fetch_assoc($picked_by_me) ;
			}

			if ($cem_id !=0) {
				$picked_by_cem = mysqli_query ($db_handle, "SELECT * FROM user WHERE id = $cem_id ;");
				$picked_by_cemRow = mysqli_fetch_assoc($picked_by_cem) ;
			}
			
			$notes = mysqli_query ($db_handle, "SELECT * FROM notes WHERE sr_id = $sr_id ;");

			for($notesArr = array(); $note = mysqli_fetch_assoc($notes); $notesArr[] = $note);
				
			$notes = mysqli_fetch_assoc($notes);

			$rows[] = array_merge( $service_requestsRow , array("notes" => $notesArr ), 
									array("picked_by_me" => $picked_by_meRow ), array("picked_by_cem" => $picked_by_cemRow ),
									array("match1" => $match1Row ), array("match2" => $match2Row )) ;
			$match1Row = "";
			$match2Row = "";
			$picked_by_meRow = "";
			$picked_by_cemRow = "";

		}
	 	
		echo "{\"root\":";
		print json_encode($rows);
		echo "}";

	}


?>