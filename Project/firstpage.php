<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Auction</title>
    <script>
window.history.pushState(null, "", window.location.href);
window.addEventListener("popstate", function () {
    window.history.pushState(null, "", window.location.href);
});
function disableBack() {
    window.history.pushState(null, "", window.location.href);
}
window.onload = disableBack;
window.onunload = function () { return null; };
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".faq-question").forEach(button => {
        button.addEventListener("click", () => {
            const answer = button.nextElementSibling;
            const isOpen = answer.style.display === "block";
            document.querySelectorAll(".faq-answer").forEach(item => {
                item.style.display = "none";
            });
            answer.style.display = isOpen ? "none" : "block";
        });
    });
});
function showVideoPopup() {
    const videoPopup = document.getElementById("videoPopup");
    const video = document.getElementById("bidblitzVideo");

    videoPopup.style.display = "flex";
    video.play();
}

function closeVideoPopup() {
    const videoPopup = document.getElementById("videoPopup");
    const video = document.getElementById("bidblitzVideo");

    video.pause();
    video.currentTime = 0;
    videoPopup.style.display = "none";
}

    </script>

    <style>
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    background-image: url('bidblitz.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    opacity: 0.9;
    color: #333;
    zoom: 65%; 
    overflow-x: hidden;
}

header {
    background: linear-gradient(135deg, rgb(77, 56, 4), #001a33);
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: rgb(227, 201, 167);
    font-size: 18px;
}

.nav-bar {
    width: 100%;
    background: linear-gradient(135deg, #001a33, #02150d);
    padding: 15px 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    font-size: 20px;
    gap: 20px;
}

.nav-bar a {
    display: inline-block;
    background: linear-gradient(135deg, #D4AF37, #001a33);
    text-decoration: none;
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    transition: background 0.3s ease, transform 0.2s ease;
}

.nav-bar a:hover {
    background: linear-gradient(135deg, #b28e2e, #000e20);
    transform: scale(1.1);
}

.search-box {
    position: absolute;
    right: 40px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    gap: 10px;
}
.search-box input {
    width: 350px;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    background-color: white;
    color: rgb(1, 6, 23);
}

.search-box button {
    background-color: rgb(1, 4, 15);
    color: rgb(232, 222, 208);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    padding: 10px 20px;
    font-size: 16px;
    transition: background 0.3s ease, transform 0.2s ease;
}

.search-box button:hover {
    background-color: rgba(216, 176, 75, 0.8);
    transform: scale(1.05);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.header-left img {
    height: 150px;
    width: 350px;
    opacity: 0.7;
}
.header-middle {
    color: rgb(227, 201, 167);
    font-size: 30px;
    font-weight: bold;
    font-family: 'Dancing Script', cursive;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 40px;
}
.header-middle img {
    height: 85px;
    width: 850px;
    margin-top: 10px;
}
.user-info {
    font-size: 18px;
    font-weight: bold;
    align-items: center;
}
.header-right {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: flex-end;
}
.header-right a {
    text-decoration: none;
    color: rgb(227, 201, 167);
    background-color: rgb(1, 4, 15);
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: bold;
}
.header-right a:hover {
    background-color: rgba(216, 176, 75, 0.8);
}

.marquee-container {
    background: linear-gradient(135deg, #001a33, #02150d);
    color: rgb(227, 201, 167);
    padding: 10px 0;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    overflow: hidden;
    white-space: nowrap;
}

.marquee {
    display: inline-block;
    animation: marquee 25s linear infinite;
}

@keyframes marquee {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }
}

.carousel {
    width: 100%;
    overflow: hidden;
    position: relative;
}

.carousel-container {
    display: flex;
    width: 500%;
    animation: slide 23s infinite linear;
}

.carousel img {
    width: 20%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

.carousel img:hover {
    transform: scale(1.1);
}

@keyframes slide {
    0% { transform: translateX(0); }
    25% { transform: translateX(-20%); }
    50% { transform: translateX(-40%); }
    75% { transform: translateX(-60%); }
    100% { transform: translateX(-80%); }
}

.container {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 40px 20px;
    flex-wrap: wrap;
}

.card {
    width: 300px;
    background: linear-gradient(135deg, #D4AF37, #001a33);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

.card img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    border-bottom: solid 2px #D4AF37;
}

.card-content {
    padding: 20px;
    text-align: center;
}

.card-content h3 {
    margin: 10px;
    color: #F5E1A4;
}

.card-content p {
    color: rgb(2, 19, 37);
}

.home-section {
    text-align: center;
    padding: 20px 5px;
    background: linear-gradient(135deg, #E6C55F, #002244);
    margin: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    color: rgb(2, 19, 37);
    font-size: 18px;
}

.home-section {
    height: 80px;
}
.home-section:hover{
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.home-section h2{
    color: #F5E1A4;
    margin: 0;
    text-align: center;
}
.rules-section {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg,hsl(45, 81.30%, 25.10%),rgb(0, 19, 37));
    margin: 15px auto;
    border-radius: 30px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    color: #FAFAFA;
    font-size: 24px;
    max-width: 95%;
    width: 1300px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 95%;
    height: 650px;
    font-size: 18px;
}

.rules-section:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}
.rules-section h2 {
    color: #FFD700;
    margin-bottom: 24px;
    text-transform: uppercase;
    font-size: 24px;
    letter-spacing: 1px;
}

.rules-section p {
    text-align: justify;
    font-size: 18px;
    line-height: 1.6;
    color: #F5E1A4;
    padding: 0 15px;
}

@media (max-width: 768px) {
    .rules-section {
        width: 95%;
        font-size: 16px;
        padding: 15px;
    }

    .rules-section h2 {
        font-size: 20px;
    }
}
.new-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg,hsl(45, 81.30%, 25.10%),rgb(0, 19, 37));
    color: rgb(2, 19, 37);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    margin: 20px auto;
    max-width: 95%;
    height: 600px;
    font-size: 18px;
}

.new-section:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
}

.new-section img {
    width: 95%;
    max-height: 550px;
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

.new-section .text-content {
    flex: 1;
    padding-left: 30px;
    text-align: left;
}

.new-section h2 {
    color: #FFD700;
    font-size: 32px;
    margin-bottom: 10px;
    text-align: center;
}
.new-section h3{
    color: #FFD700;
    font-size: 27px;
    margin-bottom: 10px;
    text-align: left;
}
.new-section p {
    line-height: 1.6;
    font-size: 23px;

}

.highlight {
    color: #F5E1A4;
    font-weight: bold;
}

.faq-section {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
    background: linear-gradient(135deg, #002244, #E6C55F);
    border-radius: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    color: white;
}

.faq-section h2 {
    text-align: center;
    color: #FFD700;
    font-size: 26px;
    margin-bottom: 15px;
}

.faq-item {
    margin-bottom: 10px;
    border-bottom: 1px solid #F5E1A4;
}

.faq-question {
    width: 100%;
    background:linear-gradient(135deg,hsl(84, 58.00%, 43.90%),rgb(0, 19, 37));
    color:rgb(15, 13, 0);
    padding: 15px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    border: none;
    outline: none;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
    border-radius: 5px;
}

.faq-question:hover {
    background:linear-gradient(135deg,hsl(45, 64.90%, 46.90%),rgb(0, 19, 37));
}

.faq-answer {
    display: none;
    background:linear-gradient(135deg,hsl(45, 81.30%, 25.10%),rgb(0, 19, 37));
    color:rgb(255, 254, 254);
    padding: 15px;
    border-radius: 8px;
    font-size: 20px;
    margin-top: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
.mcon{
    width: 95%;
    max-width: 1600px;
    background:linear-gradient(135deg,hsl(45, 81.30%, 25.10%),rgb(0, 19, 37));
    padding: 40px;
    border-radius: 40px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 70vh;
    margin: auto;
}
.mcon:hover{
    transform: scale(1.03);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}
.mcontainer {
    width: 90%;
    max-width: 1250px;
    background: rgba(14, 14, 14, 0.64);
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 50vh;
    margin: auto; 
}
.play-button {
    width: 50px;
    height: 50px;
    background: white;
    color: black;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 20px;
    cursor: pointer;
    transition: transform 0.2s;
}
.play-button::after {
            content: '▶';
        }
.play-button:hover {
    transform: scale(1.1);
}

.video-popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 999;
    align-items: center;
    justify-content: center;
}

.video-popup-content {
    position: relative;
    background: white;
    padding: 10px;
    border-radius: 10px;
}

.close-btn {
    position: absolute;
    top: -20px;
    right: -20px;
    background: white;
    border-radius: 50%;
    padding: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: background 0.2s;
}

.close-btn:hover {
    background: #ddd;
}

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #dcdcdc;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap:10px
        }

        .stats div {
            text-align: center;
        }

        .stats div span {
            display: block;
            font-size: 24px;
            font-weight: bold;
        }

        .divider {
            width: 1px;
            background: white;
            height: 40px;
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
                gap: 20px;
            }

            .divider {
                display: none;
            }
        }
.notification {
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    background: #fff3cd;
    border: 1px solid #ffeeba;
}

.footer {
    background: #111;
    color: white;
    padding: 80px 20px 20px;
    width: 100%;
    position: relative;
    margin-top: 50px;
    overflow: hidden;
}

.footer::before {
    content: "";
    position: absolute;
    top: -80px;
    right: 0;
    width: 120%;
    height: 250px;
    background: linear-gradient(135deg,rgb(179, 146, 46),rgb(4, 48, 92));
    transform: skewY(4deg); 
    transform-origin: top right; 
    border-top-right-radius: 150px;
    z-index: 0;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: auto;
    position: relative;
    z-index: 1;
}
.footer-section {
    width: 22%;
    min-width: 200px;
}

.brand h2 {
    font-size: 24px;
    font-weight: bold;
}

.footer-section h3 {
    font-size: 18px;
    margin-bottom: 15px;
}

.footer-section p {
    font-size: 14px;
    line-height: 1.6;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    color: white;
    text-decoration: none;
    transition: 0.3s;
}

.footer-section ul li a:hover {
    color: #38b000;
}
.social-icons a {
    display: inline-block;
    margin: 0 10px;
    transition: transform 0.3s;
}

.social-icons a img {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
}

.social-icons a:hover {
    transform: scale(1.1);
}
.footer-bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    margin-top: 20px;
    font-size: 14px;
}
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <img src="bidblitzb.png" alt="Online Auction Logo"><br>
        </div>
        <div class="header-middle">
            <img src="nmm.png" alt="Auction Logo Name">
             <!-- <a>𝔽𝕒𝕤𝕥 𝕒𝕟𝕕 ℂ𝕠𝕞𝕡𝕖𝕥𝕚𝕥𝕚𝕧𝕖 𝔹𝕚𝕕𝕕𝕚𝕟𝕘</a> -->
        </div>

    </div>
        <div class="header-right">
            <span class="user-info">Welcome,User</span>
            <a href="login.php">LogIn</a>
        </div>
    </header>
    <div class="nav-bar">
    <a href="proje.php">Home</a>
    <a href="sell.php">Sell</a>
    <a href="buy.php">Buy</a>
    <a href="accountdet.php">Manage Account</a>
    <div class="search-box">
        <form action="info.php" method="GET">
            <input type="text" name="search" placeholder="Search for a product..." required>
            <button type="submit">Search</button>
        </form>
    </div>
    </div>


    <br>
    <div class="marquee-container">
        <div class="marquee">🌟 Welcome to BidBlitz! Get the best deals on auctions. 🛒 Happy Bidding! 🎉 Limited-time offers available now ! &star;Bid with confidence, win with pride! &star; The highest bid wins, but the smartest bid conquers! &star; Turn your treasures into profit!💥</div>
    </div>
    <div class="home-section">
        <h2>Welcome to Online Auction</h2>
        <p>Discover a world of exclusive auctions where you can buy and sell rare finds, collectibles, and unique treasures.</p>
    </div>

    <div class="carousel">
        <div class="carousel-container">
            <img src="bid1.jpg" alt="Auction Item 1">
            <img src="bid22.jpg" alt="Auction Item 2">
            <img src="bid33.jpg" alt="Auction Item 3">
            <img src="bid44.jpg" alt="Auction Item 4">
            <img src="bid55.jpg" alt="Auction Item 5">
            <img src="biid6.jpg" alt="Auction Item 6">
            <img src="bid7.jpg" alt="Auction Item 7">
            <img src="bid8.jpg" alt="Auction Item 8">
            <img src="bid9.jpg" alt="Auction Item 9">
            <img src="bid10.jpg" alt="Auction Item 10">
            <img src="bid11.jpg" alt="Auction Item 11">
            <img src="almonds.jpg" alt="Auction Item 12">
            <img src="02r.png" alt="Auction Item 13">
            <img src="cashewnuts.jpg" alt="Auction Item 14">
            <img src="bananas.jpg" alt="Auction Item 15">
            <img src="apples.jpg" alt="Auction Item 16">
            <img src="pineapples.jpg" alt="Auction Item 17">
        </div>
    </div>

    <div class="container">
        <div class="card">
            <img src="home.png" alt="Home">
            <div class="card-content">
                <h3><a href="login.php" style="text-decoration: none; color: inherit;">Home</a></h3>
                <p>Here is the overview of our website displaying rules for the Auction.</p>
            </div>
        </div>
        <div class="card">
            <img src="sellimge.png" alt="Sell">
            <div class="card-content">
                <h3><a href="login.php" style="text-decoration: none; color: inherit;">Sell Your Product</a></h3>
                <p>List your item and get the best price.</p>
            </div>
        </div>
        <div class="card">
            <img src="buyimge.png" alt="Bid">
            <div class="card-content">
                <h3><a href="login.php" style="text-decoration: none; color: inherit;">Bid & Win</a></h3>
                <p>Find exclusive deals and win your favorite items.</p>
            </div>
        </div>
        <div class="card">
            <img src="myac.png" alt="Account">
            <div class="card-content">
                <h3><a href="login.php" style="text-decoration: none; color: inherit;">Manage Account</a></h3>
                <p>Keep track of your auctions and purchases.</p>
            </div>
        </div>
    </div>
    <div class="new-section">
    <div class="text-content">
        <h2>Elevate Your Expectations with <span class="highlight">BidBlitz Auction Platform</span></h2>
        <h3><strong>Why Choose <span class="highlight">BidBlitz</span> for Your Produce Trading?</strong></h3>
        
        <p>Experience a <strong class="highlight">new era of fresh produce trading</strong> with <span class="highlight">BidBlitz</span>. Sellers can expertly manage their presence by choosing <strong class="highlight">optimal auction times</strong> and setting <strong class="highlight">fair starting prices</strong> for their fruits, vegetables, and grains. This allows for a compelling showcase of products that captivates quality-focused buyers.</p>
        
        <p>Buyers can enjoy a <strong class="highlight">seamlessly streamlined experience</strong>. Explore an extensive variety of fresh produce at <strong class="highlight">competitive prices</strong> through our intuitive auction listings. With <span class="highlight">BidBlitz</span>, staying updated on upcoming auctions and effortlessly placing bids are just a few clicks away, all within the comfort of your home.</p>
        
        <p>Join a dedicated marketplace committed to <strong class="highlight">quality, transparency, and community</strong>. Engage with the <span class="highlight">BidBlitz</span> platform today and transform the way you buy and sell fresh produce!</p>
    </div>

    <div class="image-container">
        <img src="pc.jpg" alt="Auction Platform">
    </div>
</div>


    <div class="rules-section">
    <div class="text-content">
    <h2>Welcome to BidBlitz – Your Premier Grocery Auction Hub!</h2>
    <p><strong>Fresh, Affordable, and Fair – Bid for the Best Deals on Groceries!</strong></p>
    
    <p>At <strong>BidBlitz</strong>, we revolutionize the way you buy essential groceries like fresh vegetables, fruits, sugar, grains, and more. Our live auction platform ensures you get the freshest produce at <strong>unbeatable prices</strong>. <em>Bid smart, save big, and enjoy farm-fresh goodness right at your doorstep!</em></p>

    <h2>🛒 Why Choose BidBlitz?</h2>
    <p>✔ <strong>Fresh & High-Quality</strong> – Sourced directly from trusted farmers and suppliers.<br>
       ✔ <strong>Fair & Transparent</strong> – Competitive bidding ensures the best prices.<br>
       ✔ <strong>Convenient & Exciting</strong> – Real-time auctions with a seamless experience.</p>

    <h2>🔔 How It Works?</h2>
    <p>1️⃣ <strong>Browse through live auctions</strong> of fresh groceries.<br>
       2️⃣ <strong>Place Your Bids</strong> – Compete to grab the best deals.<br>
       3️⃣ <strong>Win & Save</strong> – Enjoy top-quality products at unbeatable prices!</p>

    <p><strong>💰 Start bidding today and bring home the best groceries for less!</strong></p>
    </div>
    
</div>
<div class="mcon">
<div class="mcontainer">
        <div class="play-button" onclick="showVideoPopup()"></div>
        <div class="video-popup" id="videoPopup">
        <div class="video-popup-content">
            <span class="close-btn" onclick="closeVideoPopup()">✖</span>
            <video id="bidblitzVideo" width="800" controls>
                <source src="bidblitzvid.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
        <h1>Elevate Your Fresh Produce Trading</h1>
        <p>Discover Bidblitz, the revolutionary platform that optimizes your buying and selling experiences. 
           Sellers easily set auction dates and fair prices for their offerings, ensuring maximum visibility 
           to buyers seeking quality fruits, vegetables, and grains.</p>

        <div class="stats">
            <div>
                <span>350</span>
                Unique Auctions Every Month
            </div>
            <div class="divider"></div>
            <div>
                <span>1200</span>
                Fresh Produce Listings
            </div>
            <div class="divider"></div>
            <div>
                <span>400</span>
                Satisfied Sellers
            </div>
            <div class="divider"></div>
            <div>
                <span>50</span>
                Secured Transactions
            </div>
        </div>
    </div>
    </div>
<div class="faq-section">
    <h2>Frequently Asked Questions</h2>
    
    <div class="faq-item">
        <button class="faq-question">How do I get started with BidBlitz?</button>
        <div class="faq-answer">
            <p>Simply sign up, browse available auctions, and start bidding on fresh produce. You can also list your own items for sale!</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">What types of produce can I auction?</button>
        <div class="faq-answer">
            <p>You can auction a variety of fresh produce including vegetables, fruits, grains, and sugar. Make sure your listings meet our quality standards.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">How are auction dates and base fares determined?</button>
        <div class="faq-answer">
            <p>Sellers set the auction date and base price based on market trends. Our platform may suggest optimal pricing for better sales.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">Is there a fee for using BidBlitz?</button>
        <div class="faq-answer">
            <p>While BidBlitz provides an efficient platform for selling, there may be nominal fees associated with auction listings. For detailed information, visit our <a href="#">Terms of Service</a>.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">How can I track my auction bids?</button>
        <div class="faq-answer">
            <p>You can track your bids in your dashboard under the 'My Auctions' section.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">Can I edit my auction listings after they are posted?</button>
        <div class="faq-answer">
            <p>Yes, sellers can make modifications before the auction starts. However, after bidding begins, edits are restricted.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">What should I do if I encounter issues on the platform?</button>
        <div class="faq-answer">
            <p>For any technical or listing issues, reach out to our support team via the 'Help Center' section.</p>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-section brand">
            <h2>Bidblitz</h2>
            <p>Create a platform for buying and selling fruits, vegetables, and grains through auctions, where users can set dates and base fares.</p>
            <p>📞 +91 9988776655</p>
            <p>📧 saksham.mishra2023@vitstudent.ac.in</p>
            <p>📍 VIT,Vellore,Tamil Nadu-632014</p>
        </div>

        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="firstpage.php">Home</a></li>
                <li><a href="sell.php">Seller Section</a></li>
                <li><a href="buy.php">Buyer Section</a></li>
                <li><a href="buy.php">Auction Listings</a></li>
                <li><a href="firstpage.php">About Us</a></li>
                <li><a href="firstpage.php">Contact Us</a></li>
                <li><a href="firstpage.php">FAQ</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Legal</h3>
            <ul>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-icons">
            <a href="#" target="_blank"><img src="yt.jpg" alt="YouTube"></a>
            <a href="#" target="_blank"><img src="insta.jpg" alt="Instagram"></a>
            <a href="#" target="_blank"><img src="fb.jpg" alt="Facebook"></a>
            <a href="#" target="_blank"><img src="x.jpg" alt="X (Twitter)"></a>
        </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 BIDBLITZ. All Rights Reserved.</p>
    </div>
</footer>

</body>
</html>
