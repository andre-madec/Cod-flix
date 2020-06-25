<?php

session_start();

require_once( 'model/user.php' );


/*connexion*/

// if(empty($_POST)){
//   extract($_POST);
//   $valid = true;

//   $Email = htmlspecialchars(trim($Email));
//   $Password = trim($Password);

//   if(empty($Email)){
//     $valid = false;
//     $error_email = "Veuillez renseigner une adresse email !";
//   }

//   if(empty($Password)){
//     $valid = false;
//     $error_password = "Veuillez renseigner un mot de passe !";
//   }

//   $req = $DB->query('Select email from user where email = :email and password = :password', array('email' => $Email, 'password' => crypt($Password, 's234ghjkfkr6437cdjne')));
//   $req = $req->fetch();

//   if(!$req['email']){
//     $valid = false;
//     $error_msg = "Votre email ou mot de passe ne correspond pas";
//   }

  


// }

/****************************
* ----- LOAD LOGIN PAGE -----
****************************/

function loginPage() {

  $user     = new stdClass();
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( !$user->id ):
    require('view/auth/loginView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- LOGIN FUNCTION -----
***************************/

function login( $post ) {

  $data           = new stdClass();
  $data->email    = $post['email'];
  $data->password = $post['password'];

  $user           = new User( $data );
  $userData       = $user->getUserByEmail();

  $error_msg      = "Email ou mot de passe incorrect";

  if( $userData && sizeof( $userData ) != 0 ):
    if( $user->getPassword() == $userData['password'] ):

      // Set session
      $_SESSION['user_id'] = $userData['id'];

      header( 'location: index.php ');
    endif;
  endif;

  require('view/auth/loginView.php');
}

/****************************
* ----- LOGOUT FUNCTION -----
****************************/

function logout() {
  $_SESSION = array();
  session_destroy();

  header( 'location: index.php' );
}
