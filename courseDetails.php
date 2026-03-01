<!DOCTYPE html>
<html>
<head>
	<title> Student Course Details</title>
</head>
<body>
	<h2> Student Course Details </h2>

	<form mehod = "post">
		<button type= "submit" name = "showdata"> Show All Students</button>
	</form>

	<?php
	if (isset($_POST['showData'])) {
		// database connection
		$conn = new mysqli("localhost", "root", "", "OnlineCourseDB");

		if ($conn-> connection_error) {
			die ("Connection failed: " . $conn->connect_error);
		}

		// Natural Join
		$sql_natural_join = "Select * From Students Natural Join Submissions";
		$result = $conn->query($sql_natural_join);
		echo "<h3>Natural Join:</h3>";
		if($result->num_rows > 0) {
			echo "<table border='1'>
					<tr>
						<th>Student ID</th>
						<th>Name</th>
						<th>Major</th>
						<th>Submissions ID</th>
						<th>Score</th>
					</tr>";
			while ($row = $result-> fetch_assoc()) {
				echo "<tr>
						<td>{$row['student_id']}</td>
						<td>{$row['name']}</td>
						<td>{$row['major']}</td>
						<td>{$row['submission_id']}</td>
						<td>{$row['score']}</td>
					</tr>";
			}
			echo "</table>";
		}

		// Inner Join
		$sql_inner_join = "Select Students.name, Students.major, Submissions.score From Students Inner Join Submissions On Students.student_id = Submissions.student_id";
		$result = $conn-> query($sql_inner_join);
		echo "<h3> Inner Join:</h3>";
		if ($result->num_rows > 0) {
			echo "<table border='1'>
					<tr>
						<th>Name</th>
						<th>Major</th>
						<th>Score</th>
					</th>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr>
						<td>{$row['name']}</td>
						<td>{$row['major']}</td>
						<td>{$row['score']}</td>
					</tr>";
			}
			echo "</table>";
		} 

		// Left Outer Join
		$sql_left_outer_join = "Select Students.name, Submission.score From Students Left Outer Join Submissions ON Students.student_id = Submissions.student_id";
		$results = $conn-> query($sql_left_outer_join);
		echo "<h3>Left Outer Join:</h3>";
		if ($result->num_rows > 0) {
			echo "<table border='1'>
				<tr>
					<th>Name</th>
					<th>Score</th>
				</tr>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr> 
						<td>{$row['name']}</td>
						<td>{$row['score']}</td>
					</tr>";
			}
			echo "</table>";
		}

		// Right Outer Join
		$sql_right_outer_join = "Select Students.name, Submissions.score From Students Right Outer Join Submussions ON Students.student_id = Submissions.student_id";
		$result = $conn-> query($sql_right_outer_join);
		echo "<h3>Right Outer Join:</h3>"
		if ($result->num_rows > 0) {
			echo "<table border = '1'>
				<tr>
					<th>Name</th>
					<th>Score</th>
				</tr>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr>
							<td>{$row['name']}</td>
							<td>{$row['score']}</td>
						</tr>";
			}
			echo "</table>";
		}		

		// Full Outer Join 
		$sql_full_outer_join = "Select Students.name, Submissions.score From Students Left Outer Join Submissions ON Students.student_id = Submissions.student_id UNION Select Students.name, Submissions.score From Students Right Outer Join Submissions on Students.student_id = Submissions.student_id";
		$result = $conn-> query($sql_full_outer_join);
		echo "<h3>Full Outer Join:</h3>";
		if ($result->num_rows > 0) {
			echo "<table border = '1'> 
				<tr>
					<th>Name</th>
					<th>Score</th>
				</tr>";
			while ($row = $result-> fetch_assoc()) {
				echo "<tr>
							<td>{$row['name']}</td>
							<td>{$row['score']}</td>
						</tr>";
			}
			echo "</table>";
		}

		$conn->close();
	}
	?>
</body>
</html>