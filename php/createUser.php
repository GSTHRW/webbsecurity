<?php


function validate($data){

    $data = trim($data);

    return $data;

} //måste ha fler för andra attacker


function isPasswordStrong($password){

}//olika krav med längd etc


if (isset($_POST['username'])){

    //validate alla parametrar och längdt etc
}else{

    password_hash($data);//för att hasha lösenordet
}