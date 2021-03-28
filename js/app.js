// document.getElementById('loginform').addEventListener('submit', function(e) {fetchlogin(e)});
document.getElementById('registerform').addEventListener('submit', function(e) {registerCheck(e)});
document.getElementById('categoryform').addEventListener('submit', function(e) {categoryList(e)});
// document.getElementById('linkisloggedin').addEventListener('click', function(e) {checkloggedin(e)});
document.getElementById('update_cat_form').addEventListener('submit', function(e) {updateCatList(e)});
// document.getElementById('getOrdersinfo').addEventListener('click', function(e) {getOrdersinfo(e)});


// Sign in part 
// function signinButton() {
//     var formData = new FormData(document.forms.signin_content);
//     formData.append('username', loginuser.value);
//     formData.append('password', loginuser.pass);
//     fetch('http://localhost/match/api/api.php?action=login',
//         {
//             method: 'POST',
//             body: formData,
//             credentials: 'include'
//         })
//         .then(function (headers) {
//             // if login failed
//             if (headers.status == 401) {
//                 console.log('login failed');
//                 localStorage.removeItem('csrf');
//                 localStorage.removeItem('uname');

//                 alert('your login has been failed')
//                 return;
//             }
//             if (headers.status == 203) {
//                 console.log('registration required');
//                 // only need csrf
//             }
//             headers.json().then(function (body) {
//                 // BUG is this a 203 or 200?
//                 localStorage.setItem('csrf', body.Hash);
//                 localStorage.setItem('uname', loginuser.value);
//             })
//         })
//         .catch(function (error) {
//             console.log(error)
//         });
// }


//*****************************************************
// Register part1 check & create user info starts(POST)
//*****************************************************
    function registerCheck(evt) {
    evt.preventDefault();

    var fd = new FormData(registerform);
    
    fetch('http://localhost/match/api/api.php?action=checkaccount',
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function (headers) {
        if (headers.status == 400) {
            alert("Error");
            return;
        }else if (headers.status == 200) {
            // user does not exist
            console.log('you return 200!!!');
            document.getElementById('register_content').setAttribute("hidden", "hidden");
            document.getElementById('reg_category').removeAttribute("hidden");
            return;
        }
    })
    .catch(error => console.log(error));
        }

    //**********************************************
    // Register part1 check & create user info ends
    //**********************************************
   //***************************************************
    // Register part2 Creating category list starts(POST)
    //***************************************************
     
    function categoryList(evt){
    evt.preventDefault();
    // console.log(document.querySelectorAll('input[name="cat[]"]:checked'));
    var categories = document.querySelectorAll('input[name="cat[]"]:checked');
    var items = Array();
    categories.forEach(item => items.push(item.value));
    var fd = new FormData();
    fd.append('categories', items);
    // console.log(fd);

    fetch('http://localhost/match/api/api.php?action=createcate',
    {
        method: 'POST',
        body:fd,
        credentials: 'include'
    })
    .then(function (headers) {
             if (headers.status == 400) {
                alert('Error');
                 return;
               }else if (headers.status == 200) {

                document.getElementById('reg_category').setAttribute("hidden", "hidden");
                document.getElementById('categylist').removeAttribute("hidden");
                return;
                 }
              })
    }

   //**********************************************
    // Register part2 Creating category list ends 
    //*********************************************
  
  //********************************************
  // Update user category list starts (POST)
  //********************************************

    function updateCatList(evt) {
        evt.preventDefault();
        var categories = document.querySelectorAll('input[name="cat2[]"]:checked');
        var items = Array();
        categories.forEach(item => items.push(item.value));
        var fd = new FormData();
        fd.append('ud_categories', items);

        fetch('http://localhost/match/api/api.php?action=updatecat', 
        {
            method: 'POST',
            body: fd,
            credentials: 'include'            
        })
        .then(function (headers) {
            if (headers.status == 400) {
               alert('Error');
                return;
              }else if (headers.status == 200) {

               return;
                }
             })
   }

  //********************************************
  // Update user category list ends 
  //********************************************


   //********************************************
    // Add cart starts (POST)
    //********************************************

  
    function addCart(evt) {
        evt.preventDefault();
        var fd = new FormData();
        fd.append('products', itemName);

        fetch('http://localhost/match/api/api.php?action=addcart', 
        {
            method: 'POST',
            body: fd,
            credentials: 'include'            
        })
        .then(function (headers) {
            if (headers.status == 400) {
               alert('Error');
                return;
              }else if (headers.status == 200) {

               return;
                }
             })
   }

     //********************************************
    // Add cart ends
    //********************************************

     //********************************************
    // Remove product info in a cart starts (POST)
    //********************************************

    function removeProduct(evt) {
        evt.preventDefault();
        var fd = new FormData();
        fd.append('products', itemName);

        fetch('http://localhost/match/api/api.php?action=removeproduct', 
        {
            method: 'POST',
            body: fd,
            credentials: 'include'            
        })
        .then(function (headers) {
            if (headers.status == 400) {
               alert('Error');
                return;
              }else if (headers.status == 200) {
               return;
                }
             })
   }

    //********************************************
    // Remove product info in a cart starts (POST)
    //********************************************

        // ↑ ↑ ↑  POST Method  ↑ ↑ ↑
       // ↓ ↓ ↓  Get Method ↓ ↓ ↓


    //******************************************
    // Managing Product information starts(GET)
    //******************************************   

    function getOrdersinfo(evt) {
            fetch('http://localhost/match/app/api.php?action=getOrdersForUser', 
            {
                method: 'GET',
                credentials: 'include'
            })
            .then(function (headers) {
                if (headers.status == 400) {
                alert('Error');
                    return;
                }else if (headers.status == 200) {
                // put js function to show order info
                return;
                    }
                })
        }

    //*************************************
     // Managing Product information ends 
    //************************************* 

   //**********************************************
 // Displaying products by category list starts(GET)
  //***********************************************
    function showProduct(evt) {
        fetch('http://localhost/match/app/api.php?action=showproduct', 
        {
            method: 'GET',
            credentials: 'include'
        })
        .then(function (headers) {
            if (headers.status == 400) {
            alert('Error');
                return;
            }else if (headers.status == 200) {
            //  put js function to show product info
            return;
                }
            })
    }
    //***************************************** 
    // Displaying products by category list ends
    //******************************************

    //**********************************
    // checking loggedin starts(GET)
    //**********************************
    function checkloggedin(evt) {
    fetch('http://localhost/match/app/api.php?action=isLoggedin', 
    {
        method: 'GET',
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 403) {
            console.log('not logged in');
            localStorage.removeItem('categorylist');
            localStorage.removeItem('cart');
            return;
        }
        headers.json().then(function(body) {
            localStorage.setItem('csrf', body.Hash);
        })
    })
    .catch(error => console.log(error));
}

    //**********************************
    // checking loggedin ends
    //**********************************

     //**********************************
    // Logout starts(GET)
    //**********************************

    function fetchlogout(evt) {
    fetch('localhost/api/api.php?action=logout',
        {
            method: 'GET',
            credentials: 'include'
        })
        .then(function (headers) {
            if (headers.status != 200) {
                console.log('logout failed Server-Side, but make client login again');
            }
            localStorage.removeItem('csrf');
            localStorage.removeItem('uname');
        })
        .catch(error => console.log(error));
}
    //**********************************
    // Logout ends
    //**********************************
