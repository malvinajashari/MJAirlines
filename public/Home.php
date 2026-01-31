<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->checkLogin();

if ($auth->currentUserRole() === 'admin') {
    header("Location: http://localhost/MJAirlines/public/dashboard/users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MJ Airlines - Home</title>
  <link rel="stylesheet" href="assets/css/Home.css">
</head>
<body>
  <header style="background: linear-gradient(90deg, #005bbb, #0073e6); color: white; padding: 20px; border-radius: 0 0 20px 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
  <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;">
    <h1 style="margin: 0; font-size: 2rem; font-family: 'Arial', sans-serif; letter-spacing: 1px;">MJ Airlines</h1>
    <nav style="margin-top: 10px;">
      <a href="home.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">Home</a>
      <a href="flights.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">Flights</a>
      <a href="aboutus.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">About Us</a>
      <a href="contactus.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">Contact Us</a>
      <a href="account.php" style="color: #ffeb3b; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">My Account</a>
      <a href="logout.php" style="color: #ffeb3b; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">Logout</a>
    </nav>
  </div>
</header>


  <div class="slider">
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <div class="slides" id="slides">
      <div class="slide" style="background-image: url('assets/images/airplane.jpeg');"></div>
      <div class="slide" style="background-image: url('assets/images/planet.jpeg');"></div>
      <div class="slide" style="background-image: url('assets/images/landscape.avif');"></div>
    </div>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
  </div>

  <div class="content">
    <h2>Welcome Aboard</h2>
    <p>Your journey begins here. Explore the world with comfort and confidence.</p>
  </div>

  <section class="destinations">
    <h2>Popular Destinations</h2>

    <div class="dest-row">
      <img src="assets/images/paris.jpeg" class="dest-img" />
      <div class="dest-text">
        <h3>Paris, France</h3>
        <p>The city of lights awaits with its romantic atmosphere, rich culture, and world-famous landmarks such as the Eiffel Tower and Louvre Museum.</p>
      </div>
    </div>

    <div class="dest-row reverse">
      <img src="assets/images/tokyo.jpeg" class="dest-img" />
      <div class="dest-text">
        <h3>Tokyo, Japan</h3>
        <p>A perfect blend of tradition and technology, Tokyo draws travelers with its neon-lit streets, ancient temples, and unparalleled cuisine.</p>
      </div>
    </div>

    <div class="dest-row">
      <img src="assets/images/usa.jpeg" class="dest-img" />
      <div class="dest-text">
        <h3>New York, USA</h3>
        <p>The city that never sleeps offers iconic sights like Times Square, Central Park, and skyscrapers that define the modern skyline.</p>
      </div>
    </div>
  </section>

  <footer>
    &copy; 2025 MJ Airlines. All Rights Reserved.
  </footer>

  <script src="assets/js/main.js"></script>
</body>
</html>
