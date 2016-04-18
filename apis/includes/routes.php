<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/9/16
 * Time: 11:00 PM
 */

$method = $_SERVER['REQUEST_METHOD'];

$fist = explode("?", $_SERVER[REQUEST_URI   ]);
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
            if(isset($route[2]))
                require_once "inc_service_request/put.php";
            else
                require_once "inc_service_request/post.php";
        } else if ($method == "PUT") {
            require_once "inc_service_request/put.php";
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
                require_once "inc_workers/worker.php";
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

    case "pricings":
        require_once "app_rec/pricings.php";
        break;

    case "cal-price":
        require_once "app_rec/calPrice.php";
        break;

    case "verification_process":
        require_once "app_rec/verification_process.php";
        break;

    case "tnc":
        require_once "app_rec/tnc.php";
        break;

    case "FAQ":
        require_once "app_rec/faq.php";
        break;

    case "mysr":
        require_once "app_rec/get_sr_by_mobile.php";
        break;

    case "cem_mysr":
        require_once "app_rec/get_sr_by_cem_id.php";
        break;

    case "bills":
        require_once "app_rec/bills.php";
        break;

    case "payment":
        require_once "app_rec/payment.php";
        break;

    case "account":
        require_once "app_rec/account.php";
        break;

    case "ratings":
        require_once "app_rec/updateRating.php";
        break;
    case "get-score":
        require_once "app_rec/getScore.php";
        break;

    default:
        internalServerError("Error description: " . json_encode($_SERVER));
        die();

        break;
}
