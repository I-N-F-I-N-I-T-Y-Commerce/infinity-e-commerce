<?php 
include("../../database/INFINITY/connection.php");
include("../../components/render-product/render.php");

session_start();

if (isset($_GET['user_search'])) {
    $user_searched = $_GET['user_search'];

    $result = search_for($conn, $user_searched);
    $num_of_results = mysqli_num_rows($result);
} else {
    $result = '';
    $num_of_results = 0;
}

if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];
    $username = $_SESSION['username'];

    echo "$account_id Successfuly";
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFINITY 👟🪄</title>
    <link rel="icon" href="../public/logo_removebg_preview_q2J_icon.ico" sizes="16x16" type="image/x-icon">
    <link rel="stylesheet" href="../products-page.css">
    <link rel="stylesheet" href="../../global.css">
    <link rel="stylesheet" href="../../navigator/navigator.css">
    <link rel="stylesheet" href="../../footer/footer.css">
</head>

<body>
    <!-- * navigation -->
    <nav class="main-container">
        <div class="navigation-container">
            <header class="header">
                <a href="../../home/index.php">
                    <div class="branding">
                        <div class="logo-container">
                            <img class="logo-icon" loading="lazy" alt="" src="../../public/logo.svg" />
                        </div>
                        <b class="tag-name">I N F I N I T Y</b>
                    </div>
                </a>
                <?php
                if (isset($_SESSION['account_id'])) {
                    echo "
                    <a href=\"../../account/my-account/index.php\">
                        <div class=\"account-container\">
                            <!-- * NOTE If user is login already this signup will exchange to his/her username -->
                            <div class=\"sign-up\">$username</div>
                            <img src=\"../../public/Account.png\" alt=\"\">
                        </div>
                    </a>";
                } else {
                    echo " 
                    <a href=\"../../authentication/account-sign-in.php\">
                        <div class=\"account-container\">
                            <!-- * NOTE If user is login already this signup will exchange to his/her username -->
                            <div class=\"sign-up\">Sign In</div>
                            <img src=\"../../public/Account.png\" alt=\"\">
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
                <li><a href="../new arrivals/new-arrivals.php">New & Featured</a></li>
                <li><a href="../women/women-footwear.php">Women</a></li>
                <li><a href="../men/men-footwear.php">Men</a></li>
                <li><a href="../kids/kids-footwear.php">Kids</a></li>
                <li><a href="../sale/sale-footwear.php">Sale</a></li>
            </ul>
    
            <div class="search-bar">
                <form action="../search/search_query.php" method="GET"> 
                    <input class="inp-search" type="text" name="user_search" placeholder="Search" required> 
                    <div class="image-container">
                    <?php 
                         if (isset($_SESSION['account_id'])) {
                            echo "
                    
                            <button type=\"submit\" id=\"search-btn\" style=\"background: none; border: none;\"> 
                                <img src=\"../../public/loupe-1@2x.png\" alt=\"Search icon\">
                            </button>
                            

                            <a href=\"../../account/my-wishlist/index.php\">
                                <button type=\"button\" id=\"favorite-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../../public/heart-1-1@2x.png\" alt=\"Favorite icon\">
                                </button>
                            </a>

                            <a href=\"../../account/my-order/index.php\">
                                <button type=\"button\" id=\"cart-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../../public/market-1@2x.png\" alt=\"Cart icon\">
                                </button>
                            </a>
                            ";
                        } else {
                            echo " 
                           
                            <button type=\"submit\" id=\"search-btn\" style=\"background: none; border: none;\"> 
                                <img src=\"../../public/loupe-1@2x.png\" alt=\"Search icon\">
                            </button>
                           

                            <a href=\"../../authentication/account-sign-in.php\">
                                <button type=\"button\" id=\"favorite-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../../public/heart-1-1@2x.png\" alt=\"Favorite icon\">
                                </button>
                            </a>

                            <a href=\"../../authentication/account-sign-in.php\">
                                <button type=\"button\" id=\"cart-btn\" style=\"background: none; border: none;\"> 
                                    <img src=\"../../public/market-1@2x.png\" alt=\"Cart icon\">
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
            <div class="category-welcome">
                <h1><span class="highlight2">Search</span></h1>
                <p>From  <span class="highlight2">Aesthetic</span> to new searches, our most-popular shoes and clothing styles are <span class="highlight1">ready to shop and find.</span></p>
            </div>

            <div class="results-container">
                <div class="num-results">
                    <?php 
                    echo "<p> $num_of_results <span class=\"highlight2\">Results</span></p>";
                    ?>
                </div>

                <div class="dropdown-results">
                    <p>Sort By: <span class="highlight2">Position</span></p>
                    <img src="../../public/downward-arrow.png" alt="">
                </div>
            </div>

            <!-- TODO: Main Product Display | Use PHP for displaying product cards in each using for loop -->
            <div class="product-display">
                <?php 
                    render($conn, $num_of_results, $result);
                ?>
                </div>
            <!-- TODO: Main Product Display  -->
        </div>
        <script src="../../components/like/like.js"></script>
        <script src="../navigator/navigator.js"></script>
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
                    <img class="soc-med-icons" loading="lazy" alt="" src="../../public/soc-med-pages.svg" />
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
                    <img class="cookie-icon" loading="lazy" alt="" src="../../public/cookie-1@2x.png" />
                </div>
                <!-- * container-3 -->
            </section>
        </div>

    </footer>
    
    <!-- * footer -->

</body>

</html>