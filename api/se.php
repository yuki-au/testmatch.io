<?php

    class sqsSession {
        // attributes will be stored in session, but always test incognito
        private int $last_visit = 0;
        private $last_visits = Array();
        private $user_id = 0;
        private $cat_id = 0;
        private $category_id = 0;
        private $cart_id = 0;

        private $user_token;
        private $row;

        private $origin;

        // private $mynameis;

        public function __construct() {
            $this->origin = getenv('ORIGIN');  
        }

       


        // example 
        // public function setMyname($name) {
        //     $this->mynameis = $name;
        // }

        public function is_rate_limited() {
            if($this->last_visit == 0) {
                $this->last_visit = time();
                return false;
            }
            if($this->last_visit == time()) {
                return true;
            }
            return false;
        }

        // comes from register phase
        public function register($u) {
            $this->user_id = $u;    
        }
        
        // used to retrieve last user id
        public function returnUser() {
            return $this->user_id;
        }

        // comes from createcategory phase
        public function categorylist($c){
            $this->cat_id = $c;    
        }

        // return category information

        public function returnCat() {
            return $this->cat_id;
        }

        //  updated catefory information
        public function updatelist($n_cat){
            $this->category_id = $n_cat; 
        }

        // return updated category information

        public function returnUpdateCat() {
            return $this->category_id;
        }

         //  Add item Cart information
         public function addCart($cart){
            $this->cart_id = $cart; 
        }

        // return stored information in a cart

        public function returnCart() {
            return $this->cart_id;
        }

      







        public function isLoggedIn() {
            if($this->user_id === 0) {
                return false;
            } else {
                return true;
            }
        }

        public function logout() {
            $this->user_id = 0;
        }
    }
?>
