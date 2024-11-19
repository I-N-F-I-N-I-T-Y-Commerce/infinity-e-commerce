<?php
    include('../../database/INFINITY/connection.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            echo json_encode([
                "success" => false,
                "message" => "log in first",
                "data" => null
            ]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $user_id = $_SESSION['account_id'];
        $product_id = $data['product_id'];
        $quantity = $data['quantity'];
        $action = $data['action'];

        if (!$user_id || !$product_id || !$quantity || $quantity <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid input',
                "data" => null
            ]);
            exit();
        }

        if (!in_array($action, ['add', 'subtract', 'remove'], true)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action',
                'data' => null
            ]);
            exit();
        }

        $product_data = getProductData($conn, $product_id);

        if (!$product_data) {
            echo json_encode([
                'success' => false,
                'message' => 'Product not found',
                "data" => null
            ]);
            exit();
        }

        $item_exist_cart = $conn->prepare("
            SELECT * FROM cart
            WHERE user_id = ? AND product_id = ?
        ");


        $item_exist_cart->bind_param("ii", $user_id, $product_id);
        $item_exist_cart->execute();
        $cart_item_result = $item_exist_cart->get_result();
        $cart_item = $cart_item_result->fetch_array();

        if (!$cart_item && $action == 'remove') {
            echo json_encode([
                'success' => false,
                'message' => 'Chill the product is already removed lmao',
                "data" => null
            ]);
            exit();
        }

        if (!$cart_item && $action == 'subtract') {
            echo json_encode([
                'success' => false,
                'message' => 'Product didnt exist, so what to subtract??',
                "data" => null
            ]);
            exit();
        }

        if ($cart_item) {
            // * Update Cart Data
            if ($action === 'add') {
                $message = updateAddProduct($conn, $cart_item, $quantity, $user_id, $product_data);
            } elseif ($action == 'subtract') {
                $message = updateSubtractProduct($conn, $cart_item, $quantity, $user_id, $product_data);
            } elseif ($action == 'remove') {
                $message = removeProduct($conn, $user_id, $product_data);
            }
        } else {
            // * INSERT New Product Data on cart
            $message = addProduct($conn, $user_id, $quantity, $product_data);
        }

        echo json_encode([
            "success" => true,
            "message" => "Successfully {$message}",
            "data" => [
                "success"
            ]
        ]);
        exit();
    };

    /**
     * Primary: Add New Product data as its first time on the cart 🛒🦖✨
     */
    function addProduct($conn, $user_id, $quantity, $product_data) {
        $new_product = $conn->prepare("
            INSERT INTO cart (user_id, product_id, cart_qty)
            VALUES (?, ?, ?)
        ");
        $new_product->bind_param("iii",$user_id, $product_data['product_id'], $quantity);
        $new_product->execute();
        return "Inserted New product to the database";
    }

    /**
     * Primary Update: Add product quantity in cart by request 🛒🦖✨
     */
    function updateAddProduct($conn, $cart_item, $quantity, $user_id, $product_data) {
        $new_quantity = $cart_item['cart_qty'] + $quantity;

        if ($new_quantity > $product_data['quantity']) {
            echo json_encode([
                'success' => false,
                'message' => 'Quantity exceeds stock limit',
                'data' => null
            ]);
            exit();
        }

        updateCartData($conn, $new_quantity, $user_id, $product_data['product_id']);
        return "Updated to {$new_quantity} quantity addition of product: {$product_data['product_id']}";
    }

    /**
     * Primary Update: Reduce product quantity in cart by request 🛒🦖✨
     */
    function updateSubtractProduct($conn, $cart_item, $quantity, $user_id, $product_data) {
        $new_quantity = $cart_item['cart_qty'] - $quantity;

        if ($new_quantity <= 0) {
            deleteCartData($conn, $user_id, $product_data['product_id']);
            return "Removed product {$product_data['product_id']}";
        } else {
            updateCartData($conn, $new_quantity, $user_id, $product_data['product_id']);
            return "Updated to {$new_quantity} quantity reduce of product: {$product_data['product_id']}";
        }
    }

    /**
     * Primary: Remove product by request 🛒🦖✨
     */
    function removeProduct($conn, $user_id, $product_data) {
        deleteCartData($conn, $user_id, $product_data['product_id']);
        return "Removed product {$product_data['product_id']}";
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

    /**
     * Just Update its data for the quantity of the product in the card
     */
    function updateCartData($conn,$new_quantity, $user_id, $product_id) {
        $update_query = $conn->prepare("
            UPDATE cart SET cart_qty = ?
            WHERE user_id = ? AND product_id = ?
        ");

        $update_query->bind_param("iii",$new_quantity, $user_id, $product_id);
        $update_query->execute();
    };


    /**
     * Erase from its existence in a hand of thanos lol
     */
    function deleteCartData($conn, $user_id, $product_id) {
        $delete_query = $conn->prepare("
            DELETE FROM cart WHERE user_id = ? AND product_id = ?
        ");
        $delete_query->bind_param("ii", $user_id, $product_id);
        $delete_query->execute();
    }
?>