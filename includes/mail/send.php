<?php
//ini_set('display_errors',1);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=UTF-8');

$result = [];
$visitor_name ='';
$visitor_email ='';
$visitor_message ='';
$firstnameErr = '';
$firstnameErr = '';
$emailErr = '';
$lastnameErr = '';
$messageErr = '';

//1.check the submission out -> validate the data
//$results =$_POST;

if(isset($_POST['firstname'])){
    $visitor_name= filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    if (empty($_POST['firstname'])) {
        $firstnameErr = "Name is required";
      } else {
        $visitor_name = test_input($_POST['firstname']);
      }
}
if(isset($_POST['lastname'])){
    $visitor_name .= ' '.filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
}
if(isset($_POST['email'])){
    $visitor_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
}

if(isset($_POST['message'])){
    $visitor_message = filter_var(htmlspecialchars($_POST['message']), FILTER_SANITIZE_STRING);
}

if (empty($_POST['firstname'])) {
    $firstnameErr = "Name is required";
  } else {
    $visitorname = test_input($_POST["name"]);
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
  }


$results['name'] = $visitor_name;
$results['message'] = $visitor_message;

//2.prepare the email

$email_subject = 'Inquary from Portfolio Site';
$email_recipient = 'viktoriiatyshchuk@gmail.com';
$email_message = sprintf('Name: %s, Email: %s, Message: %s', $visitor_name, $visitor_email, $visitor_message);


$email_headers = array(
    'From'=>"viktoriiatyshchuk@viktoriiatyshchuk.com",
    'Reply-To'=> $visitor_email,

    'From'=>$visitor_email

);

//3. send out the email

$email_result= mail($email_recipient, $email_subject, $email_message, $email_headers);
if($email_result){
    $results['message'] = sprintf('Thank you for contacting us, %s! ', $visitor_name);
}else{
    $results['message'] = sprintf('We are sorry but the email did not go through.');
}




echo json_encode($results);