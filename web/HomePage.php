<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="with=device-width", initial-scale="1.0">
    <title>Livestock Website</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section class="header">
        <nav>
            <a href="HomePage.php"><img src="logo.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="">HOME</a></li>
                    <li><a href="#about-us">ABOUT</a></li>
                    <li><a href="LoginPage.php">LOGIN</a></li>
                    <li><a href="Register.php">REGISTER</a></li>   
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>

    <div class="text-box">
        <h1>Welcome to Livestock Website</h1>
        <p></p>
        <a href="" class="hero-btn ">Visit Us To know More</a>
    </div>
    </section>

   <!---About section--->

    <section class="about" id="about-us">
        <h1>About Us</h1>

        <div class="row">
            <div class="about-col">
                <h3>Provide</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque et tortor sit amet odio dapibus interdum. Fusce rhoncus risus eu dui tristique,
                     at pretium mauris facilisis. Nullam fringilla urna et dui mattis, et mollis nulla accumsan. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; 
                     Vivamus ullamcorper commodo quam nec porttitor.</p>
            </div>
            <div class="about-col">
                <h3>Mission</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque et tortor sit amet odio dapibus interdum. Fusce rhoncus risus eu dui tristique,
                     at pretium mauris facilisis. Nullam fringilla urna et dui mattis, et mollis nulla accumsan. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; 
                     Vivamus ullamcorper commodo quam nec porttitor.</p>
            </div>
            <div class="about-col">
                <h3>Vision</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque et tortor sit amet odio dapibus interdum. Fusce rhoncus risus eu dui tristique,
                     at pretium mauris facilisis. Nullam fringilla urna et dui mattis, et mollis nulla accumsan. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; 
                     Vivamus ullamcorper commodo quam nec porttitor.</p>
            </div>
        </div>
    </section>

    <!---Information section--->

    <section class="Information">
        <h1>Our Information</h1>

        <div class="row">
            <div class="Information-col">
                <img src="images/cow1.png">
                <h3>Outdoor study space</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Quisque et tortor sit amet odio dapibus interdum.</p>
            </div>
            <div class="Information-col">
                <img src="images/pig1.png">
                <h3>Cafeteria</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Quisque et tortor sit amet odio dapibus interdum.</p>
            </div>
            <div class="Information-col">
                <img src="images/pig1.png">
                <h3>Library</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Quisque et tortor sit amet odio dapibus interdum.</p>
            </div>
        </div>

    </section>

    <!---Footer section--->

    <section class="footer">
        <h4>You can reach us on these websites</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Quisque et tortor sit amet odio dapibus interdum.</p>
        <div class="icons">
            <i class="fa fa-facebook"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-instagram"></i>
            <i class="fa fa-linkedin"></i>
        </div>
        <p>All Rights Reserved. Livestock Website</p>
    </section>


    <!---JS for Toggle Menu for smaller screen--->
    <script>
        var navLinks = document.getElementById("navLinks");

        function showMenu(){
            navLinks.style.right = "0";
        }
        function hideMenu(){
            navLinks.style.right = "-200px";
        }
    </script>
</body>
</html>