<?php
    function render($num_of_results, $result) {
        if ($num_of_results > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo card($row);
            }
        }
    };

    function card($row) {
        $status = check_status($row);

        return '
            <a href="../../product-overview/product-overview.php?product_id='. $row["product_id"]  .'">
                <div class="product-card">
                    <div class="shoe-image-container">
                        <img src="'. $row["shoe_image"] .'" alt="">
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
                        <div class="add-to-cart-container">
                            <img src="../../public/shopping-bag (1).png" id="add-to-cart"  alt="">
                            <img src="../../public/heart (6).png" id="wishlist" class="add-to-favorites" data-id="'. $row["product_id"] .'" alt="">
                        </div>
                    </div>
                </div>
            </a>
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
?>