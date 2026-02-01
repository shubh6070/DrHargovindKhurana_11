<?php
session_start();
$conn = mysqli_connect("localhost","root","","hostel_db");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");

    if(mysqli_num_rows($query) == 1){

        $admin = mysqli_fetch_assoc($query);

        if(password_verify($password,$admin['password'])){
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Wrong Password!";
        }

    } else {
        $error = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login | Hostel System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#0f172a,#1E40AF);
}

.login-box{
    width:380px;
    padding:35px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(20px);
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,0.4);
    color:white;
}

.login-box h2{
    text-align:center;
    margin-bottom:25px;
    font-size:26px;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:10px;
    font-size:14px;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:10px;
    background:#F97316;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#EA580C;
    transform:scale(1.05);
}

.error{
    text-align:center;
    color:#ffb3b3;
    margin-bottom:10px;
}

.footer-link{
    text-align:center;
    margin-top:15px;
    font-size:14px;
}

.footer-link a{
    color:#F97316;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="login-box">

<h2>🛠 Warden Login</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

<div class="footer-link">
    <a href="index.php">⬅ Back to Home</a>
</div>

</div>

</body>
</html>
