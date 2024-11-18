<?php
    include('../../database/INFINITY/connection.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            echo json_encode([
                "success" => false,
                "message" => "log in first",
                "action" => "unliked"
            ]);
            exit();
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $product_id = $input['product_id'] ?? null;

        if (!$product_id) {
            echo json_encode([
                "success" => false,
                "message" => "invalid input",
                "action" => "unliked"
            ]);
            exit();
        }

        $account_id = $_SESSION['account_id'];
        $like_record_exist = recordExist($conn, $product_id, $account_id);

        if ($like_record_exist) {
            $liked_status = $like_record_exist->liked ? 0 : 1;
            $action = $liked_status ? "liked" : "unliked";

            $stmt = $conn->prepare("
                UPDATE wishlist
                SET liked = ?
                WHERE user_id = ? AND product_id = ?
            ");

            $stmt->bind_param("iii", $liked_status, $account_id, $product_id);
        } else {
            $liked_status = 1;
            $action = "liked";

            $stmt = $conn->prepare("
                INSERT INTO wishlist (user_id, product_id, liked)
                VALUES (?,?,?)
            ");
            $stmt->bind_param("iii",$account_id, $product_id, $liked_status);
        };
        
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Successfully {$action} a product",
                "action" => $action
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Error cant like a product",
                "action" => "unliked"
        ]);
        }
        
        $stmt->close();
        $conn->close();
    };

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
        return null;
    }
?>