<?php
session_start();
if(!isset($_SESSION["First_name"])){
    header("Location: login.html"); // Redirect user if not logged in
    exit;
}

$First_name = htmlspecialchars($_SESSION["First_name"]); // Retrieving and escaping first name from the session
$Email = htmlspecialchars($_SESSION["Email"]);
$Last_name = htmlspecialchars($_SESSION["Last_name"]);

// Function to display Greeting based on time of day
function Greeting(){
    $hour = date("H");
    if($hour < 12){
        return "Good Morning";
    } elseif($hour < 16){
        return "Good Afternoon";
    } else {
        return "Good Evening";
    }
}
$greeting = Greeting();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/788ae1b15b.js" crossorigin="anonymous"></script>
</head>
<body>
    <!----------------Above the fold------------>
    <div id="header">
       <div class="container">
        <nav>
            <img src="logo2.png" class="Logo">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#feature_list">Recipes</a></li>
                <li><a href="#">Contacts</a></li>


                <ul class="dropdown">
                
                        <span class="user_icon">
                            <?php echo strtoupper($First_name[0]); ?>
                        </span>
                        
                   
                    <div class="dropdown-content">
                        <a href="">
                        Name: <?php echo $First_name . " " . $Last_name; ?>
                        Email: <?php echo $Email; ?>
                        </a>
                        <a href="logout.php">Log out</a>
                    </div>
                </li>


            </ul>
        </nav>
        <div class="header-text">
            <h1 style="font-size: 50px; padding-bottom: 100px;" class="greetings_text">
                 <?php echo $greeting . " " . $First_name; ?>
            </h1>
            <p>Let's Cook</p>
            <h1>A Delicious <span>Brunch</span><br> For a Happy <span>Bunch</span></h1>
            <button type="button">Explore</button>
        </div>
       </div>
    </div>
    <!-------------------Benefit List------------------->
    <div id="benefitList">
        <div class="container">
            <h1 class="sub-title">Benefit List</h1>
            <div class="benefit-list">
                <div>
                    <i class="fa-solid fa-bowl-food"></i>
                    <h2>Endless Recipe Inspiration</h2>
                    <p>Explore a vast collection of recipes to discover new dishes and cooking techniques</p>
                    <a href="#">Learn More</a>
                </div>
                <div>
                    <i class="fa-solid fa-burger"></i>
                    <h2>Step-by-Step Instructions</h2>
                    <p>Clear, easy to follow instructions to ensure success whether you are a beginner or an experienced chef</p>
                    <a href="#">Learn More</a>
                </div>
                <div>
                    <i class="fa-solid fa-cloud-meatball"></i>
                    <h2>Expert Advice</h2>
                    <p>Access expert advice from professional chefs and nutritionists, offering insights and recommendations to elevate your cooking skills.</p>
                    <a href="#">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <!----------------------Feature List--------------------->
    <div id="feature_list">
        <div class="container">
            <h1 class="sub-title">What We Do</h1>
            <div class="features">
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/drinks.jpg">
                    <div class="layer">
                        <h3>Drinks</h3>
                        <p>Never chase anything but drinks and dreams</p>
                        <a href="drinks.php"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/pasta.jpg">
                    <div class="layer">
                        <h3>Pasta</h3>
                        <p>Twirl, slurp and savor the flavor</p>
                        <a href="pasta.php"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/Vegereriandishes.jpg">
                    <div class="layer">
                        <h3>Vegetarian dishes</h3>
                        <p>Vegetarianism for peace - nonviolence begins with your diet</p>
                        <a href="vegeterian.php"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/dessert.jpg">
                    <div class="layer">
                        <h3>Dessert</h3>
                        <p>Indulge in dessert heaven with these delights</p>
                        <a href="#"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/steak.jpg">
                    <div class="layer">
                        <h3>Steak</h3>
                        <p>When life is at stake, give everything you've got</p>
                        <a href="#"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/soups.jpg">
                    <div class="layer">
                        <h3>Soups</h3>
                        <p>The perfect way to keep your spirits up on a cold winter day</p>
                        <a href="soup.php"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/burger.jpg">
                    <div class="layer">
                        <h3>Burgers</h3>
                        <p>Happiness between two buns. Burgers are the best way to a person's heart</p>
                        <a href="burgers.php"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
                <div class="feature">
                    <img src="Emmanuel Oringe 161309 FeatureList/Chicken.jpg">
                    <div class="layer">
                        <h3>Chicken Dishes</h3>
                        <p>Nothing beats a cozy night in with some piping hot tandoori chicken and a good movie</p>
                        <a href="#"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---------------Trust Indicators----------------->
    <div id="trust-indicators">
        <div class="container">
            <h1 class="sub-title">Our Partners</h1>
            <div class="partners">
                <div class="partner1">
                    <img src="Emmanuel Oringe 161309 Trust Indicators/trust1.jpg">
                </div>
                <div class="partner2">
                    <img src="Emmanuel Oringe 161309 Trust Indicators/trust2.jpg">
                </div>
                <div class="partner3">
                    <img src="Emmanuel Oringe 161309 Trust Indicators/trust3.jpg">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
