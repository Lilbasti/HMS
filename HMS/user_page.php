<?php
include "conn.php"; // Connect to your database

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $guest_name = mysqli_real_escape_string($conn, $_POST['guest_name']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $no_of_guest = mysqli_real_escape_string($conn, $_POST['no_of_guest']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    
    // Automatically capture the current date and time
    $booking_date = date("Y-m-d H:i:s");

    // Insert data into your database booking table
    $query = "INSERT INTO booking (Guest_Name, Room_Type, No_of_Guest, Contact, Booking_Date) 
              VALUES ('$guest_name', '$room_type', '$no_of_guest', '$contact', '$booking_date')";

    if (mysqli_query($conn, $query)) {
        $message = "Booking successful! Your room has been reserved.";
    } else {
        $message = "Error booking room: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>IZWN Hotel Booking</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    display:flex;
    min-height:100vh;
    background:#f5f7fa;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    background:#0f172a;
    color:white;
    padding:25px;
    position:fixed;
    height:100vh;
    box-shadow:5px 0 20px rgba(0,0,0,.15);
}

.sidebar h2{
    text-align:center;
    margin-bottom:35px;
    color:#D4AF37;
    font-size:28px;
    letter-spacing:2px;
}

.sidebar a{
    display:block;
    text-decoration:none;
    color:white;
    padding:14px 18px;
    border-radius:10px;
    margin-bottom:10px;
    transition:.3s;
}

.sidebar a:hover{
    background:#D4AF37;
    color:white;
}

/* MAIN */
.main{
    margin-left:250px;
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}

/* FORM BOX */
.form-box{
    width:450px;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.1);
}

.form-box h2{
    text-align:center;
    color:#0f172a;
    margin-bottom:25px;
}

.message{
    text-align:center;
    margin-bottom:15px;
    color:green;
    font-weight:600;
}

/* ROOM CARDS */
.room-scroll{
    display:flex;
    gap:15px;
    overflow-x:auto;
    margin-bottom:20px;
}

.room-card{
    min-width:130px;
    background:#0f172a;
    color:#D4AF37;
    padding:15px;
    border-radius:12px;
    text-align:center;
    font-weight:600;
}

/* FORM */
label{
    display:block;
    margin-bottom:6px;
    color:#0f172a;
    font-weight:500;
}

input,
select{
    width:100%;
    padding:13px;
    margin-bottom:15px;
    border:1px solid #d1d5db;
    border-radius:10px;
    outline:none;
}

input:focus,
select:focus{
    border-color:#D4AF37;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#D4AF37;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

button:hover{
    opacity:.9;
}

/* MOBILE */
@media(max-width:900px){
    body{
        flex-direction:column;
    }

    .sidebar{
        position:relative;
        width:100%;
        height:auto;
    }

    .main{
        margin-left:0;
        padding:20px;
    }

    .form-box{
        width:100%;
    }
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>IZWN HOTEL</h2>
    <a href="user_page.php">Dashboard</a>
    <a href="gallery.html">Gallery</a>
    <a href="rooms.html">Rooms</a>
    <a href="index.php">Logout</a>
</div>

<div class="main">
    <div class="form-box">
        <h2>Hotel Booking Form</h2>

        <?php
        if(isset($message)){
            echo "<div class='message'>$message</div>";
        }
        ?>

        <div class="room-scroll">
            <div class="room-card">Normal Room</div>
            <div class="room-card">Deluxe Room</div>
            <div class="room-card">King Room</div>
        </div>

        <form action="" method="POST" onsubmit="return validateForm()">

            <label>Guest Name</label>
            <input type="text" name="guest_name" required>

            <label>Room Type</label>
            <select name="room_type" required>
                <option value="">Select Room</option>
                <option value="Normal">Normal</option>
                <option value="Deluxe">Deluxe</option>
                <option value="King">King</option>
            </select>

            <label>No. of Guests</label>
            <input type="number" name="no_of_guest" id="guests" min="1" required>

            <label>Contact</label>
            <input type="text" name="contact" id="contact" maxlength="11" pattern="[0-9]{11}" placeholder="09XXXXXXXXX" required>

            <button type="submit">Book Now</button>

        </form>

    </div>
</div>

<script>
function validateForm(){
    var contact = document.getElementById("contact").value;
    var guests = document.getElementById("guests").value;

    if(contact.length != 11 || isNaN(contact)){
        alert("Contact number must be exactly 11 digits.");
        return false;
    }

    if(guests <= 0){
        alert("Number of guests must be at least 1.");
        return false;
    }

    return true;
}
</script>

</body>
</html>