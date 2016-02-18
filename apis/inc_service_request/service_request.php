<?php

	$input = json_decode(file_get_contents ("php://input"));
	//var_dump($input);
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
		elseif ($route['3'] == 'change_status') {
			changeStatus($input, $SR_id, $user_id, $db_handle);
		}
		elseif ($route['3'] == 'add_meeting') {
			addMeeting($input, $SR_id, $user_id, $db_handle);
		}
		elseif ($route['3'] == 'add_worker') {

			$workerFName = $input->root->first_name;
			$workerAge = $input->root->age;
			$workerPhone = $input->root->phone;

			$sql = "SELECT id, first_name, last_name, phone FROM bluenethack_v0.workers WHERE age='$workerAge' AND phone = '$workerPhone' AND first_name = '$workerFName' ;";
		
			$worker = mysqli_query ($db_handle, $sql);
			$workerRow = mysqli_fetch_array($worker);


			if (mysqli_num_rows($workerRow) == 0) {
			
				//echo getcwd(); die();
				include_once "/var/www/html/api_bluenet/apis/inc_workers/add_worker_function.php";
				$new_worker_id = addNewWorker($input, $user_id, $db_handle);

				if ($route['4'] == '1'){
					
					$sql = "UPDATE bluenethack_v0.service_request SET match_id = '$new_worker_id', last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
					$updateRequest = mysqli_query ($db_handle, $sql);
				}
				elseif($route['4'] == '2') {
					$sql = "UPDATE bluenethack_v0.service_request SET match2_id = '$new_worker_id', last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
					$updateRequest = mysqli_query ($db_handle, $sql);
				}
			
			}

			else {

				$worker_id = $workerRow['id'];
				if ($route['4'] == '1'){
					
					$sql = "UPDATE bluenethack_v0.service_request SET match_id = '$worker_id', last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
					$updateRequest = mysqli_query ($db_handle, $sql);
				}
				elseif($route['4'] == '2') {
					$sql = "UPDATE bluenethack_v0.service_request SET match2_id = '$worker_id', last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
					$updateRequest = mysqli_query ($db_handle, $sql);
				}
			}
		}
	}
	else {

	}

	function addMeeting($input, $SR_id, $user_id, $db_handle) {

		$sql = "UPDATE bluenethack_v0.service_request SET status = 'meeting', last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
		
		$updateRequest = mysqli_query ($db_handle, $sql);
		/*$sql = "SELECT status, match_id, match2_id FROM bluenethack_v0.service_request WHERE id='$SR_id';";

		$matchIDsSql = mysqli_query ($db_handle, $sql);
		$matchIDsSqlRow = mysqli_fetch_array($matchIDsSql);
		$match1 = $matchIDsSqlRow['match_id'];
		$match2 = $matchIDsSqlRow['match2_id'];
		
		$oldStatus = $matchIDsSqlRow['status'];

		if ($input->root->worker_id == $match1)
			$workerId = $match1;
		elseif ($input->root->worker_id == $match2)
			$workerId = $match2;
		else
			$workerId = 0;*/

		$sql = "INSERT INTO bluenethack_v0.meetings (`id`, `match_id`, `meeting_time`, `remarks`, `cem_id`, `worker_id`) VALUES 
													(NULL, '$SR_id',
													'".$input->root->meeting_date." ".$input->root->meeting_time."',
													'".$input->root->remarks."',
													'$user_id', '".$input->root->worker_id."');";
		
		$updateRequest = mysqli_query ($db_handle, $sql);
	
		$sql ="INSERT INTO bluenethack_v0.updates (`id`, `user_id`, `update_time`, `request_id`, `old_status`, `new_status`) 
													VALUES (NULL, $user_id, CURRENT_TIMESTAMP, $SR_id, 'open', 'meeting');";
		$updates = mysqli_query ($db_handle, $sql);
		if(mysqli_connect_errno()){
			// send 500 html header
		}
	}

	function changeStatus($input, $SR_id, $user_id, $db_handle) {

		/*$sql = "SELECT status FROM bluenethack_v0.service_request WHERE id='$SR_id';";

		$oldStatusSql = mysqli_query ($db_handle, $sql);
		$oldStatusRow = mysqli_fetch_array($oldStatusSql);
		$oldStatus = $oldStatusRow['status'];*/

		$sql = "UPDATE bluenethack_v0.service_request SET status = '".$input->root->new_status."', last_updated = CURRENT_TIMESTAMP WHERE id='$SR_id';";
		
		$updateRequest = mysqli_query ($db_handle, $sql);
	
		$sql ="INSERT INTO bluenethack_v0.updates (`id`, `user_id`, `update_time`, `request_id`, `old_status`, `new_status`) 
													VALUES (NULL, $user_id, CURRENT_TIMESTAMP, $SR_id, '".$input->root->old_status."', '".$input->root->new_status."');";
		$updates = mysqli_query ($db_handle, $sql);
		if(mysqli_connect_errno()){
			// send 500 html header
		}

	}

	function addNote ($input, $SR_id, $user_id, $db_handle, $employeeType) {

		if ($employeeType == 'cem') {
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