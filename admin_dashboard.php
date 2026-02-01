<?php
session_start();
$conn = mysqli_connect("localhost","root","","hostel_db");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ===== SESSION CHECK ===== */
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

$admin_id   = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

/* ===== UPDATE COMPLAINT ===== */
if(isset($_POST['update'])){

    $complaint_id = $_POST['complaint_id'];
    $status       = $_POST['status'];
    $response     = mysqli_real_escape_string($conn,$_POST['response']);

    mysqli_query($conn,"UPDATE complaints 
                        SET status='$status' 
                        WHERE id='$complaint_id'");

    mysqli_query($conn,"INSERT INTO activity_logs
        (complaint_id,action,action_by,action_role)
        VALUES('$complaint_id','Status changed to $status',
        '$admin_id','admin')");

    if(!empty($response)){
        mysqli_query($conn,"INSERT INTO activity_logs
            (complaint_id,action,action_by,action_role)
            VALUES('$complaint_id','Response: $response',
            '$admin_id','admin')");
    }

    header("Location: admin_dashboard.php");
    exit();
}

/* ===== MARK CONTACT AS REPLIED ===== */
if(isset($_POST['mark_replied'])){
    $contact_id = $_POST['contact_id'];

    mysqli_query($conn,"
    UPDATE contact_messages 
    SET status='Replied' 
    WHERE id='$contact_id'
    ");

    header("Location: admin_dashboard.php");
    exit();
}

/* ===== COUNT STATS ===== */
$total     = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM complaints"));
$resolved  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM complaints WHERE status='Resolved'"));
$pending   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM complaints WHERE status!='Resolved'"));

/* ===== FETCH CONTACTS ===== */
$contact_query = mysqli_query($conn,"
SELECT * FROM contact_messages
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}

body{
    background:linear-gradient(135deg,#0f172a,#1E40AF);
    color:white;
}

.sidebar{
    width:230px;
    height:100vh;
    background:#111827;
    position:fixed;
    padding:20px;
}

.sidebar h2{margin-bottom:30px;}
.sidebar a{
    display:block;
    padding:10px;
    margin:10px 0;
    text-decoration:none;
    color:white;
    border-radius:8px;
}
.sidebar a:hover{background:#F97316;}

.main{
    margin-left:230px;
    padding:30px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:rgba(255,255,255,0.08);
    padding:20px;
    border-radius:15px;
    text-align:center;
}

.card{
    background:rgba(255,255,255,0.08);
    padding:20px;
    border-radius:15px;
    margin-bottom:30px;
}

.complaint{
    background:white;
    color:black;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
}

.badge{
    padding:4px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.Low{background:#10B981;}
.Medium{background:#F59E0B;}
.High{background:#EF4444;}

.Submitted{background:#3B82F6;}
.InProgress{background:#F59E0B;}
.Resolved{background:#10B981;}
.Escalated{background:#EF4444;}

.New{background:#3B82F6;}
.Replied{background:#10B981;}

select,textarea{
    width:100%;
    padding:8px;
    margin:8px 0;
    border-radius:6px;
}

button{
    padding:8px 15px;
    border:none;
    border-radius:6px;
    background:#F97316;
    color:white;
    cursor:pointer;
}
button:hover{background:#EA580C;}
</style>
</head>

<body>

<div class="sidebar">
    <h2>🛠 Warden Panel</h2>
    <a href="#">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

<h2>Welcome, <?php echo $admin_name; ?> 👨‍💼</h2>

<!-- ===== STATS ===== -->
<div class="stats">
    <div class="stat-card">
        <h3><?php echo $total; ?></h3>
        <p>Total Complaints</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $resolved; ?></h3>
        <p>Resolved</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $pending; ?></h3>
        <p>Pending</p>
    </div>
</div>

<!-- ===== COMPLAINT SECTION ===== -->
<div class="card">
<h3>📋 All Complaints</h3>
<br>

<?php
$result = mysqli_query($conn,"
SELECT complaints.*, users.name, categories.category_name
FROM complaints
JOIN users ON complaints.user_id = users.id
LEFT JOIN categories ON complaints.category_id = categories.id
ORDER BY complaints.id DESC");

while($row=mysqli_fetch_assoc($result)){
?>

<div class="complaint">
<h4>#<?php echo $row['id']; ?> - <?php echo $row['title']; ?></h4>
<p><strong>Student:</strong> <?php echo $row['name']; ?></p>
<p><strong>Description:</strong> <?php echo $row['description']; ?></p>

<p>
<strong>Priority:</strong>
<span class="badge <?php echo $row['priority']; ?>">
<?php echo $row['priority']; ?>
</span>
</p>

<p>
<strong>Status:</strong>
<span class="badge <?php echo str_replace(" ","",$row['status']); ?>">
<?php echo $row['status']; ?>
</span>
</p>

<form method="POST">
<input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
<select name="status">
<option>Submitted</option>
<option>In Progress</option>
<option>Resolved</option>
<option>Escalated</option>
</select>
<textarea name="response" placeholder="Write response..."></textarea>
<button name="update">Update</button>
</form>
</div>

<?php } ?>
</div>

<!-- ===== CONTACT SECTION ===== -->
<div class="card">
<h3>📩 Contact Messages</h3>
<br>

<?php
if(mysqli_num_rows($contact_query) > 0){
while($msg = mysqli_fetch_assoc($contact_query)){
?>

<div class="complaint">
<h4><?php echo $msg['subject'] ? $msg['subject'] : "General Message"; ?></h4>
<p><strong>Name:</strong> <?php echo $msg['name']; ?></p>
<p><strong>Email:</strong> <?php echo $msg['email']; ?></p>
<p><strong>Message:</strong> <?php echo $msg['message']; ?></p>

<p>
<strong>Status:</strong>
<span class="badge <?php echo $msg['status']; ?>">
<?php echo $msg['status']; ?>
</span>
</p>

<?php if($msg['status']=="New"){ ?>
<form method="POST">
<input type="hidden" name="contact_id" value="<?php echo $msg['id']; ?>">
<button name="mark_replied">Mark as Replied</button>
</form>
<?php } ?>

</div>

<?php } } else {
echo "<p>No contact messages found.</p>";
} ?>

</div>

</div>
</body>
</html>
