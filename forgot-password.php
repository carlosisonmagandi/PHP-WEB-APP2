<?php
require_once("includes/db_connection.php");
$response = ['status' => false, 'message' => 'Unknown error occurred'];

if (isset($_POST['userName'])) {
    $userName = $_POST['userName'];

    $question1 = '';
    $question2 = '';
    $answer_1='';
    $answer_2='';

    if ($connection === false) {
        $response['message'] = "ERROR: Could not connect. " . mysqli_connect_error();
    } else {
        // Get account details including ID
        $sql = "SELECT id FROM account WHERE username = ?";
        $stmt = mysqli_prepare($connection, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $accountId = $row['id'];

                    // Get security questions associated with the account
                    $sqlQuestion = "SELECT * FROM security_questions WHERE account_id = ?";
                    $stmtQuestion = mysqli_prepare($connection, $sqlQuestion);

                    if ($stmtQuestion) {
                        mysqli_stmt_bind_param($stmtQuestion, "i", $accountId);
                        mysqli_stmt_execute($stmtQuestion);

                        $resultQuestion = mysqli_stmt_get_result($stmtQuestion);
                        if ($resultQuestion) {
                            if (mysqli_num_rows($resultQuestion) > 0) {
                                $rowQuestion = mysqli_fetch_assoc($resultQuestion);
                                $question1 = $rowQuestion['question1'];
                                $question2 = $rowQuestion['question2'];
                                $answer_1 = strtolower(preg_replace('/\s+/', '', $rowQuestion['answer1'])); 
                                $answer_2 = strtolower(preg_replace('/\s+/', '', $rowQuestion['answer2']));                    
                            }
                        } else {
                            $response['message'] = "Error: " . mysqli_error($connection);
                        }

                        mysqli_stmt_close($stmtQuestion);
                    } else {
                        $response['message'] = "Error: " . mysqli_error($connection);
                    }

                    $response['status'] = true;
                    $response['message'] = 'Success';
                    $response['id'] = $accountId;
                    $response['question1'] = $question1;
                    $response['question2'] = $question2;
                    $response['answer1']=$answer_1;
                    $response['answer2']=$answer_2;   
                } else {
                    $response['message'] = 'No results found';
                }
            } else {
                $response['message'] = "Error: " . mysqli_error($connection);
            }

            mysqli_stmt_close($stmt);
        } else {
            $response['message'] = "Error: " . mysqli_error($connection);
        }

        mysqli_close($connection);
    }

    echo json_encode($response);
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Forgot Password</title>
    <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-image: url('/Images/forgot-password.png');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right bottom;
        }
        .card {
            /*background-color: rgba(255, 255, 255, 0.7);  Adjust the opacity here */
        }
        .btn {
            border: none;
            background-color: #5CAB7D;
            padding-right: 10%;
            padding-left: 10%;
        }
        .btn:hover {
            border: none;
            background-color: #8BD3B3;
            padding-right: 10%;
            padding-left: 10%;
        }
        @media (max-width: 992px) {
            .card {
                background-color: rgba(255, 255, 255, 0.8);  Adjust the opacity here
            }
        }
    </style>
</head>
<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-left">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Forgot Password?</h3>
                                </div>
                                <div class="card-body">
                                    <form id="forgotPasswordForm">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="userName" />
                                            <label for="inputEmail">Please enter your username</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                        </div>
                                        <br>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="/register.php" style="color: blue; float: left">Need an account? Sign up!</a>
                                        <a href="/index.php" style="color: blue; float: right;">Already have an account? Sign in!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include("templates/footer.php"); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        title: 'Data found',
                        // text: `User ID: ${data.id}`,
                        html:`
                
                        <form method="post" id="questionForm" >
                            <label for="id">User ID:</label><br>
                            <input type="hidden" id="id" name="id" value="${data.id}">
                            <a>${data.id}</a>
                            <br><br>

                            <label for="question1">Question 1:</label><br>
                            <input type="hidden" id="question1" name="question1" value="${data.question1}">
                            <a>${data.question1.substring(2)}</a>
                            <input type="text" id="answer1" name="answerInput1" >
                            <br><br>

                            <label for="question2">Question 2:</label><br>
                            <input type="hidden" id="question2" name="question2" value="${data.question2}">
                            <a>${data.question2.substring(2)}</a>
                            <input type="text" id="answer2" name="answerInput2" >
                            <br><br>

                            <input type="button" value="Submit"  onclick="questionClick('${data.id}','${data.answer1}', '${data.answer2}')">
                        </form>
                        `,
                        icon: 'success',
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong!',
                    icon: 'error'
                });
                console.error('Error:', error);
            });
        });


        function questionClick(id,ans1, ans2) {
            const answerInput1 = document.getElementById('answer1').value.toLowerCase().replace(/\s+/g, "");

            const answerInput2 = document.getElementById('answer2').value.toLowerCase().replace(/\s+/g, "");
            if (answerInput1 === ans1 && answerInput2 === ans2) {
            alert('Answers match!');
            // window.location.href = '/forgot-password-reset.php?id=' +id;
            sessionStorage.setItem("forgotPasswordId",id);
            window.location.href = '/forgot-password-reset.php';
            // return true; 
        } else {
            alert('Answers do not match.');
            event.preventDefault(); 
            //return false; 
        }
    }
        
    </script>
</body>
</html>