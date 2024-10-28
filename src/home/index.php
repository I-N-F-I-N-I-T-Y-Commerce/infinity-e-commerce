<?php 
include("../database/INFINITY/connection.php");
session_start();

if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];
    $username = $_SESSION['username'];

    echo "$account_id Successfuly";
} 

// * REFERENCE FOR LOGOUT: https://stackoverflow.com/questions/3512507/proper-way-to-logout-from-a-session-in-php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFINITY 👟 Home</title>
    <link rel="icon" href="../public/logo_removebg_preview_q2J_icon.ico" sizes="16x16" type="image/x-icon">
    <link rel="stylesheet" href="../navigator/navigator.css">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="home-page.css">
</head>
<body>
    <!-- TODO: This HTML is a template file that has already a navigation bar and footer, make sure to follow the precise measure , and size proportions on figma -->
    
    <!-- * navigation -->
    <nav class="main-container">
        <div class="navigation-container">
            <header class="header">
                <a href="">
                    <div class="branding">
                        <div class="logo-container">
                            <img class="logo-icon" loading="lazy" alt="" src="../public/logo.svg" />
                        </div>
                        <b class="tag-name">I N F I N I T Y</b>
                    </div>
                </a>

                <?php
                if (isset($_SESSION['account_id'])) {
                    echo "
                    <a href=\"../account/my-account/index.php\">
                        <div class=\"account-container\">
                            <!-- * NOTE If user is login already this signup will exchange to his/her username -->
                            <div class=\"sign-up\">$username</div>
                            <img src=\"../public/Account.png\" alt=\"\">
                        </div>
                    </a>";
                } else {
                    echo " 
                    <a href=\"../authentication/account-sign-in.php\">
                        <div class=\"account-container\">
                            <!-- * NOTE If user is login already this signup will exchange to his/her username -->
                            <div class=\"sign-up\">Sign In</div>
                            <img src=\"../public/Account.png\" alt=\"\">
                        </div>
                    </a>";
                }
                ?>
               
            </header>
        </div>
    </nav>
    <div class="navigational-container">
        <div class="navigator">
            <ul class="list-categories">
                <li><a href="../shop/new arrivals/new-arrivals.php">New & Featured</a></li>
                <li><a href="../shop/women/women-footwear.php">Women</a></li>
                <li><a href="../shop/men/men-footwear.php">Men</a></li>
                <li><a href="../shop/kids/kids-footwear.php">Kids</a></li>
                <li><a href="../shop/sale/sale-footwear.php">Sale</a></li>
            </ul>
    
            <div class="search-bar">
                <form action="../shop/search/search_query.php" method="GET"> 
                    <input class="inp-search" type="text" name="user_search" placeholder="Search" required> 
                    <div class="image-container">
                        <?php 
                         if (isset($_SESSION['account_id'])) {
                            echo "
                    
                            <button type=\"submit\" id=\"search-btn\" style=\"background: none; border: none;\"> 
                                <img src=\"../public/loupe-1@2x.png\" alt=\"Search icon\">
                            </button>
                            

                            <a href=\"../account/my-wishlist/index.php\">
                                <button type=\"button\" id=\"favorite-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../public/heart-1-1@2x.png\" alt=\"Favorite icon\">
                                </button>
                            </a>

                            <a href=\"../account/my-order/index.php\">
                                <button type=\"button\" id=\"cart-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../public/market-1@2x.png\" alt=\"Cart icon\">
                                </button>
                            </a>
                            ";
                        } else {
                            echo " 
                           
                            <button type=\"submit\" id=\"search-btn\" style=\"background: none; border: none;\"> 
                                <img src=\"../public/loupe-1@2x.png\" alt=\"Search icon\">
                            </button>
                           

                            <a href=\"../authentication/account-sign-in.php\">
                                <button type=\"button\" id=\"favorite-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../public/heart-1-1@2x.png\" alt=\"Favorite icon\">
                                </button>
                            </a>

                            <a href=\"../authentication/account-sign-in.php\">
                                <button type=\"button\" id=\"cart-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../public/market-1@2x.png\" alt=\"Cart icon\">
                                </button>
                            </a>
                            ";
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <!-- * navigation -->
    
    <!-- * Main Container -->
    <main>
        <div class="main-container">
            <!-- TODO Banner 1 -->
            <div class="banner1">
                <img src="../public/HOME-BANNER1-IMG-0001 (1).png" id="banner1-img1" alt="">
                <img src="../public/HOME-BANNER1-IMG-0002.png" id="banner1-img2" alt="">
                <img src="../public/HOME-BANNER1-IMG-0004.png" id="banner1-img3" alt="">
                <img src="../public/HOME-BANNER1-IMG-0003.png" id="banner1-img4" alt="">
                <h1><span id="banner-highlight2">Suite</span> Your <span id="banner-highlight1">Style</span></h1>
                <h3>Choose a Classic Pair that does it all</h3>
                <button>Shop</button>
            </div>

            <!-- TODO: Product in new Arrivals -->
            <div class="new-arrivals-container">
                <div class="upper-container">
                    <h3>Shop In Style</h3>
                    <div class="page-navigation">
                        <div class="img-container">
                                <img src="../public/ICON-NEXT-PAGE.png" alt="">
                        </div>
                        <h3>Shop All New Arrivals</h3>
                    </div>
                </div>

                <!-- TODO: Loop products here on php -->
                <div class="product-container">

                    <div class="shoe-product-card">
                        <div class="shoe-img-container">
                            <img src="../public/Shoes/Group 61.png" alt="">
                        </div>
                        <div class="add-to-cart-container">
                            <div class="add-to-cart-btn">
                                <p>ADD TO CART</p>
                            </div>
                            <div class="add-to-cart-icon">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>

                    
                    <div class="shoe-product-card">
                        <div class="shoe-img-container">
                            <img src="../public/Shoes/Group 60.png" alt="">
                        </div>
                        <div class="add-to-cart-container">
                            <div class="add-to-cart-btn">
                                <p>ADD TO CART</p>
                                
                            </div>
                            <div class="add-to-cart-icon">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="shoe-product-card">
                        <div class="shoe-img-container">
                            <img src="../public/Shoes/Group 62.png" alt="">
                        </div>
                        <div class="add-to-cart-container">
                            <div class="add-to-cart-btn">
                                <p>ADD TO CART</p>
                            </div>
                            <div class="add-to-cart-icon">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="shoe-product-card-special">
                        <img src="../public/Shoes/45d74ea93803840a57c5aa3b453d2a73 1.png" alt="">
                        <div class="price-container">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TODO Banner 2 finish toms good nighty -->
            <div class="banner2">
                    <img src="../public/HOME-BANNER2-IMG-0003.jpg" id="banner2-img1" alt="">
                    <img src="../public/HOME-BANNER2-IMG-0002.jpg" id="banner2-img2" alt="">
                    <img src="../public/HOME-BANNER2-IMG-0001.jpg" id="banner2-img3" alt="">
                    <div class="container1">
                        <h2>Sunny Pair's</h2>
                        <center><p>The Favorite Sun flower shoes is back and in Sales!.</p></center>
                        <button>Shop</button>
                    </div>
            </div>

            <!-- TODO: Just put a anchoring on each category Cards -->
            <div class="categories-container">
                <div class="ewan-na-sign">
                    <h1>- In The New Footwear -</h1>
                </div>
                <div class="categories">
                    <div class="men">
                        <img src="../public/HOME-IMG-MEN-0002.jpg" alt="">
                        <div class="container">
                            <h2>Men's <span class="highlight">Foot Wear</span></h2>
                        </div>
                    </div>
                    <div class="women">
                        <img src="../public/HOME-IMG-WOMEN-0001.jpg" alt="">
                        <div class="container">
                            <h2>Women's <span class="highlight">Foot Wear</span></h2>
                        </div>
                    </div>
                    <div class="kids">
                        <img src="../public/HOME-IMG-KIDS-0003.jpg" alt="">
                        <div class="container">
                            <h2>Kid's <span class="highlight">Foot Wear</span></h2>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="banner3">
                <div class="image-container">
                    <img src="../public/HOME-BANNER3-IMAGE.png" alt="">
                    <div class="price-container">
                        
                    </div>
                    <img src="../public/Shoes/Group63.png" id="owo" alt="">
                </div>
                <div class="lower-container">
                    <div class="page-navigation">
                        <h3>Buy Stary Night Shoe</h3>
                        <div class="img-container">
                                <img src="../public/ICON-NEXT-PAGE.png" alt="">
                        </div>
                    </div>
                    <div class="painter-name">
                        <img src="../public/Van gogh.png" alt="">
                        <h1>NEW</h1>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- * Main Container -->







    <!-- * footer -->
    <footer class="main-container">

        <footer class="footer-container">

            <section class="information-footer">
                <!-- * container-1 -->
                <div class="infinity-wrapper">
                    <div class="word-logo">I N F I N I T Y</div>
                    <div class="updates">
                        <span>
                            For more Updates you can check our Social Media Pages for latest
                            Events
                        </span>
                    </div>
                    <img class="soc-med-icons" loading="lazy" alt="" src="../public/soc-med-pages.svg" />
                </div>
                <!-- * container-1 -->


                <!-- * container-2 -->
                <div class="resources-container">
                    <a class="resources">Resources</a>
                    <div class="membership">
                        <a class="send-us-feedback">Send us Feedback</a>
                        <div class="become-a-member">Become a Member</div>
                    </div>
                </div>
                <!-- * container-2 -->

                
                <!-- * container-3 -->
                <div class="help-parent">
                    <a class="help">Help</a>
                    <div class="support-options">
                        <a class="contact-us">Contact Us</a>
                        <a class="contact-us">Get Help</a>
                        <div class="order-status">Order Status</div>
                    </div>
                </div>
                <!-- * container-3 -->


                <!-- * container-4 -->
                <div class="company-container">
                    <div class="company">Company</div>
                    <div class="company-info">
                        <a class="about">About</a>
                        <a class="news">News</a>
                        <a class="careers">Careers</a>
                    </div>
                </div>
                <!-- * container-4 -->
            </section>
        </footer>

        <div class="term-footer-container">

            <section class="terms-footer">
                <!-- * container-1 -->
                <div class="legal">
                    <div class="privacy-policy">Privacy Policy & Terms of Use</div>
                </div>
                <!-- * container-1 -->


                <!-- * container-2 -->
                <div class="copyright">
                    <div class="all-rights-reserved">
                        <div class="c">C</div>
                        <div class="infinity-inc-all">INFINITY, Inc. All rights reserved 2024 - 2025
                        </div>
                    </div>
                </div>
                <!-- * container-2 -->

                <!-- * container-3 -->
                <div class="cookie-policy-wrapper">
                    <div class="cookie-policy">Cookie Policy</div>
                    <img class="cookie-icon" loading="lazy" alt="" src="../public/cookie-1@2x.png" />
                </div>
                <!-- * container-3 -->
            </section>
        </div>

    </footer>
    
    <!-- * footer -->
</body>
</html>