<!DOCTYPE html>
<html>
<head>
<title>About | Hostel Complaint Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --primary:#F97316;
    --secondary:#1E40AF;
    --light:#F8FAFC;
    --dark:#1E293B;
}

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#E2E8F0,#CBD5E1);
}

.container{
    max-width:1100px;
    margin:auto;
    padding:60px 20px;
}

.title{
    text-align:center;
    margin-bottom:50px;
}

.title h1{
    font-size:2.8rem;
    background:linear-gradient(45deg,var(--primary),var(--secondary));
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.section{
    background:white;
    padding:30px;
    border-radius:20px;
    margin-bottom:30px;
    box-shadow:0 15px 40px rgba(0,0,0,0.1);
}

.section h2{
    color:var(--secondary);
    margin-bottom:15px;
}

.section p{
    color:var(--dark);
    line-height:1.6;
}

.features{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-top:20px;
}

.feature-card{
    background:var(--light);
    padding:20px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

.feature-card h3{
    color:var(--primary);
    margin-bottom:10px;
}

.footer{
    text-align:center;
    margin-top:40px;
}

.footer a{
    text-decoration:none;
    color:var(--secondary);
    font-weight:600;
}

.footer a:hover{
    text-decoration:underline;
}

@media(max-width:768px){
    .container{
        padding:40px 15px;
    }
}
</style>
</head>

<body>

<div class="container">

<div class="title">
    <h1>🏨 About Hostel Complaint System</h1>
</div>

<div class="section">
    <h2>📌 Project Overview</h2>
    <p>
    The Hostel Complaint Management System is a web-based application designed to simplify 
    and streamline the complaint handling process within hostel facilities. 
    It allows students to raise complaints easily and track their status in real time, 
    while wardens can manage, update, and resolve issues efficiently.
    </p>
</div>

<div class="section">
    <h2>🎯 Our Mission</h2>
    <p>
    Our mission is to improve hostel living standards by providing a transparent, 
    fast, and organized complaint resolution system. 
    The platform ensures proper communication between students and hostel administration.
    </p>
</div>

<div class="section">
    <h2>🚀 Key Features</h2>

    <div class="features">

        <div class="feature-card">
            <h3>📝 Easy Complaint Submission</h3>
            <p>Students can submit complaints online anytime.</p>
        </div>

        <div class="feature-card">
            <h3>⚡ Smart Priority Detection</h3>
            <p>Automatically detects urgent complaints.</p>
        </div>

        <div class="feature-card">
            <h3>📊 Real-Time Tracking</h3>
            <p>Track complaint status instantly.</p>
        </div>

        <div class="feature-card">
            <h3>🛠 Warden Dashboard</h3>
            <p>Wardens can update status and respond quickly.</p>
        </div>

        <div class="feature-card">
            <h3>⭐ Feedback System</h3>
            <p>Students can give feedback after resolution.</p>
        </div>

        <div class="feature-card">
            <h3>📩 Contact Support</h3>
            <p>Direct communication with hostel administration.</p>
        </div>

    </div>
</div>

<div class="section">
    <h2>💻 Technologies Used</h2>
    <p>
    HTML, CSS, JavaScript, PHP, and MySQL were used to develop this system. 
    The application follows CRUD operations and role-based authentication.
    </p>
</div>

<div class="footer">
    <p><a href="home.php">← Back to Home</a></p>
</div>

</div>

</body>
</html>
