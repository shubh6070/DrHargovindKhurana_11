<?php
session_start();
$conn = mysqli_connect("localhost","root","","hostel_db");

if(!$conn){
    die("Database connection failed");
}

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="student"){
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

/* ================= SMART PRIORITY ================= */
function detectPriority($text){
    $text = strtolower($text);

    $high = ["fire","urgent","burst","shock","security","theft","leak","danger"];
    $medium = ["slow","not working","broken","damaged"];

    foreach($high as $word){
        if(strpos($text,$word)!==false) return "High";
    }
    foreach($medium as $word){
        if(strpos($text,$word)!==false) return "Medium";
    }
    return "Low";
}

/* ================= ADD COMPLAINT ================= */
if(isset($_POST['add_complaint'])){
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $priority = detectPriority($description);

    mysqli_query($conn,"INSERT INTO complaints(user_id,category_id,title,description,priority)
    VALUES('$user_id','$category_id','$title','$description','$priority')");

    $complaint_id = mysqli_insert_id($conn);

    mysqli_query($conn,"INSERT INTO activity_logs(complaint_id,action,action_by)
    VALUES('$complaint_id','Complaint Submitted','$user_id')");
}

/* ================= FEEDBACK ================= */
if(isset($_POST['submit_feedback'])){
    $complaint_id = $_POST['complaint_id'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];

    mysqli_query($conn,"INSERT INTO feedback(complaint_id,user_id,rating,message)
    VALUES('$complaint_id','$user_id','$rating','$message')");

    mysqli_query($conn,"INSERT INTO activity_logs(complaint_id,action,action_by)
    VALUES('$complaint_id','Feedback Submitted','$user_id')");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#1E40AF,#F97316);
}

.sidebar{
    width:230px;
    height:100vh;
    background:#111827;
    position:fixed;
    padding:20px;
    color:white;
}

.sidebar h2{margin-bottom:30px;}
.sidebar a{
    display:block;
    padding:10px;
    margin:10px 0;
    color:white;
    text-decoration:none;
    border-radius:8px;
}
.sidebar a:hover{background:#F97316;}

.main{
    margin-left:230px;
    padding:30px;
    color:white;
}

.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(15px);
    padding:50px;
    border-radius:15px;
    margin-bottom:30px;
}
.h2{
padding:20px;
}
input,select,textarea{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:none;
}

button{
    padding:10px 20px;
    background:#F97316;
    border:none;
    border-radius:8px;
    color:white;
    cursor:pointer;
}
button:hover{background:#EA580C;}

.badge{
    padding:5px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
}
.Low{background:#10B981;}
.Medium{background:#F59E0B;}
.High{background:#EF4444;}

.status-badge{
    padding:5px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
}
.Submitted{background:#3B82F6;}
.InProgress{background:#F59E0B;}
.Resolved{background:#10B981;}
.Escalated{background:#EF4444;}

.complaint-box{
    background:white;
    color:black;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
}

.activity{
    background:#f1f5f9;
    padding:10px;
    border-radius:8px;
    max-height:150px;
    overflow:auto;
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>🏨 Student Panel</h2>
    <a href="#add">Add Complaint</a>
    <a href="#list">My Complaints</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

<h2>Welcome, <?php echo $name; ?> 👋</h2>

<!-- ADD COMPLAINT -->
<div class="card" id="add">
<h3>➕ Add Complaint</h3>

<form method="POST">
<label>Category</label>
<select name="category_id" required>
<?php
$cats = mysqli_query($conn,"SELECT * FROM categories");
while($c=mysqli_fetch_assoc($cats)){
    echo "<option value='{$c['id']}'>{$c['category_name']}</option>";
}
?>
</select>

<input type="text" name="title" placeholder="Complaint Title" required>
<textarea name="description" placeholder="Describe issue..." required></textarea>
<button name="add_complaint">Submit Complaint</button>
</form>
</div>

<!-- MY COMPLAINTS -->
<div class="card" id="list">
<h3>📋 My Complaints</h3>

<?php
$result = mysqli_query($conn,"
SELECT complaints.*, categories.category_name 
FROM complaints
LEFT JOIN categories ON complaints.category_id=categories.id
WHERE complaints.user_id='$user_id'
ORDER BY complaints.id DESC");

while($row=mysqli_fetch_assoc($result)){
?>

<div class="complaint-box">

<h4>#<?php echo $row['id']; ?> - <?php echo $row['title']; ?></h4>

<p><strong>Category:</strong> <?php echo $row['category_name']; ?></p>
<p><strong>Description:</strong> <?php echo $row['description']; ?></p>

<p>
<strong>Priority:</strong>
<span class="badge <?php echo $row['priority']; ?>">
<?php echo $row['priority']; ?>
</span>
</p>

<p>
<strong>Status:</strong>
<span class="status-badge <?php echo str_replace(' ','',$row['status']); ?>">
<?php echo $row['status']; ?>
</span>
</p>

<p><strong>Created:</strong> <?php echo $row['created_at']; ?></p>

<hr>
<h5>📝 Warden Response / Activity</h5>

<div class="activity">
<?php
$logs = mysqli_query($conn,"
SELECT activity_logs.*, users.name 
FROM activity_logs
JOIN users ON activity_logs.action_by=users.id
WHERE complaint_id='{$row['id']}'
ORDER BY action_time DESC");

while($log=mysqli_fetch_assoc($logs)){
    echo "<p><strong>{$log['name']}:</strong> {$log['action']}<br>
    <small>{$log['action_time']}</small></p>";
}
?>
</div>

<?php if($row['status']=="Resolved"){ ?>
<hr>
<h5>⭐ Give Feedback</h5>

<form method="POST">
<input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
<select name="rating">
<option value="5">⭐⭐⭐⭐⭐</option>
<option value="4">⭐⭐⭐⭐</option>
<option value="3">⭐⭐⭐</option>
<option value="2">⭐⭐</option>
<option value="1">⭐</option>
</select>
<textarea name="message" placeholder="Write feedback"></textarea>
<button name="submit_feedback">Submit Feedback</button>
</form>
<?php } ?>

</div>

<?php } ?>

</div>

</div>
</body>
</html>
