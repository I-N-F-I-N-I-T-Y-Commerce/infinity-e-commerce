<?php
include("../database/INFINITY/connection.php");
session_start();

// $num_of_results = mysqli_num_rows($result);
if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];
    $username = $_SESSION['username'];

    echo "$account_id Successfuly";
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $result = get_product_information($conn, $product_id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    echo "<title>INFINITY 👟 ". $result["shoe_name"] ."</title>"
    ?>
    <link rel="icon" href="../../public/logo_removebg_preview_q2J_icon.ico" sizes="16x16" type="image/x-icon">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../navigator/navigator.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="product-overview.css">
</head>
<body>
     <!-- * navigation -->
     <nav class="main-container">
        <div class="navigation-container">
            <header class="header">
                <a href="../home/index.php">
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

    <!-- <?php
        echo "<h1>" . $result['shoe_name'] . "</h1>";  
    ?> -->

    <main>
        <div class="main-container">
            <div class="product-container">


                <!-- * upper section -->
                <div class="product-description-container">
                        <div class="left-side-container">
                            <div class="product-image-container">
                                <?php 
                                    echo " <img src=\"". $result["shoe_image"] ."\" alt=\"\">"
                                ?>
                                <img src="../public/Shoes/Group 60.png" alt="">
                            </div>

                            <div class="quanty-container">
                                <div class="container-increment">
                                   <img src="../public/downward-arrow.png" alt="">
                                </div>
                                <div class="quanty-get">
                                    <span id="num-get">1</span>
                                </div>
                                <div class="container-decrement">
                                    <img src="../public/downward-arrow.png" alt="">
                                </div>
                                
                                <div class="quantity">
                                    <?php 
                                    echo "<span>". $result["quantity"] ."</span>"
                                    ?>
                                </div>
                            </div>

                            <div class="buy-container">
                                <div class="buy-item">
                                    <span>Buy Item</span>
                                </div>
                                <div class="add-to-cart">
                                    <img src="../public/shopping-bag (1).png" alt="">
                                </div>
                                <div class="add-to-wishlist">
                                    <img src="../public/heart (6).png" alt="">
                                </div>
                            </div>
                        </div>

                        <?php 
                            echo "
                                <div class=\"right-side-container\">
                                    <span id=\"product-brand\">". $result["shoe_brand"] ."</span>
                                    <span id=\"product-name\">". $result["shoe_name"] ."</span>
                                    <div class=\"num-review-container\">
                                        <img src=\"../public/star.png\" alt=\"\" class=\"star1\">
                                        <img src=\"../public/star.png\" alt=\"\" class=\"star2\">
                                        <img src=\"../public/star.png\" alt=\"\" class=\"star3\">
                                        <img src=\"../public/star.png\" alt=\"\" class=\"star4\">
                                        <img src=\"../public/star (3).png\" alt=\"\" class=\"star5\">
                                        <span class=\"num-review\">0 Reviews</span>
                                    </div>
                                    <span id=\"product-price\"> ₱ ". number_format($result["shoe_price"],2) ."</span>
                                    <span id=\"product-descri\">Product Description</span>

                                    <div class=\"product-description\">
                                        <span id=\"description\">". $result["shoe_detail"] ."</span>
                                    </div>
                                </div>
                            ";
                        ?>
                        <!-- <div class="right-side-container">
                            <span id="product-brand">Nike</span>
                            <span id="product-name">Climax Nike</span>
                            <div class="num-review-container">
                                <img src="../public/star.png" alt="" class="star1">
                                <img src="../public/star.png" alt="" class="star2">
                                <img src="../public/star.png" alt="" class="star3">
                                <img src="../public/star.png" alt="" class="star4">
                                <img src="../public/star (3).png" alt="" class="star5">
                                <span class="num-review">42 Reviews</span>
                            </div>
                            <span id="product-price"> ₱ 1,200</span>
                            <span id="product-descri">Product Description</span>

                            <div class="product-description">
                                <span id="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab officia explicabo doloremque laudantium, nostrum quod. Autem exercitationem, ducimus eum dolorum possimus cum iure explicabo vel earum. Optio delectus qui ratione? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Obcaecati, quibusdam voluptatibus! Alias quas, tempore laudantium necessitatibus quam repellat aspernatur quia magnam minima, quaerat, eius omnis labore perspiciatis hic totam. Illo. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum maiores enim sequi accusamus ducimus quo provident sapiente illum quae aut temporibus consectetur, ipsam a, sed excepturi quis dolor. Dolorem, eos!</span>
                            </div>
                        </div> -->
                </div>
                <!-- * upper section -->



                <!-- * middle section  -->
                <div class="customer-review-container">

                </div>
                <!-- * middle section  -->


                
                <!-- * lower part section  -->
                <div class="recommended-categorized-shoes-container">

                </div>
                <!-- * lower part section  -->
                

            </div>
        </div>
    </main>


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