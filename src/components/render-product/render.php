<?php
    /**
     * Render all of the results in very easy way , and the important is tutel 🐢✨
     */
    function render($conn, $num_of_results, $result) {
        if ($num_of_results > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo card($conn ,$row);
            }
        }
    };

    function card($conn, $row) {
        $status = check_status($row);

        if (isset($_SESSION['account_id'])) {
            $like_record = recordExist($conn, $row["product_id"], $_SESSION['account_id']);

            $like_status = ($like_record->liked) ? 7 : 6;
        } else {
            $like_status = 6;
        }
       
        return '
                <div class="product-card">
                    <div class="shoe-image-container">
                        <img src="'. $row["shoe_image"] .'" alt="">
                        <a href="../../product-overview/product-overview.php?product_id='. $row["product_id"]  .'">
                            <div class="shoe-price-name-detail-container">
                                <div class="shoe-name-container">
                                    <span>'. $row["shoe_name"] .'</span>
                                </div>
                                <div class="price-status-container">
                                    <div class="shoe-price-container">
                                        '. shoePriceContainerChilds($status, $row) .'
                                    </div>
                                    <div class="shoe-status '. $status['shoe_status'] .'">
                                        <span> '. $status['shoe_status_pan'] .'</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="add-to-cart-container">
                            <img src="../../public/shopping-bag (1).png" id="add-to-cart"  alt="">
                            <img src="../../public/heart ('. $like_status .').png" id="wishlist" class="add-to-favorites" data-id="'. $row["product_id"] .'" alt="">
                        </div>
                    </div>
                </div>
            ';
    }

    function shoePriceContainerChilds($status, $row) {
        $original_price = $row['shoe_price'];

        if ($status['shoe_status'] == 'sale') {
            $discounted_price = calculate_discount($original_price);
            return '
                <span class = "original-price-crossing">₱ '. number_format($original_price,2) .'</span>
                <span>₱ '. number_format($discounted_price,2) .'</span>
            ';
        }

        return '
            <span>₱ '. $original_price .'</span>
        ';
      
    }

    function recordExist($conn, $product_id, $user_id) {
        $exist = $conn->prepare("
            SELECT product_id, user_id, liked FROM wishlist
            WHERE product_id = ? AND user_id = ?
        ");

        $exist->bind_param("ii", $product_id, $user_id);
        $exist->execute();
        
        /** @var int|null $fetched_product_id */
        /** @var int|null $fetched_user_id */
        /** @var int|null $liked */
        $exist->bind_result($fetched_product_id, $fetched_user_id, $liked);
    
        if ($exist->fetch()) {
            $result = [
                "product_id" => $fetched_product_id,
                "account_id" => $fetched_user_id,
                "liked" => $liked
            ];
            $exist->close();
            return (object)$result; 
        }
    
        $exist->close();
        return (object)[
            "product_id" => null,
            "account_id" => null,
            "liked" => 0
        ];
    }

    function renderProduct($conn, $result) {
        echo leftSideContainer($conn, $result);
        echo rightSideContainer($conn, $result);
    }

    function leftSideContainer($conn, $result) {
        if (isset($_SESSION['account_id'])) {
            $like_record = recordExist($conn, $result["product_id"], $_SESSION['account_id']);

            $like_status = ($like_record->liked) ? 7 : 6;
        } else {
            $like_status = 6;
        }

        return '
            <div class="left-side-container">
                <div class="product-image-container"> 
                    <img src="'. $result["shoe_image"] .'" alt="">
                </div>

                <div class="quanty-container">
                    <div class="container-increment">
                        <img src="../public/downward-arrow.png" alt="">
                    </div>
                    <div class="quanty-get">
                        <span id="num-get" data-product-id="'. $result["product_id"] .'">1</span>
                    </div>
                    <div class="container-decrement">
                        <img src="../public/downward-arrow.png" alt="">
                    </div>
                    
                    <div class="quantity">
                        <span id="product-quantity">'. $result["quantity"] .'</span>
                    </div>
                </div>

                <div class="buy-container">
                    '. buyItemSignInDetection() .'
                    '. addToCartSignInDetection() .'
                    <div class="add-to-wishlist">
                        <img src="../public/heart ('. $like_status .').png" id="wishlist" class="add-to-favorites" data-id="'. $result["product_id"] .'" alt="">
                    </div>
                </div>
            </div>
        ';
    }

    function rightSideContainer($conn, $result) {
        $rating = getProductRating($conn, $result);

        return '
            <div class="right-side-container">
                <span id="product-brand">'. $result["shoe_brand"] .'</span>
                <span id="product-name">'. $result["shoe_name"] .'</span>
                <div class="num-review-container">
                    <img src="../public/star.png" alt="" data-id="1" class="star1 ">
                    <img src="../public/star.png" alt="" data-id="2" class="star2 ">
                    <img src="../public/star.png" alt="" data-id="3" class="star3 ">
                    <img src="../public/star.png" alt="" data-id="4" class="star4 ">
                    <img src="../public/star (3).png" alt="" data-id="5" class="star5 ">
                    <span class="num-review">'. $rating['num_ratings'] .' Reviews</span>
                </div>
                <span id="product-price"> ₱ '. productPrice($result) .'</span>
                <span id="product-descri">Product Description</span>

                <div class="product-description">
                    <span id="description">'. $result["shoe_detail"] .'</span>
                </div>
            </div>
        ';
    };

    function buyItemSignInDetection() {
        if (isset($_SESSION['account_id'])) {
            return '
                <div class="buy-item">
                    <span id="buy-item-button" class="buy-item">Buy Item</span>
                </div>
            ';
        }

        return '
            <a href="../authentication/account-sign-in.php">
                <div class="buy-item">
                    <span>Buy Item</span>
                </div>
            </a>
        ';
    }

    function addToCartSignInDetection() {
        if (isset($_SESSION['account_id'])) {
            return '
                <div class="add-to-cart">
                    <img src="../public/shopping-bag (1).png"  id="add-to-cart-btn" alt="">
                </div>
            ';
        }

        return '
        <a href="../authentication/account-sign-in.php">
            <div class="add-to-cart">
                <img src="../public/shopping-bag (1).png" alt="">
            </div>
        </a>
        ';
    }



    function productPrice($result) {
        $original_price = $result["shoe_price"];
        $discounted_price = calculate_discount($original_price);

        if ($result['is_on_sale'] == 1) {
            return number_format($discounted_price,2);
        } else {
            return number_format($original_price,2);
        }
    }

    function renderProductRating($conn, $result) {
        echo productRatingChild($conn, $result);
    }

    function productRatingChild($conn, $result) {
        $rating = getProductRating($conn, $result);

        if (isset($_SESSION['account_id'])) {
            $user_rating = getUserProductRating($conn, $result);

            $user_product_rating = $user_rating !== null ? $user_rating : 0;
            $rating_message = 'Your '. $user_product_rating .' Rating';
        } else {
            $user_product_rating = 0;
            $rating_message = 'Login 2 Rate';
        }

        return '
            <div class="left-side-container-review">
                <div class="review-title">Review</div>
                <div class="total-rating-container">
                    <div class="total-rating">
                        <div class="rating">
                            <span id="rating">'. $rating['overall_rating'] .'</span>
                        </div>
                        <div class="rating-info">
                            <span id="rating-info"> Overall ratings based on '. $rating['num_ratings'] .' reviews in Total</span>
                        </div>
                    </div>
                </div>
                <div class="star-container" data-product-id="'. $result['product_id'] .'">
                    '. generateStars($user_product_rating) .'
                    <span class="num-review" id="num-review">'. $rating_message .'</span>
                </div>
            </div>

            <div class="right-side-container-review">

            </div>
        ';
    }

    function getProductRating($conn, $result) {
        $total = $conn->prepare("
            SELECT COUNT(*) AS total_ratings 
            FROM review
            WHERE product_id = ?
        ");

       
        $total_rating = $conn->prepare("
            SELECT SUM(rating) AS sum_ratings 
            FROM review 
            WHERE product_id = ?
        ");

       
        $productId = $result['product_id'];
        $total->bind_param("i", $productId);
        $total_rating->bind_param("i", $productId);

      
        $total->execute();
        $totalResult = $total->get_result();
        $totalRow = $totalResult->fetch_assoc();
        $totalRatings = $totalRow['total_ratings'] ?? 0;

        $total_rating->execute();
        $sumResult = $total_rating->get_result();
        $sumRow = $sumResult->fetch_assoc();
        $sumRatings = $sumRow['sum_ratings'] ?? 0;

        $overallRating = ($totalRatings > 0) ? $sumRatings / $totalRatings : 0;

        if ($overallRating > 0 && $overallRating == floor($overallRating)) {
            $overallRating = number_format($overallRating, 1, '.', ''); 
        } else {
            $overallRating = round($overallRating, 1);
        }

        return [
            "num_ratings" => $totalRatings,
            "overall_rating" => $overallRating
        ];
    }

    function getUserProductRating($conn, $result) {
        $user_rating = $conn->prepare("
            SELECT rating
            FROM review
            WHERE product_id = ? AND user_id = ?
        ");

        $user_rating->bind_param("ii", $result['product_id'], $_SESSION['account_id']);

        $user_rating->execute();

        $result = $user_rating->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['rating'];
        } else {
            return null;
        }
    }

    function generateStars($user_product_rating) {
        $filledStars = $user_product_rating; 
        $emptyStars = 5 - $filledStars;
    
        $starHtml = '';
    
      
        for ($i = 0; $i < 5; $i++) {
            if ($i < $filledStars) {
                $starHtml .= '<img src="../public/star.png" alt="" data-id="' . ($i + 1) . '" class="star' . ($i + 1) . ' star">';
            } else {
                $starHtml .= '<img src="../public/star (3).png" alt="" data-id="' . ($i + 1) . '" class="star' . ($i + 1) . ' star">';
            }
        }
        return $starHtml;
    }

        
   function giveSuggestedProductCategory($conn, $category_name, $product_id) {
        // * Kids, Men, Women (General category)
        $query = "SELECT * FROM product WHERE category = '$category_name' AND product_id != '$product_id' ORDER BY RAND() LIMIT 3";
        return mysqli_query($conn, $query);
    }

    function renderSuggestedProducs($conn, $num_of_results, $result) {
        if ($num_of_results > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo cardSuggestedProduct($conn ,$row);
            }
        }
    };

    function cardSuggestedProduct($conn, $row) {
        $status = check_status($row);

        if (isset($_SESSION['account_id'])) {
            $like_record = recordExist($conn, $row["product_id"], $_SESSION['account_id']);

            $like_status = ($like_record->liked) ? 7 : 6;
        } else {
            $like_status = 6;
        }
       
        return '
                <div class="product-card">
                    <div class="shoe-image-container">
                        <img src="'. $row["shoe_image"] .'" alt="">
                        <a href="../product-overview/product-overview.php?product_id='. $row["product_id"]  .'">
                            <div class="shoe-price-name-detail-container">
                                <div class="shoe-name-container">
                                    <span>'. $row["shoe_name"] .'</span>
                                </div>
                                <div class="price-status-container">
                                    <div class="shoe-price-container">
                                        '. shoePriceContainerChilds($status, $row) .'
                                    </div>
                                    <div class="shoe-status '. $status['shoe_status'] .'">
                                        <span> '. $status['shoe_status_pan'] .'</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="add-to-cart-container">
                            <img src="../public/shopping-bag (1).png" id="add-to-cart"  alt="">
                            <img src="../public/heart ('. $like_status .').png" id="wishlist" class="add-to-favorites" data-id="'. $row["product_id"] .'" alt="">
                        </div>
                    </div>
                </div>
            ';
    }

    /**
     * Render Product
     */
    function renderCart($conn, $user_id) {    
        $cart_products = getCartProduct($conn, $user_id);

        if (!empty($cart_products)) {
            foreach ($cart_products as $product) {
                echo cartProduct($conn, $product);
            }
        } else {
            echo "<p> No Product</p>";
        }
    }

     /**
     * Why get hard in a single time if you can get the item 🛒🦖✨
     */
    function getProductData($conn, $product_id) {
        $product_data = $conn->prepare("
            SELECT * FROM product
            WHERE product_id = ?
        ");

        $product_data->bind_param("i",$product_id);
        $product_data->execute();
        $product_result = $product_data->get_result();
        $product = $product_result->fetch_assoc();

        return $product;
    }
    
    function cartProduct($conn, $cart_product) {
        $product_info = getProductData($conn, $cart_product['product_id']);
      
        return '
           <div class="cart-item">
                <div class="item-quantity">
                    <button class="left">+</button>
                    <span id="product-'. $cart_product['product_id'] .'-quantity">'. $cart_product['cart_qty'] .'</span>
                    <button class="right">-</button>
                </div>
                <img src="'. $product_info['shoe_image'] .'" alt="Shoe Image">
                <div class="item-details">
                    <h3>'. $product_info['shoe_name'] .'</h3>
                    <p>₱ '. $product_info['shoe_price'] .'</p>
                </div>
            </div>
        ';
    }

    function getCartProduct($conn, $user_id) {
        $cart_product = $conn->prepare("
            SELECT * FROM cart
            WHERE user_id = ?
        ");

        $cart_product->bind_param("i", $user_id);
        $cart_product->execute();

        $result = $cart_product->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);

        $cart_product->close();
        return $products;
    }
?>
