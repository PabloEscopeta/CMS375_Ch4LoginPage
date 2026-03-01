<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
		</head> 
		<body>
			<h2>Login Page</h2>
		<form method="Post">
			<label for= "username"> Username: </label>
			<input type="text" name= "username" required><br><br>

			<label for= "password"> Password:</label>
			<input type="password" name="password" required><br><br>

			<button type = "submit" name="login"> Login</button>
		</form>

		<?php
			if (isset($_POST['login'])) {
				// get user input
				$username = $_POST['username'];
				$password = $_POST['password'];

				// Database connection
				$conn = new mysqli("localhost", "root", "", "OnlineCourseDB");

				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				// Query to fetch user records based on username 
				$sql = "Select * From Users Where username = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					$user = $result-> fetch_assoc();
					
					// verify password
					if (password_verify($password, $user['password'])) {
						echo "Login Successful.";
					} else {
						echo "Invalid Password.";
					}
				} else {
					echo "No user found.";
				}

				$ conn-> close();
			}

			// Registration (store hash password)
			if (isset($_POST['register'])) {
				$username = $_POST['username'];
				$password = $_POST['password'];

				// Hash password
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);

				// insert into database
				$conn = new mysqli("localhost", "root", "", "OnlineCourseDB");
				$sql = "Insert Into Users (username, password) Values (?, ?)";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ss", $username, $hashed_password);
				if ($stmt->execute) {
					echo "Registration successful!";
				} else {
					echo "Error: " . $conn-> error;
				}

				$ conn-> close();
			}
		?>
	</body>
</html>
		