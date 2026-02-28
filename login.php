<!DOCTYPE html>
<html>
	<head>
		<titke>Login Page</titke>
		</head> 
		<body>
			<h2>Login Page</h2>
		<form method="POST">
			Username: <input type="text" name = "username" required><br><br> 
			Password: <input type="password" name = "password" required><br><br> 
			<button type = "submit">Login</button>
		</form>

		<?php
			$conn = new mysqli("localhost", "root", "", "socialMediaDB");
			
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$message = ""; 

			if($_SERVER['REQUEST_METHOD']=="POST"){
				$username = $_POST['username'];
				$password = $_POST['password'];

				$stmt = $conn->prepare("Select password From Users Where username = ?");
				$stmt-> bind_param("s", $username);
				$stmt-> execute();

				$result = $stmt->get_result(); 

				if($result->num_rows>0) {

					$row = $result->fetch_assoc();
					$hashedPassword = $row['password'];

					//verify password
					if (password_verify($password, $hashedPassword)) {
						$message = "Login Successful";
					} else {
						$message = "Login Unsuccessful";
					}
				} else {
					$message = "Login Unsuccessful";
				}

				$stmt-> close();
			}
		$conn->close();
		?>
		
		<p style= "color:red;">
			<?php echo $message; ?>
			</p>			
		
		</body>	
</html>