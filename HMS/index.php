<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IZWN Hotel</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f5f7fa;
    overflow-x:hidden;
}

/* NAVBAR */

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 60px;
    position:absolute;
    width:100%;
    z-index:100;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
}

.logo{
    font-size:24px;
    font-weight:700;
    letter-spacing:2px;
    color:#D4AF37;
}

.nav-links a{
    text-decoration:none;
    color:white;
    margin-left:25px;
    transition:.3s;
}

.nav-links a:hover{
    color:#D4AF37;
}

.auth a{
    text-decoration:none;
    margin-left:15px;
    padding:10px 20px;
    border-radius:8px;
    color:white;
    border:1px solid rgba(255,255,255,.4);
    transition:.3s;
}

.signup{
    background:#D4AF37;
    border:none;
}

.auth a:hover{
    transform:translateY(-2px);
}

/* HERO */

.hero{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:20px;

    background:
    linear-gradient(rgba(10,20,40,.65),rgba(10,20,40,.65)),
    url("Images/hotel.1.jpg");

    background-size:cover;
    background-position:center;
}

.hero-content{
    max-width:700px;
    animation:fadeUp 1s ease;
}

.hero-content h1{
    font-size:70px;
    line-height:80px;
    color:white;
    margin-bottom:20px;
}

.hero-content p{
    color:#f0f0f0;
    font-size:18px;
    margin-bottom:35px;
}

.btn{
    display:inline-block;
    padding:15px 35px;
    background:#D4AF37;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 30px rgba(212,175,55,.4);
}

/* ANIMATION */

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(40px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* MOBILE */

@media(max-width:900px){

    .navbar{
        flex-direction:column;
        gap:15px;
        padding:20px;
    }

    .hero-content h1{
        font-size:45px;
        line-height:55px;
    }

    .hero-content p{
        font-size:16px;
    }

}

</style>
</head>

<body>

<div class="navbar">

    <div class="logo">IZWN HOTEL</div>

    <div class="nav-links">
        <a href="a.php">Home</a>
        <a href="a.php">Rooms</a>
        <a href="a.php">Gallery</a>
        <a href="a.php">Contact</a>
    </div>

    <div class="auth">
        <a href="a.php">Login</a>
        <a href="a.php" class="signup">Sign Up</a>
    </div>

</div>

<section class="hero">

    <div class="hero-content">

        <h1>Luxury & Comfort<br>Await You</h1>

        <p>
            Experience world-class hospitality, elegant rooms,
            and unforgettable moments at IZWN Hotel.
            Reserve your stay today.
        </p>

        <a href="a.php" class="btn">Book Now</a>

    </div>

</section>

</body>
</html>