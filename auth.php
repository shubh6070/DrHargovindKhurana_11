<?php
session_start();

$conn = mysqli_connect("localhost","root","","hostel_db");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ================= LOGIN ================= */
if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password,$user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            header("Location: student_dashboard.php");
            exit();
        } else {
            $error = "Invalid Password!";
        }

    } else {
        $error = "Account not found!";
    }
}

/* ================= REGISTER ================= */
if(isset($_POST['register'])){

    $name  = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $room  = mysqli_real_escape_string($conn,$_POST['room_number']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        $error = "Email already registered!";
    } else {

        $insert = mysqli_query($conn,"
            INSERT INTO users(name,email,password,phone,room_number)
            VALUES('$name','$email','$password','$phone','$room')
        ");

        if($insert){
            $success = "Registration Successful! Please Login.";
        } else {
            $error = "Database Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Hostel Complaint System</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#1E40AF,#F97316);
}
.container{
    width:380px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(20px);
    padding:30px;
    border-radius:15px;
    color:white;
    box-shadow:0 15px 35px rgba(0,0,0,0.3);
}
h2{text-align:center;margin-bottom:20px;}
input{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:none;
    border-radius:8px;
}
button{
    width:100%;
    padding:10px;
    margin-top:10px;
    border:none;
    border-radius:8px;
    background:#F97316;
    color:white;
    font-weight:bold;
    cursor:pointer;
}
button:hover{background:#EA580C;}
.toggle{
    text-align:center;
    margin-top:15px;
    cursor:pointer;
    font-size:14px;
}
.error{color:#ffcccc;text-align:center;margin-bottom:10px;}
.success{color:#ccffcc;text-align:center;margin-bottom:10px;}
.hidden{display:none;}
</style>

<script>
function showRegister(){
    document.getElementById("loginForm").classList.add("hidden");
    document.getElementById("registerForm").classList.remove("hidden");
}
function showLogin(){
    document.getElementById("registerForm").classList.add("hidden");
    document.getElementById("loginForm").classList.remove("hidden");
}
</script>

</head>
<body>

<div class="container">

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
<?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>

<!-- LOGIN -->
<div id="loginForm">
    <h2>🏨 Student Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <div class="toggle" onclick="showRegister()">New Student? Register</div>
</div>

<!-- REGISTER -->
<div id="registerForm" class="hidden">
    <h2>📝 Student Registration</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phone" placeholder="Phone Number">
        <input type="text" name="room_number" placeholder="Room Number">
        <button type="submit" name="register">Register</button>
    </form>
    <div class="toggle" onclick="showLogin()">Already have account? Login</div>
</div>

</div>
</body>
</html>
