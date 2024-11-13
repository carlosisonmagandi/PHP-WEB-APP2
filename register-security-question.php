<?php
//The variables were set in register.php file 
$querySecurityQuestion = "
    INSERT INTO security_questions (question1, question2, answer1, answer2, account_id)
    VALUES (?, ?, ?, ?, (SELECT id FROM account WHERE username = ? ))
";
$stmt = mysqli_prepare($connection, $querySecurityQuestion);

if ($stmt) {    
    mysqli_stmt_bind_param($stmt, 'sssss', $question1, $question2, $questionInput1, $questionInput2, $userName);
    if (mysqli_stmt_execute($stmt)) {
        // echo "Security questions were successfully added.";
    } else {
        echo "Error executing query: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing query: " . mysqli_error($connection);
}
?>