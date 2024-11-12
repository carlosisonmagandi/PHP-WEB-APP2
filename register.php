<?php 
require_once("includes/db_connection.php");
require_once("templates/alert-message.php");

if(isset($_POST['submit'])){
    $full_name=$_POST['full_name'];
    $confirmPassword = $_POST['confirmPassword'];
    $password = $_POST['password'];
    $userName = $_POST['userName'];
    $question1=$_POST['answerText1Name'];
    $question2=$_POST['answerText2Name'];
    $questionInput1=$_POST['inputAnswer1'];
    $questionInput2=$_POST['inputAnswer2'];

    // Function to check if the password meets the specified criteria
    function validatePassword($password) {
        return (strlen($password) >= 5 && preg_match('/\d/', $password) && preg_match('/[A-Z]/', $password) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password));
    }

    if ($password == $confirmPassword) {
        if (validatePassword($password)) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $queryCheck = "SELECT * FROM account WHERE username = '$userName'";
            $resultCheck = mysqli_query($connection, $queryCheck);
            if (mysqli_num_rows($resultCheck) > 0) {
                showAlertMsg("Username already exists. Please choose a different username.", "danger");
            } else {
                if (($question1 == '' || $question1 == null) || ($question2 == '' || $question2 == null)) {
                    showAlertMsg("Please select your security questions.", "warning");
                } else {
                    $_SESSION['full_name']=$full_name;
                    // Insert the new user if username is not already taken
                    $queryUser = "INSERT INTO account (username, password, role, full_name) VALUES ('$userName', '$hashedPassword', 'Staff' , '$full_name')";
                    $sqlUser = mysqli_query($connection, $queryUser);
                    
                    // Insert Security question
                    include("register-security-question.php"); 
    
                    include("includes/notification.php");
    
                    if (!$sqlUser) {
                        die("Query failed: " . mysqli_error($connection));
                    }
                }
            }
        } else {
            showAlertMsg("Password must be at least 5 characters long and contain at least 1 number, 1 uppercase letter, and 1 special character.", "danger");
        }
    } else {
        showAlertMsg("Password didn't match.", "danger");
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" /> -->
        
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!--Stylesheet-->
    <link rel="stylesheet" href="Styles/register.css">

    <!-- flex style -->
    <style>
        * {
        box-sizing: border-box;
        }

        .flex-container {
        display: flex;
        flex-direction: row;
        padding:10px;
        }

        .flex-item-left {
        
        flex: 50%;
        }

        .flex-item-right {
        border-left:2px solid #e0e0e0;
        padding: 10px;
        flex: 50%;
        }

        /* right container */
        
        .custom-modal {
            width: 30% !important;
            padding-top:10px;
            
            }
      

        /* Responsive layout - makes a one column-layout instead of two-column layout */
        @media (max-width: 800px) {
        .flex-container {
            flex-direction: column;
        }

        .custom-modal {
            width: 90% !important;
            
            }
        .wrapper{
            top:450px
        }
        }
    </style>
    
</head>
<body>
    <div class="wrapper">
        <a style="color:red;font-size:12px;">**Password must contain atleast one number,special character and Uppercase letter.</a>
        <form action="" method="post">
            <div class="flex-container">
                <div class="flex-item-left">
                    <div class="container" style="padding: 10px;">
                        <input type="text" id="full_name" name="full_name" placeholder="Full Name" style="margin-top:10px" required >
                        <input required type="text" id="userName" name="userName" placeholder="User Name" style="margin-top:10px" 
                            <?php //Set the value of username to username field event the browser reloads
                                if(isset($_POST['userName'])){
                                    if (
                                        ($password != $confirmPassword)||
                                        ($question1==''||$question1==null)||
                                        ($question2==''||$question2==null)
                                        ) { 
                                        echo 'value="' . htmlspecialchars($userName) . '"'; 
                                    } 
                                }  
                            ?>
                        ><br><br>
                            <div class="password-wrapper">
                                <input required type="password" id="password" name="password" oninput="strengthChecker()" placeholder="Password" 
                                    <?php //Set the value of password to username field event the browser reloads
                                        if(isset($_POST['password'])){
                                            if (($password == $confirmPassword)&&($question1==''||$question1==null)||($question2==''||$question2==null)) { 
                                                echo 'value="' . htmlspecialchars($password) . '"'; 
                                            } 
                                        }  
                                    ?>
                                >
                                <span id="toggle" onclick="toggle()">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <div id="strength-bar"></div>
                            
                            <p id="msg" name='msg'></p>
                            <br>
                            <div class="confirmPassword-wrapper">
                                <input required type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirm Password"
                                    <?php //Set the value of password to username field event the browser reloads
                                        if(isset($_POST['confirmPassword'])){
                                            if (($password == $confirmPassword)&&($question1==''||$question1==null)||($question2==''||$question2==null)) { 
                                                echo 'value="' . htmlspecialchars($confirmPassword) . '"'; 
                                            } 
                                        }  
                                    ?>
                                >

                                <span id="toggle2" onclick="toggle2()">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <br>
                            <input type="submit" name="submit" value="Register" id="registerBtn">
                        
                    </div>
                </div>

                <div class="flex-item-right">
                    <!-- div for question 1 -->
                    <div class="container" style="padding: 10px;">  
                        <div style="border:1px solid black;padding:6px;">
                            <div class="flex-container">
                                <div style="flex-grow: 2"><a>Question #1</a></div>
                                
                                <div style="flex-grow: 8">
                                    <button type="button" class="btn btn-primary" onclick="question(1)">Select a question</button>
                                </div>
                            </div>
                            
                            <p id="answerText1" style="max-width: 100%; word-wrap: break-word;color:gray;font-size:10px;text-align:left" >
                            <?php 
                                if(isset($_POST['password'])){
                                    if ((($password != $confirmPassword) && ($question1 != $question2))||(($question1 == '')||($question2 == ''))) { 
                                        echo htmlspecialchars($question1); 
                                    } 
                                }  
                            ?>
                            </p>
                            <div class="form-group">
                                <input required type="text" class="form-control" name="inputAnswer1" placeholder="Answer...." id="inputAnswer1Id"  >
                            </div>
                            <input type="hidden" name="answerText1Name" id="hiddenAnswerText1">
                        </div>

                    </div>
                    <!-- div for question 2 -->
                    <div class="container" style="padding: 10px;">  
                        <div style="border:1px solid black;padding:6px;">
                            <div class="flex-container">
                                <div style="flex-grow: 2"><a>Question #2</a></div>
                                
                                <div style="flex-grow: 8">
                                    <button type="button" class="btn btn-primary" onclick="question(2)">Select a question</button>
                                </div>
                            </div>
                            
                            <p id="answerText2" style="max-width: 100%; word-wrap: break-word;color:gray;font-size:10px;text-align:left">
                            <?php 
                                if(isset($_POST['password'])){
                                    if ((($password != $confirmPassword) && ($question1 != $question2))||(($question1 == '')||($question2 == ''))) { 
                                        echo htmlspecialchars($question2); 
                                    } 
                                }  
                            ?> 
                            </p>
                            <div class="form-group">
                                <input required type="text" class="form-control" name="inputAnswer2" placeholder="Answer...." id="inputAnswer2Id" >
                            </div>
                            <input type="hidden" name="answerText2Name" id="hiddenAnswerText2">
                        </div>  
                    </div>
                </div>
            </div>
        </form>
        
        <div class="card-footer text-center py-3">
            <div class="small"><br><a href="/index.php" style="color:blue;">Already have an account? Sign in!</a></div>            
        </div>
    </div>
    <!--Script-->
    <script src="Javascript/passwordChecker.js"></script>
    
    <!-- <script>

        $(document).ready(function(){
            $("#registerBtn").click(function(){

                var userName = $("#userName").val();
                var password= $("#password").val();
                var confirmPassword= $("#confirmPassword").val();

                if(password===confirmPassword){
                    $.ajax({
                        url: 'includes/notification.php', // URL where your PHP script is located
                        type: 'POST',
                        data: {
                            title: "Account Registration",
                            status: "unseen",
                            landing_page: "Pages/admin/manageAccount.php",
                            username: userName, 
                            
                        },
                        success: function(response){
                            // Handle success response
                            
                            alert(response); // You can replace this with any other action you want
                            
                        },
                        error: function(xhr, status, error){
                            // Handle error
                            console.log(error);
                        }
                    });
                }else{
                    // Passwords don't match, retain input values
                    $("#password").val(password);
                    $("#confirmPassword").val(confirmPassword);
                    
                }    
            });
        });
    </script> -->

<script>
    // validation to security questions  
    document.querySelector('form').addEventListener('submit', function(event) {
        var answerText1 = document.getElementById('answerText1').textContent.trim();
        var answerText2 = document.getElementById('answerText2').textContent.trim();
        document.getElementById('hiddenAnswerText1').value = answerText1;
        document.getElementById('hiddenAnswerText2').value = answerText2;
        
        if(answerText1!='' && answerText2!=''){ 
            if (answerText1 === answerText2) {
                alert("Answers to security questions must be different.");
                event.preventDefault(); // Prevent form submission
            }
        }
    });
    //------------ 
       function question(questionNumber) {
    Swal.fire({
        html: `<?php include("register-questions.php"); ?>`,
        customClass: {
            popup: 'custom-modal'
        },
        showConfirmButton: false,
        showCloseButton: true,
    });

    // Event delegation: Event listener to the table body
    getTdValue(questionNumber);

    function attachClickListener(tableBodyId, answerTextID) {
        document.getElementById(tableBodyId).addEventListener('click', (event) => {
            if (event.target.tagName === 'TD') {
                const clickedValue = event.target.textContent;
                event.target.classList.add('selected-td');
                document.getElementById(answerTextID).textContent = clickedValue;
                Swal.close();
            }
        });
    }

    function getTdValue(questionNumber) {
        const answerTextID = 'answerText' + questionNumber;
        
        attachClickListener('personalTableBody', answerTextID);
        attachClickListener('hobbyTableBody', answerTextID);
        attachClickListener('schoolTableBody', answerTextID);
        attachClickListener('workTableBody', answerTextID);
        attachClickListener('familyTableBody', answerTextID);
        attachClickListener('favoriteTableBody', answerTextID);
    }

}

</script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/Javascript/sb-admin/sb-admin-script.js"></script>
</body>
</html>
