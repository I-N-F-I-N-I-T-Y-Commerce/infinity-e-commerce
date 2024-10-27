<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "infinity"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

function give_category($conn, $category_name) {

    if ($category_name == 'New') {
        $query = "SELECT * FROM product";

        return mysqli_query($conn, $query);
    }

    if ($category_name == 'Sales') {
        $query = "SELECT * FROM product WHERE is_on_sale = 1" ;

        return mysqli_query($conn, $query);
    }

    $query = "SELECT * FROM product WHERE category = '$category_name'";

    return mysqli_query($conn, $query);
}

function search_for($conn, $search_query) {


    if ($search_query == 'sale') {
        $query = "SELECT * FROM product WHERE is_on_sale = 1";
        // return mysqli_query($conn, $query);


    } else {
        $query = "SELECT * FROM product WHERE shoe_name LIKE '%". $conn->real_escape_string($search_query) ."%' 
        OR category LIKE '%". $conn->real_escape_string($search_query) ."%'
        OR shoe_brand LIKE '%". $conn->real_escape_string($search_query) ."%'
        ";
    }

    return mysqli_query($conn, $query);
}


function is_new($posted_date) {
    return date('Y-m-d', strtotime($posted_date . " +5 days"));
}


/**
 * Function Still on work for temporary only
 */
function check_status($row) {
    $posted_date = $row["posted_date"];
    $posted_expiration_date = is_new($row["posted_date"]);

    // * Both Limited and On Sales
    if ($row["is_limited"] == 1 && $row["is_on_sale"] == 1) {
        return [
            'shoe_status' => 'limited-sale',
            'shoe_status_pan' => 'Limited Sale'
        ];
    }

    // * Limited Edition
    if ($row["is_on_sale"] == 1) {
        return [
            'shoe_status' => 'sale',
            'shoe_status_pan' => 'On Sale'
        ];
    }

    // * Limited Edition
    if ($row["is_limited"] == 1) {
        return [
            'shoe_status' => 'limited',
            'shoe_status_pan' => 'Limited Edition'
        ];
    }

    // * New owo
    if (date("Y-m-d") <= $posted_expiration_date) {
        return [
            'shoe_status' => 'new',
            'shoe_status_pan' => 'New'
        ];
    }

    // * Nothings special just a regular product
    if ($row["is_limited"] == 0) {
        return [
            'shoe_status' => 'none',
            'shoe_status_pan' => 'None'
        ];
    }
}

function calculate_discount($price) {
    if ($price >= 5000) {
        // * 20% discount for items above or equal to ₱5000
        return $price * 0.80;
    } elseif ($price >= 3000) {
        // * 15% discount for items above or equal to ₱3000
        return $price * 0.85;
    } elseif ($price >= 1000) {
        // * 10% discount for items above or equal to ₱1000
        return $price * 0.90;
    } else {
        // * 5% discount for items below ₱1000
        return $price * 0.85;
    }
}

function get_product_information($product_id) {
    
}

?>