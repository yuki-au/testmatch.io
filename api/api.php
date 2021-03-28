<?php
require('vendor/autoload.php');
require('db.php');
require('se.php');

$sqsdb = new sqsModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load('.env');

$request = Request::createFromGlobals();
$response = new Response();
$session = new Session(new NativeSessionStorage(), new AttributeBag());

$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Origin', getenv('ORIGIN'));
$response->headers->set('Access-Control-Allow-Credentials', 'true');

$session->start();

if(!$session->has('sessionObj')) {
    $session->set('sessionObj', new sqsSession);
}     

if($session->get('sessionObj')->is_rate_limited()) {
    $response->setStatusCode(429);
}

   
if($request->getMethod() == 'POST') {   

     //****************************************************
    // Register part1 check & create user info starts(POST)
    //******************************************************

    if(empty($request->request->get('username_register'))||empty($request->request->get('password_register'))||empty($request->request->get('repassword_register'))) {
        $response->setStatusCode(400);
    }else{
        if($request->query->getAlpha('action') == 'checkaccount') {
            if($request->request->has('username_register') and
                $request->request->has('password_register')) {
                $res = $sqsdb->checkUser($request->request->get('username_register'),$request->request->get('password_register'));
                    if($res == false) {
                        // user exists
                        echo ('passing value is fail');
                        $response->setStatusCode(400);
                    } else {
                        // if user doesn't exist, create new user & save data in the sessin
                        $session->get('sessionObj')->register($res);
                        $request->request->get('password_register');
                        $response->setStatusCode(200);
                        $response->setContent(json_encode($res));
                    }
                }
            } else
                    $response->setStatusCode(400);   
    }                                       

    //*********************************************
   // Register part1 check & create user info ends
    //*********************************************
     //***************************************************
    // Register part2 Creating category list starts(POST)
    //***************************************************

    if($request->query->getAlpha('action') == 'createcate') {
        if($request->request->get('categories')){
            $res = $sqsdb->creteList($request->request->get('categories'),
            $session->get('sessionObj')->returnUser());
            
            if($res == false) {
                // creating list is fail
                $response->setStatusCode(400);
            } else {
                $session->get('sessionObj')->categorylist($res);
                $response->setStatusCode(200);
                $response->setContent(json_encode($res));
            }

        } else {
            echo('error, but might has values');
            $response->setStatusCode(400);
        }          
    }

    //**********************************************
    // Register part2 Creating category list ends 
    //*********************************************
    //********************************************
    // Update user category list starts (POST)
    //********************************************

    if($request->query->getAlpha('action') == 'updatecat') {
        if($request->request->get('ud_categories')){
            $res = $sqsdb->updateCatList(
            $session->get('sessionObj')->returnUser(),
            $request->request->get('ud_categories'),);
            
            if($res == false) {
                // Updating category list fail
                $response->setStatusCode(400);
            } else {
                $session->get('sessionObj')->updatelist($res);
                $response->setStatusCode(200);
                $response->setContent(json_encode($res));
            }
          }      
        }
    
    //********************************************
    // Update user category list ends 
    //********************************************

     //********************************************
    // Add cart starts (POST)
    //********************************************

    if($request->query->getAlpha('action') == 'addcart') {
        if($request->request->get('products')){
            $res = $sqsdb->addCart(
            $session->get('sessionObj')->returnUser(),
            $request->request->get('products'),
            $request->request->get('quantity'));
            
            if($res == false) {
                // Updating category list fail
                $response->setStatusCode(400);
            } else {
                $session->get('sessionObj')->addCart($res);
                $response->setStatusCode(200);
                $response->setContent(json_encode($res));
            }
          }      
        }

     //********************************************
    // Add cart ends
    //********************************************

     //********************************************
    // Remove product info in a cart starts (POST)
    //********************************************
     
    
    if($request->query->getAlpha('action') == 'removeproduct') {
        if($request->request->get('products')){
            $res = $sqsdb->removeCart(
            $session->get('sessionObj')->returnUser(),
            $request->request->get('products'));
            
            if($res == false) {
                // Updating category list fail
                $response->setStatusCode(400);
            } else {
                $session->get('sessionObj')->addCart($res);
                $response->setStatusCode(200);
                $response->setContent(json_encode($res));
            }
          }      
        } 

    //********************************************
    // Remove product info in a cart starts (POST)
    //********************************************

}
    
 
        // ↑ ↑ ↑  POST Method  ↑ ↑ ↑
        // ↓ ↓ ↓  Get Method ↓ ↓ ↓


if($request->getMethod() == 'GET') {  

    //******************************************
     // Managing Product information starts(GET)
    //******************************************   
 
    if($request->query->getAlpha('action') == 'getOrdersForUser') {
        $rows = $sqsdb->getOrdersForUser($session->get('sessionObj')->returnUser());
        if (count($rows) > 0) {
            $response->setStatusCode(200);
            $response->setContent($rows); 
            // save content in se.php↑
        } else {
            $response->setStatusCode(203);
        }
    }

    //*************************************
     // Managing Product information ends 
    //************************************* 

    //**********************************************
   // Displaying products by category list starts(GET)
   //***********************************************
    if($request->query->getAlpha('action') == 'showproduct') {
 
        $rows = $sqsdb->showProducts($session->get('sessionObj')->returnUser());

        if ($rows == true) {
            $response->setStatusCode(200);
            $response->setContent($rows); 
            // save content in se.php↑
        } else {
            $response->setStatusCode(203);
        }
    }

    //***************************************** 
    // Displaying products by category list ends
    //******************************************
   
    //**********************************
    // checking loggedin starts(GET)
    //**********************************

    if ($request->query->getAlpha('action')=='isLoggedin'){
        $check = $session->get('sessionObj')->isLoggedIn();

        if ($check == true) {
            $response->setContent($session->get('sessionObj')->returnUser());
            $response->setStatusCode(200);
        }  else {
            $response->setStatusCode(401);   
        }  
    }    

     
    //**********************************
    // checking loggedin ends
    //**********************************

     
    //**********************************
    // Logout starts(GET)
    //**********************************

    if($request->query->getAlpha('action') == 'logout') {
        $session->get('sessionObj')->logout();
        $response->setStatusCode(200);     
    }

    //**********************************
    // Logout ends
    //**********************************
}

$response->send();

?>
