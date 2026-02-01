<!DOCTYPE html>
<html>
<head>
<title>Hostel Complaint Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --primary:#F97316;
    --secondary:#1E40AF;
    --success:#10B981;
    --danger:#EF4444;
    --dark:#1E293B;
    --glass:rgba(255,255,255,0.85);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:linear-gradient(135deg,#E2E8F0,#CBD5E1);
    color:var(--dark);
}

/* ===== HEADER ===== */
header{
    background:var(--glass);
    backdrop-filter:blur(15px);
    padding:20px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 25px rgba(0,0,0,0.1);
}

.logo{
    font-size:1.8rem;
    font-weight:800;
    background:linear-gradient(45deg,var(--primary),var(--secondary));
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

nav a{
    margin-left:20px;
    text-decoration:none;
    font-weight:600;
    padding:8px 18px;
    border-radius:30px;
    background:white;
    color:var(--dark);
    transition:0.3s;
}

nav a:hover{
    background:var(--primary);
    color:white;
    transform:translateY(-3px);
}

/* ===== HERO ===== */
.hero{
    text-align:center;
    padding:100px 20px;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
}

.hero h1{
    font-size:3.2rem;
    margin-bottom:20px;
}

.hero p{
    font-size:1.2rem;
    margin-bottom:40px;
    opacity:0.95;
}

.hero button{
    padding:15px 35px;
    margin:10px;
    border:none;
    border-radius:50px;
    font-weight:700;
    cursor:pointer;
    transition:0.3s;
}

.student-btn{
    background:white;
    color:var(--primary);
}

.admin-btn{
    background:transparent;
    border:2px solid white;
    color:white;
}

.hero button:hover{
    transform:scale(1.1);
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

/* ===== FEATURES ===== */
.features{
    padding:70px 20px;
    max-width:1200px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:30px;
}

.feature-card{
    background:var(--glass);
    padding:35px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    transition:0.3s;
}

.feature-card:hover{
    transform:translateY(-12px);
}

.feature-card h3{
    margin-bottom:15px;
    color:var(--primary);
}

/* ===== STATS ===== */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
    max-width:1100px;
    margin:50px auto;
}

.stat-card{
    background:var(--glass);
    padding:40px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.stat-number{
    font-size:2.8rem;
    font-weight:800;
    color:var(--primary);
}

/* ===== FOOTER ===== */
footer{
    background:var(--primary);
    color:white;
    padding:40px;
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
}

footer h3{
    margin-bottom:10px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    header{
        flex-direction:column;
        gap:15px;
    }

    .hero h1{
        font-size:2.2rem;
    }
}
</style>
</head>

<body>

<header>
    <div class="logo">🏨 Hostel Complaint Portal</div>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
        <a href="auth.php">Login</a>
    </nav>
</header>

<section class="hero">
    <h1>Your Complaint, Our Responsibility</h1>
    <p>Smart Complaint Tracking System for Hostel Students & Wardens</p>

    <button class="student-btn" onclick="location.href='login.php?role=student'">
        Student Login
    </button>

    <button class="admin-btn" onclick="location.href='admin_login.php?role=admin'">
        Warden Login
    </button>
</section>

<section class="features">
    <div class="feature-card">
        <h3>Easy Complaint Submission</h3>
        <p>Students can submit complaints anytime online.</p>
    </div>

    <div class="feature-card">
        <h3>Smart Priority Detection</h3>
        <p>Emergency complaints automatically marked high priority.</p>
    </div>

    <div class="feature-card">
        <h3>Real-Time Tracking</h3>
        <p>Track complaint status instantly.</p>
    </div>

    <div class="feature-card">
        <h3>Centralized Management</h3>
        <p>Wardens manage and resolve complaints efficiently.</p>
    </div>
</section>

<section class="stats">
    <div class="stat-card">
        <div class="stat-number">120+</div>
        <p>Total Complaints</p>
    </div>

    <div class="stat-card">
        <div class="stat-number">95+</div>
        <p>Resolved</p>
    </div>

    <div class="stat-card">
        <div class="stat-number">3 Days</div>
        <p>Average Resolution Time</p>
    </div>
</section>

<footer>
    <div>
        <h3>Contact Us</h3>
        <p>Phone: +91 9876543210</p>
        <p>Email: hostel@college.edu</p>
    </div>

    <div>
        <p>© 2026 Hostel Complaint Management System</p>
    </div>
</footer>

</body>
</html>
