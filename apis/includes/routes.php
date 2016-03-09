<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/9/16
 * Time: 11:00 PM
 */

$method = $_SERVER['REQUEST_METHOD'];

$fist = explode("?", $_SERVER[REQUEST_URI]);
$route = explode("/", $fist[0]);
//var_dump($route);die();

$page = $route[1];


switch ($page) {


    case "client":
        require_once "inc_reg/reg.php";

        break;

    case "feedback":
        require_once "inc_client/feedback.php";

        break;

    case "mobac":
        switch ($route[2]) {

            case 'contacts':
                require_once "inc_mobac/contacts.php";
                break;

            case 'messages':
                require_once "inc_mobac/messages.php";
                break;

            case 'callDetails':
                require_once "inc_mobac/callDetails.php";
                break;

            default:
                echo "Wrong Way!!! Contact dev@blueteam.in";

                break;
        }


        break;

    case "cem":
        require_once "cem/cem.php";

        break;

    case "raw":
        require_once "inc_mobac/raw_json.php";
        break;

    case "service_request":
        if ($method == "POST") {
            require_once "inc_service_request/post.php";
        } else
            require_once "inc_service_request/service_request.php";
        break;

    case "services":
        require_once "inc_service_request/services.php";
        break;

    case "workers":
        switch ($route[2]) {
            case 'addNew':
                require_once "inc_workers/addNew.php";
                break;

            case ':id':
                require_once "inc_workers/worker.php";
                break;

            default:
                echo "Wrong Way, Contact: dev@blueteam.in";
                break;
        }

    case "me":
        require_once "me/me.php";

        break;

    case "check-mobile":
        require_once "app_rec/check_mobile.php";
        break;

    case "login":
        require_once "app_rec/login.php";
        break;

    case "work":
        if ($method == "POST")
            require_once "app_rec/postWork.php";
        else
            require_once "app_rec/getWork.php";
        break;

    default:
        internalServerError("Error description: " . json_encode($_SERVER));
        die();

        break;
}
