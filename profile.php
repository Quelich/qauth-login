<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = '<your_host_name>';
$DATABASE_USER = '<your_user_name>';
$DATABASE_PASS = '<your_password>';
$DATABASE_NAME = '<your_database_name>';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Updating user details
if (isset($_POST['update'])) {
    $userNewName = $_POST['updateUserName'];
    $userNewEmail = $_POST['updateUserEmail'];
    $userNewPassword = $_POST['updateUserPassword']; // hash
    $userNewPhone = $_POST['updateUserPhone'];
    $userNewAddress = $_POST['updateUserAddress'];

    // Checking if the new user details are valid and nonempty
    if (!empty($userNewName) && !empty($userNewEmail) && !empty($userNewPassword) && !empty($userNewPhone) && !empty($userNewAddress)) {
        $loggedInUser = $_SESSION['id'];
        // Prepared statement to update user details
        $stmt = $con->prepare("UPDATE accounts SET username = ?, email = ?, password = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param('sssssi', $userNewName, $userNewEmail, $userNewPassword, $userNewPhone, $userNewAddress , $loggedInUser);
        $stmt->execute();
        
        // Inform user that their details have been updated
        if ( $stmt->store_result()) {
            echo 'Your profile has been successfully updated")';
        } else {
            echo 'Something went wrong!';
        }
        $stmt->close();
    }
}
// In this case we can use the account ID to get the account info.
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Yup Buddy</h1>
                <a href="home.php">Home</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
        <h2>Update Your Information</h2>
        <p>
            You can also input your personal information if you have none.
        </p>
        <div class="col-md-6 offset-3" align="center">
            <form
                method="POST"
                enctype="multipart/form-data"
            >
                <?php
                    $currentUser = $_SESSION['id'];
                    $sql = "SELECT * FROM accounts WHERE id = '$currentUser'";
                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row= mysqli_fetch_assoc($result)) {
                                //print_r($row['username']);
                                ?>
                                    <div class="form-group">
                                        <label for="userName">Username</label>
                                        <input type="text" fname="userName" name="updateUserName" class="form-control" value="<?php echo $row['username']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="userPassword">Password</label>
                                        <input type="text" fname="userPassword" name="updateUserPassword" class="form-control" value="<?php echo $row['password']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="userEmail">Email</label>
                                        <input type="email" fname="userEmail" name="updateUserEmail" class="form-control" value="<?php echo $row['email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="userPhone">Phone</label>
                                        <input type="text" fname="userPhone" name="updateUserPhone" class="form-control" value="<?php echo $row['phone']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="userAddress">Address</label>
                                        <input  type="text" fname="userAddress" name="updateUserAddress" class="form-control" value="<?php echo $row['address']; ?>">
                                    </div>
                                    <div class="form-group">
                                         <input type="submit" name="update" class="btn btn-info" value="Update">
                                    </div>
                                <?php
                            }
                        }
                    }
                ?>
                </div>
		</div>
	</body>
</html>