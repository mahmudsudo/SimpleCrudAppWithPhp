<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    $sql= "select * from Students where email ='$email'";
    $result=$conn->query($sql);
    if ($result->num_rows ==0) {
       $res= $conn->query("insert into Students (full_names,country,email,gender,password) VALUES('$fullnames','$country','$email','$gender','$password')");
       if ($res==true){
        echo "User sucessfully registered";
       }
       
    }
    $conn->close();
   //check if user with this email already exist in the database
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
   $res= $conn->query("select email,password from Students where email ='$email'and password ='$password'");
   
    if($res->num_rows>0){
        session_start();
        $_SESSION["username"]=$email;
        header("Location: ../dashboard.php");
    }else{
        header("Location : ../forms/login.html");
    }
   
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
    $conn->close();
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $res = $conn->query("select * from Students where email =".$email);
    if($res->num_rows>0){
        $res=$conn->query("insert into Students (password) values('$password' where email ='$email'");

    }else{
        echo "User does not exist";
    }
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
    $conn->close();
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
    $conn->close();
}

 function deleteaccount($id){
     $conn = db();
     $res=$conn->query("delete from Students where id ='$id'");
     if ($res==true){
        echo "entry deleted successfully";
     }
     $conn->close();
     //delete user with the given id from the database
 }
