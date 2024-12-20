<?php 
include("../../database/INFINITY/connection.php");
include("../../components/render-product/render.php");

session_start();

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
    <title>INFINITY 👟 Account Inbox</title>
    <link rel="icon" href="../../public/logo_removebg_preview_q2J_icon.ico" sizes="16x16" type="image/x-icon">
    <link rel="stylesheet" href="../../footer/footer.css" />
    <link rel="stylesheet" href="../../navigator/navigator.css" />
    <link rel="stylesheet" href="../../global.css" />
    <link rel="stylesheet" href="../account.css" />
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
            </header>
        </div>
    </nav>
    <div class="navigational-container">
        <div class="navigator">
            <ul class="list-categories">
                <li><a href="../../shop/new arrivals/new-arrivals.php">New & Featured</a></li>
                <li><a href="../../shop/women/women-footwear.php">Women</a></li>
                <li><a href="../../shop/men/men-footwear.php">Men</a></li>
                <li><a href="../../shop/kids/kids-footwear.php">Kids</a></li>
                <li><a href="../../shop/sale/sale-footwear.php">Sale</a></li>
            </ul>
    
            <div class="search-bar">
                <form action="../../shop/search/search_query.php" method="GET"> <!-- Change the action to your search handling URL -->
                    <input class="inp-search" type="text" name="user_search" placeholder="Search" required> <!-- Add name attribute for form submission -->
                    <div class="image-container">
                        <button type="submit" id="search-btn" style="background: none; border: none;"> <!-- Change to button for better semantics -->
                            <img src="../../public/loupe-1@2x.png" alt="Search icon">
                        </button>
                        <button type="button" id="favorite-btn" style="background: none; border: none;"> <!-- Change to button for better semantics -->
                            <img src="../../public/heart-1-1@2x.png" alt="Favorite icon">
                        </button>
                        <?php
                        if (isset($_SESSION['account_id'])) {
                            echo '
                                <button type="button" id="cart-btn" class="cart-button" style="background: none; border: none;"> <!-- Change to button for better semantics -->
                                    <img src="../../public/market-1@2x.png" alt="Cart icon">
                                </button>
                            ';
                        } else {
                            echo '
                            <a href="../../authentication/account-sign-in.php">
                                <button type="button" id="cart-btn" style="background: none; border: none;"> <!-- Change to button for better semantics -->
                                    <img src="../../public/market-1@2x.png" alt="Cart icon">
                                </button>
                            </a>
                            ';
                        }
                        ?>
                    </div>
                </form>

                <div class="popper not-visible">
                    <div class="cart-container">
                        <div class="cart-header">
                            <?php
                                echo renderTotalPrice($conn, $account_id);
                            ?>
                        </div>
                        <div class="cart-items">
                            <!-- Cart Item 1 -->
                            <?php
                                renderCart($conn, $account_id);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * navigation -->

    <main>
        <div class="main-container">
            <div class="user-profile-acc-container">

                <div class="account-container">
    
                    <!-- TODO Account Navigation Container -->
                    <div class="account-nav-container">
                        <!-- * profile and username -->
                        <div class="profile-container">
                            <div class="account-profile-container">
                                <img src="../../public/user-profile/Example User Profile.jpg" alt="">
                            </div>
                            <?php
                                if (isset($_SESSION['account_id'])) {
                                    echo "<div class=\"account-username\">$username</div> ";
                                } else {
                                    echo "<div class=\"account-username\">Guest</div> ";
                                }
                            ?>
                        </div>
                        
                        <!-- * navigation box -->
                        <div class="ma-nav-btn-container">
                            <div class="navigation-btn not-current" id="my-account">
                                <a href="../my-account/index.php" class="ma-account-btn not-current">                                    
                                    <img src="../../public/user-profile/account.png" alt="" id="my-account-btn">
                                    <p>My Account</p>
                                </a>
                            </div>
                            <div class="navigation-btn not-current" id="my-orders">
                                <a href="../my-order/index.php" class="ma-orders-btn not-current">                                    
                                    <img src="../../public/user-profile/orders.png" alt="" id="my-orders-btn">
                                    <p>My Orders</p>
                                </a>
                            </div>
                            <div class="navigation-btn not-current" id="my-wishlist">
                                <a href="../my-wishlist/index.php" class="ma-wishlist-btn not-current">                                    
                                    <img src="../../public/user-profile/wishlist.png" alt="" id="my-wishlist-btn">
                                    <p>My WishList</p>
                                </a>
                            </div>
                            <div class="navigation-btn current" id="my-inbox">
                                <a href="" class="ma-inbox-btn current">   
                                    <img src="../../public/user-profile/inbox-b.png" alt="" id="my-inbox-btn">
                                    <p>My Inbox</p>
                                </a>
                            </div>
                        </div>
                        <script src="../account.js"></script>
                    </div>

                    <div id="myInbox"  class="inbox-container">
                        <?php 
                        echo "<h1 class=\"mi-acc-status\"><span>You have 0 Messages</span>, $username</h1>"
                        ?>
                        <div class="mi-message-box">
                            <!-- * Automatic height adjustment activated  -->
                            <!-- <div class="message-container"></div>
                            <div class="message-container"></div>
                            <div class="message-container"></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../navigator/navigator.js"></script>
    </main>

    <!-- * footer -->
    <footer class="main-container">

        <footer class="footer-container">

            <section class="information-footer">
                <!-- * container-1 -->
                <div class="infinity-wrapper">
                    <div class="word-logo">I N F I N I T Y</div>
                    <div class="updates">
                            For more Updates you can check our Social Media Pages for latest Events
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