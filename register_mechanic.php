
<!DOCTYPE html>
<html>
<head>
    <title>Register Mechanic</title>
</head>
<body>
    <h2>Register Mechanic</h2>
    <form action="register_mechanic_process.php" method="post">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br>
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br>
        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="speciality">Speciality:</label>
        <input type="text" id="speciality" name="speciality"><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
