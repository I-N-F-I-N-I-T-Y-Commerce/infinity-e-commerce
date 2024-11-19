<?php
    include('../../database/INFINITY/connection.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            echo json_encode([
                "success" => false,
                "message" => "log in first",
                "rating" => null,
                "num_rating" => null,
                "overall_rating" => null,
            ]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['product_id']) || !isset($data['rating'])) {
            echo json_encode([
                "success" => false,
                "message" => "Missing data ",
                "rating" => null,
                "num_rating" => null,
                "overall_rating" => null,
            ]);
            exit();
        }

        $product_id = intval($data['product_id']);
        $rating = intval($data['rating']);
        $account_id = $_SESSION['account_id'];

        if ($rating < 1 || $rating > 5) {
            echo json_encode([
                "success" => false,
                "message" => "Rating must be between 1 and 5",
                "rating" => null,
                "num_rating" => null,
                "overall_rating" => null,
            ]);
            exit();
        }

        $check_existing = $conn->prepare("
            SELECT review_id FROM review
            WHERE product_id = ? AND user_id = ?
        ");

        $check_existing->bind_param("ii", $product_id, $account_id);
        $check_existing->execute();
        $result = $check_existing->get_result();

        if ($result->num_rows > 0) {
            $update_rating = $conn->prepare("
                UPDATE review 
                SET rating = ?
                WHERE product_id = ? AND user_id = ?
            ");

            $update_rating->bind_param("iii",$rating, $product_id, $account_id);
            $update_rating->execute();
            $message = 'Updated';
        } else {
            $insert_rating = $conn->prepare("
                INSERT INTO review (product_id, user_id, rating)
                VALUES (?, ?, ?)
            ");

            $insert_rating->bind_param("iii",$product_id, $account_id, $rating);
            $insert_rating->execute();
            $message = 'Submitted';
        }

        $rating_data = getProductRating($conn, ['product_id' => $product_id]);
        $user_rating = getUserProductRating($conn, ['product_id' => $product_id]);

        echo json_encode([
            "success" => true,
            "message" => "Rating {$message}",
            "rating" => $user_rating,
            "num_rating" => $rating_data['num_ratings'],
            "overall_rating" => $rating_data['overall_rating'],
        ]);
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
?>