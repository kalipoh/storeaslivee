<?php
session_start();

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah preferensi gambar sudah diatur
if (isset($_POST['toggle_images'])) {
    $_SESSION['show_images'] = isset($_POST['show_images']) ? true : false;
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$host = "sql212.infinityfree.com";
$username = "if0_38396302";
$password = "laurentindra12";
$database = "if0_38396302_aslive_gadget_store"; // Changed to match username prefix

$conn = new mysqli($host, $username, $password, $database);
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aslive Gadget Store</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Fixed Navbar with single search form -->
  <nav class="navbar">
    <img src="logo.png" alt="Logo" class="top-left-image">
    <a href="#" class="navbar-logo">Aslive<span>Gadget</span><span>Store.</span></a>

    <div class="navbar-nav">
      <a href="#home">Home</a>
      <a href="#about">About Us</a>
      <a href="#products">Products</a>
      <a href="#contact">Contact</a>
      <a href="login.php">Login</a>
    </div>

    <div class="navbar-extra">
      <a href="#" id="search-button"><i data-feather="search"></i></a>
      <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i></a>
      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>

    <!-- Single search form -->
    <div class="search-form">
      <input type="search" id="search-box" placeholder="Search here...">
      <label for="search-box"><i data-feather="search"></i></label>
    </div>
  </nav>

  <!-- Single shopping cart -->
  <div class="shopping-cart">
    <h2>Your Shopping Cart</h2>
    <div class="cart-items-container">
      <!-- Items will be added here dynamically -->
    </div>
    <div class="cart-total">
      <p>Total: <span id="cart-total-amount">Rp 0</span></p>
    </div>
    <button id="checkout-btn">Checkout</button>
    <p class="empty-cart">Your cart is empty</p>
  </div>

  <section class="hero" id="home">
    <div class="mask-container">
      <main class="content">
        <h1>Find the latest <span>Gadgets</span> Here!</h1>
        <p>All your tech needs, in one place.</p>
        <a href="#products" class="cta">Buy Now</a>
      </main>
    </div>
  </section>

  <section id="about" class="about">
    <h2><span>About</span> Us</h2>
    <div class="row" style="display: flex;">
      <div class="about-img" style="flex: 1 4 80rem;">
        <img src="aboutus.jpg" alt="About Us" style="width: 49%; margin-top: 65px; margin-left: 50px;">
      </div>
      <div class="content" style="flex: 1 1 35rem; padding: 0 1rem;">
        <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">Shop Smart with Us!</h3>
        <p>Discover the best gadgets at Aslive Gadget Store. We bring you the latest tech to help you stay connected and efficient.</p>
        <p>Experience quality products and friendly service that makes shopping easy and enjoyable.</p>
       
      </div>
    </div>
  </section>

  <section id="products">
    <h1>Our Products</h1>
    <h2>Everything you want is here!</h2>
    <div class="product-slider">
      <div class="product-container">
        <div class="product-card">
          <img src="charger.jpg" alt="TRAVEL Charger Fast Charging Samsung A70" />
          <h3>TRAVEL Charger Fast Charging Samsung A70</h3>
          <p>Rp 100.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="hape2.jpg" alt="Iphone 14 Pro Max 1TB" />
          <h3>Iphone 14 Pro Max 1TB</h3>
          <p>Rp 10.000.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="headphones.jpg" alt="BASEUS BOWIE D05 WIRELESS HEADPHONES" />
          <h3>BASEUS BOWIE D05 WIRELESS HEADPHONES</h3>
          <p>Rp 250.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="iphone.jpg" alt="Iphone 11 64GB" />
          <h3>Iphone 11 64GB</h3>
          <p>Rp 15.500.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="mouse.jpg" alt="Asus Rog Pugio Optical Gaming Mouse" />
          <h3>Asus Rog Pugio Optical Gaming Mouse</h3>
          <p>Rp 130.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="powerbank.jpg" alt="ACMIC ULTRA 20000mAh Powerbank 100W Type C For Charge Laptop & Gadget" />
          <h3>ACMIC ULTRA 20000mAh Powerbank 100W Type C For Charge Laptop & Gadget</h3>
          <p>Rp 250.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="tws.jpg" alt="TWS Anker Earphone Soundcore Life Dot 3i ANC - A3982" />
          <h3>TWS Anker Earphone Soundcore Life Dot 3i ANC - A3982</h3>
          <p>Rp 180.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="headsett.jpg" alt="Headset Earphone Telinga Headphone Handsfree Premium Quality" />
          <h3>Headset Earphone Telinga Headphone Handsfree Premium Quality</h3>
          <p>Rp 250.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="laptop.jpg" alt="ROG Zephyrus" />
          <h3>ROG Zephyrus</h3>
          <p>Rp 13.500.000</p>
          <button>Add to Cart</button>
        </div>
        <div class="product-card">
          <img src="download.jpg" alt="Samsung Galaxy S22 256GB" />
          <h3>Samsung Galaxy S22 256GB</h3>
          <p>Rp 5.500.000</p>
          <button>Add to Cart</button>
        </div>
      </div>
      <button class="prev" onclick="moveSlide(1)">&#10094;</button>
      <button class="next" onclick="moveSlide(-1)">&#10095;</button>
    </div> 
  </section>

  <section id="contact" class="contact">
    <h2><span>Contact</span> Us</h2>
    <div class="row">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.85558578203!2d107.17075949999999!3d-6.2827078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6985646ea5a3bf%3A0x4c351314eea2ea98!2sPresident%20University%20Student%20Housing!5e0!3m2!1sen!2sid!4v1728763882517!5m2!1sen!2sid" 
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map">
      </iframe>
      <form>
        <h3>If you like to order our product, please input your data!</h3>
        <div class="input-group">
          <i data-feather="user"></i>
          <input type="text" placeholder="Name" required />
        </div>
        <div class="input-group">
          <i data-feather="mail"></i>
          <input type="email" placeholder="Email" required />
        </div>
        <div class="input-group">
          <i data-feather="phone"></i>
          <input type="tel" placeholder="Phone Number" required />
        </div>
        <button type="submit" class="btn">I want to Order!</button>
      </form>
    </div>
  </section>

  <footer>
    <div class="socials">
      <a href="#"><i data-feather="instagram"></i></a>
      <a href="#"><i data-feather="twitter"></i></a>
      <a href="#"><i data-feather="facebook"></i></a>
    </div>

    <div class="links">
      <a href="#home">Home</a>
      <a href="#about">About Us</a>
      <a href="#products">Products</a>
      <a href="#contact">Contact</a>
    </div>

    <div class="credit">
      <p>Aslive Gadget Store.<span> since 2024.</span></p>
    </div>
  </footer>
  
  
  <script src="script.js"></script>
  <script>
    $(document).ready(function() {
      feather.replace();
      toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
      };
    });
  </script>
</body>
</html>
