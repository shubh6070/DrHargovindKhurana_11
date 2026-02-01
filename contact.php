<?php
$conn = mysqli_connect("localhost","root","","hostel_db");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

if(isset($_POST['send'])){

    $name    = mysqli_real_escape_string($conn,$_POST['name']);
    $email   = mysqli_real_escape_string($conn,$_POST['email']);
    $subject = mysqli_real_escape_string($conn,$_POST['subject']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    $insert = mysqli_query($conn,"
        INSERT INTO contact_messages(name,email,subject,message)
        VALUES('$name','$email','$subject','$message')
    ");

    if($insert){
        $success = "✅ Message Sent Successfully!";
    } else {
        $error = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Us | Hostel Complaint System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
  --primary:#F97316;
  --secondary:#1E40AF;
}

body{
  margin:0;
  font-family:'Segoe UI';
  background:linear-gradient(135deg,#E2E8F0,#CBD5E1);
}

.container{
  max-width:1000px;
  margin:auto;
  padding:60px 20px;
}

.title{
  text-align:center;
  margin-bottom:40px;
}

.title h1{
  font-size:2.5rem;
  background:linear-gradient(45deg,var(--primary),var(--secondary));
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:30px;
}

.card{
  background:white;
  padding:30px;
  border-radius:20px;
  box-shadow:0 15px 40px rgba(0,0,0,0.1);
}

input, textarea{
  width:100%;
  padding:12px;
  margin:10px 0;
  border-radius:10px;
  border:2px solid #eee;
}

input:focus, textarea:focus{
  outline:none;
  border-color:var(--primary);
}

button{
  width:100%;
  padding:12px;
  border:none;
  border-radius:15px;
  background:linear-gradient(45deg,var(--primary),var(--secondary));
  color:white;
  font-weight:bold;
  cursor:pointer;
}

button:hover{
  opacity:0.9;
}

.success{
  color:green;
  text-align:center;
  margin-bottom:10px;
}

.error{
  color:red;
  text-align:center;
  margin-bottom:10px;
}

@media(max-width:768px){
  .grid{
    grid-template-columns:1fr;
  }
}
</style>
</head>

<body>

<div class="container">

<div class="title">
  <h1>📞 Contact Hostel Administration</h1>
  <p>We are here to help you with hostel-related issues</p>
</div>

<?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<div class="grid">

<!-- Hostel Info -->
<div class="card">
  <h2>🏢 Hostel Office</h2>
  <p>📍 ABC Engineering College Hostel, Nagpur</p>
  <p>📧 hosteladmin@college.edu</p>
  <p>📞 +91 98765 43210</p>
  <p>🕘 9 AM – 6 PM (Mon–Sat)</p>
</div>

<!-- Contact Form -->
<div class="card">
  <h2>✉️ Send Message</h2>

  <form method="POST">

    <input type="text" name="name" placeholder="Your Name" required>

    <input type="email" name="email" placeholder="Your Email" required>

    <input type="text" name="subject" placeholder="Subject">

    <textarea name="message" rows="5" placeholder="Write your message..." required></textarea>

    <button type="submit" name="send">🚀 Send Message</button>

  </form>
</div>

</div>

<br>
<center>
<a href="home.php">← Back to Home</a>
</center>

</div>

</body>
</html>
