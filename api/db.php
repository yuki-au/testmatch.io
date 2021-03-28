<?php


    class sqsModel {

        private $dbconn;

        public function __construct() {
            $dbURI = 'mysql:host='. 'localhost'.';port=3308;dbname='.'match';
            $this->dbconn = new PDO($dbURI, 'admin', 'test123');
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
 
    //****************************************************
    // Register part1 check & create user info starts(POST)
    //******************************************************      
     function checkUser($u,$p) {
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':username', $u, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) { 
                // if user exists
                echo('use exist');
                return false;
                exit();
            } else {
                // if user doesn't exist, create user info in user db
                $sql2 = "INSERT INTO user(username, password) VALUE(:username,:password)";
                $stmt2 = $this->dbconn->prepare($sql2);
                $stmt2->bindParam(':username', $u, PDO::PARAM_STR);
                $stmt2->bindParam(':password', $p, PDO::PARAM_STR);
                $res2 = $stmt2->execute();
               
                 $userid = $this->dbconn->lastinsertid(); 
                if($res2 == true) {     
                    return $userid;    
                }else {
                    echo('error, last id is undifined');
                    return false;
                }
              }  
         }

    //*********************************************
   // Register part1 check & create user info ends
    //*********************************************
     //***************************************************
    // Register part2 Creating category list starts(POST)
    //***************************************************

         function creteList($c, $u) { 
           $cats = explode(",", $c);
           if (is_array($cats)){                  
               for($i = 0; $i<count($cats) ; $i = $i + 1){       
               // print_r(gettype($cats[$i]));
                 $sql ="INSERT INTO usercategory(categoryID, userID) VALUE(:catid,:usid)";
                 $stmt = $this->dbconn->prepare($sql);
                 $stmt->bindParam(':catid',intval($cats[$i]), PDO::PARAM_INT);
                 $stmt->bindParam(':usid',intval($u), PDO::PARAM_INT);
                 $res=$stmt->execute();
    
                   if($res == false){
                       echo('loop false');
                      return false;
                   }
                }

                 return $cats;

                }else{
                    return false;
                }     
            }     

    //**********************************************
    // Register part2 Creating category list ends 
    //*********************************************
    //********************************************
     // Update user category list starts (POST)
     //********************************************
        function updateCatList($u, $ud_c) { 
                $sql ="SELECT * FROM usercategory WHERE userID = :usid";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->bindParam(':usid',intval($u), PDO::PARAM_INT);
                $res=$stmt->execute();
                $rows = $stmt->fetchAll();

                $n_cat = explode(",", $ud_c);
            

                    if(count($rows) == count($n_cat)){
                        for($i = 0; $i<count($n_cat) ; $i = $i + 1){       

                        $sql ="UPDATE usercategory SET categoryID = :catid WHERE userID = :usid";
                        $stmt = $this->dbconn->prepare($sql);
                        $stmt->bindParam(':catid',intval($n_cat[$i]), PDO::PARAM_INT);
                        $stmt->bindParam(':usid',intval($u), PDO::PARAM_INT);
                        $res=$stmt->execute();
            
                            if($res == false){
                                echo('loop false');
                            return false;
                            }
                        }

                       
                        return true;
                
                  }else if(count($rows) >= count($n_cat) || (count($rows) <= count($n_cat))){
                    //  recreate the category list
                        $sql ="DELETE FROM usercategory WHERE userID = :usid";
                        $stmt = $this->dbconn->prepare($sql);
                        $stmt->bindParam(':usid',intval($u), PDO::PARAM_INT);
                        $res=$stmt->execute();

                             if($res==true){
                                for($i = 0; $i < count($n_cat) ; $i = $i + 1){      
                                    $sql2 ="INSERT INTO usercategory(categoryID, userID) VALUE(:catid,:usid)";
                                    $stmt2 = $this->dbconn->prepare($sql2);
                                    $stmt2->bindParam(':catid',intval($n_cat[$i]), PDO::PARAM_INT);
                                    $stmt2->bindParam(':usid',intval($u), PDO::PARAM_INT);
                                     $res2=$stmt2->execute();
    
                                     if($res2 == false){
                                      echo('loop false');
                                      return false;
                                     }

                                     }
                                    
                                      return $n_cat;

                            }else{
                                echo('fail to delete and update');
                                return false; 
                            }
                        } 
                     
                }
                       
    //********************************************
    // Update user category list ends 
    //********************************************


    //********************************************
    // Add cart starts (POST)
    //********************************************
       
    function addCart($u, $pro, $quantity) { 
        // fetch product id and retrieve it
        $sql ="SELECT * FROM product WHERE productID = :proid";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':proid', $pro, PDO::PARAM_INT);
        $res=$stmt->execute();
        if($res == true){
             // create cart table with user id (cartid auto incremented)
            $sql2 ="INSERT INTO cart(userID) VALUE(:usid)";
            $stmt2 = $this->dbconn->prepare($sql2);
            $stmt2->bindParam(':usid',intval($u), PDO::PARAM_INT);
            $res2=$stmt2->execute();

            $cartid = $this->dbconn->lastinsertid(); 
         if($res2 == true){
              $sql3 ="INSERT INTO cartproduct (cartID, productID, quantity) 
              VALUES (:cid, :proID, :quantity)";
              $stmt3 = $this->dbconn->prepare($sql3);
              $stmt3->bindParam(':cid',$cartid, PDO::PARAM_INT);
              $stmt3->bindParam(':proID',$pro, PDO::PARAM_INT);
              $stmt3->bindParam(':quantity',$quantity, PDO::PARAM_INT);
              $res3=$stmt->execute();
                 
              return true;
            } else{
                 return false;
             }     
         } else{
            echo('no such a product info');
            return false;
        }        
    
        }

    //********************************************
    // Add cart ends
    //********************************************

    //********************************************
    // Remove product info in a cart starts (POST)
    //********************************************
     
    function removeCart($u, $pro) { 
        // fetch product id and retrieve it
        $sql ="DELETE FROM cart  WHERE userID = :usid";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':usid',intval($u), PDO::PARAM_INT);
        $res=$stmt->execute();
        
        if($res == true){

         }
        }

    //********************************************
    // Remove product info in a cart starts (POST)
    //********************************************


       // ↑ ↑ ↑  POST Method  ↑ ↑ ↑
       // ↓ ↓ ↓  Get Method ↓ ↓ ↓



    //******************************************
     // Managing Product information starts(GET)
    //******************************************   

        function getOrdersForUser($u){
            $sql = "SELECT * FROM orderdata WHERE userID = :userid";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':userid', $u, PDO::PARAM_INT);
            $result = $stmt->execute();
            $rows = $stmt->fetchAll();
                if($result === true) {  
                    return $rows;
                } else {
                    return false;
                }
            }
     //*************************************
     // Managing Product information ends 
    //************************************* 

    //**********************************************
   // Displaying products by category list starts(GET)
   //***********************************************
        function showProducts($u) {
            $sql = "SELECT product.productID, product.productName, product.categoryID, 
            category.categoryID FROM product JOIN category 
            ON product.categoryID = category.categoryID 
            RIGHT JOIN usercategory ON category.categoryID = usercategory.categoryID WHERE userID = :usid";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':usid', $cats, PDO::PARAM_INT);
            $res = $stmt->execute();
           
            if($res === true) {  
                
                return true;
            } else {
                return false;
            }
        }

    //***************************************** 
    // Displaying products by category list ends
    //******************************************

        function logEvent($uid, $url, $resp_code, $source_ip) {
            $sql = "INSERT INTO logtable (url, uid, response_code, ip_addr) 
                VALUES (:url, :uid, :resp_code, :ip);";
            $stmt = $this->$dbconn->prepare($sql);
            $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':resp_code', $resp_code, PDO::PARAM_INT);
            $stmt->bindParam(':ip', $source_ip, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result === true) {
                return true;
            } else {
                return false;
            }
        }
    }
    
?>
