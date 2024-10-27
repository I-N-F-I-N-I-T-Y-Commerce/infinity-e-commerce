-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 06:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infinity`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `user_password` varchar(225) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `username`, `user_password`, `user_email`) VALUES
(2, 'wilson', '$2y$10$an1Y/bbisydduoprgbKYqO9IMgykg9IanVskvlIk5o3LcwYVoSHk.', 'wilsonesmabe029'),
(4, 'haimonmon', '$2y$10$M38DfSWDabJ3N7RrEmftC.FfMGYVKinPWM.Wela9r4l1ImR6oEgd.', 'vincerepo'),
(6, 'laroro', '$2y$10$iqOdQsJJgQoxqoEYtK0NwuZoGcx/2qaEAmrMRsGK4yQJIY5SLy2Ym', 'vinceowo'),
(7, 'gargamel', '$2y$10$VF/9p6paxrFSR9DaITAB0elErFsbE/EyBvdhKO8b7JLZNO6Oykru6', 'gargamel789@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `cart_qty` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `inbox_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `message_body` varchar(225) NOT NULL,
  `message_status` enum('Read','Unread') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `order_date` date NOT NULL,
  `status_order` enum('Declined','Completed','Pending') NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(6) NOT NULL,
  `shoe_name` varchar(200) NOT NULL,
  `shoe_image` varchar(255) NOT NULL,
  `shoe_brand` varchar(50) NOT NULL,
  `shoe_detail` varchar(225) NOT NULL,
  `quantity` int(2) NOT NULL,
  `category` set('Women','Men','Kids','') NOT NULL,
  `shoe_price` decimal(10,2) NOT NULL,
  `is_on_sale` tinyint(1) NOT NULL,
  `is_limited` tinyint(1) NOT NULL,
  `expiry_date` date NOT NULL,
  `posted_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `shoe_name`, `shoe_image`, `shoe_brand`, `shoe_detail`, `quantity`, `category`, `shoe_price`, `is_on_sale`, `is_limited`, `expiry_date`, `posted_date`) VALUES
(1, 'Lauren Whites', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729063197/INFINITY%20-%20SHOES/Men%20Shoes/dr25viv3pzdgohmuypen.png', 'INFINITY', '\r\nThe Lauren Whites are sleek, minimalistic white sneakers designed for both casual and semi-formal wear. Crafted with premium leather, they feature a smooth finish with subtle stitching along the sides for added texture. The', 55, 'Men', 900.00, 0, 0, '2024-12-31', '2024-10-16'),
(2, 'Nike Pegasus 950p', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729063210/INFINITY%20-%20SHOES/Men%20Shoes/lfvrak5apjjjuc16pdrg.png', 'Nike', '\r\nThe Nike Pegasus 950p is a high-performance running shoe designed for runners who seek speed, support, and comfort. Built with Nike’s innovative React foam, the midsole offers lightweight cushioning that provides a soft yet', 35, 'Men', 987.00, 0, 0, '2024-12-31', '2024-07-09'),
(3, 'Climax Nike', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729063223/INFINITY%20-%20SHOES/Men%20Shoes/axifz0aurbyghgubdsyq.png', 'Nike', 'The Climax Nike is a bold, stylish sneaker that blends athletic performance with a streetwear edge. With a sleek, aerodynamic silhouette, this shoe is designed to provide both comfort and a striking visual appeal. The upper f', 55, 'Men', 1200.00, 0, 0, '2024-12-31', '2024-10-15'),
(4, 'Van Gogh Almond Blossom', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729085450/Group_63_fpedgq.png', 'Infinity', 'The Van Gogh Almond Blossom sneakers are a stunning fusion of art and fashion, inspired by Vincent van Gogh’s famous painting Almond Blossom. These shoes feature a captivating design that showcases the delicate branches and b', 32, 'Men', 1250.00, 0, 1, '2024-12-10', '2024-10-16'),
(5, 'Van Gogh Stary Night', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729085450/Group_62_fsmfeq.png', 'Infinity', 'neakers are a breathtaking tribute to one of the most iconic works of art in history, The Starry Night. These shoes feature a mesmerizing design inspired by the swirling night sky, with deep blues, vibrant yellows, and fluid ', 10, 'Men', 1256.00, 0, 1, '2024-11-13', '2024-10-16'),
(6, 'Nike Dunk Low x CPFM', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729085449/Group_64_uvjqbh.png', 'Nike', 'collaboration is a bold, experimental take on the classic Dunk Low silhouette. Known for their unconventional designs, CPFM brings an artistic and playful touch to these sneakers, making them a standout in any sneaker collect', 23, 'Men', 990.00, 0, 0, '2024-11-30', '2024-10-16'),
(7, 'Nishimatra Green', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729088929/45d74ea93803840a57c5aa3b453d2a73_1_hs8eew.png', 'Infinity', 'The Nishimatra Green sneakers are a unique blend of earthy tones and modern design, inspired by natural landscapes and tranquil vibes. Featuring a rich, deep green color reminiscent of lush forests, these shoes are perfect fo', 67, 'Men', 1109.00, 0, 0, '2025-01-10', '2024-10-16'),
(8, 'Nike lever du soleil', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165253/Group_71_t7kudm.png', 'Nike', 'OWENOKWDNKO', 23, 'Kids', 1500.00, 0, 1, '2024-10-31', '2024-10-17'),
(9, 'Fall Florals', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_68_vtazz6.png', 'Converse', ' shoes are the perfect blend of seasonal charm and comfort for your little one. Designed with a cozy autumn feel, these shoes feature playful floral patterns in warm, earthy tones that capture the essence of fall. Soft, cushi', 55, 'Kids', 1156.00, 1, 0, '2024-11-07', '2024-10-17'),
(10, 'Converse Darkify', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_70_ijyzmt.png', 'Converse', 'bring an edgy yet elegant twist to the classic sneaker style. Featuring striking butterfly motifs set against a deep, moody background, these shoes offer a bold statement for those who love to blend nature with a modern aesth', 15, 'Kids', 1600.00, 1, 0, '2024-10-31', '2024-10-17'),
(12, 'Suede Sneakers', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_72_bfexvl.png', 'Infinity', 'The Suede Sneakers combine timeless style with unbeatable comfort, offering a versatile footwear option that can be dressed up or down. Crafted from premium, soft suede, these sneakers boast a sleek and refined look while mai', 55, 'Kids', 890.00, 1, 0, '2025-02-14', '2024-10-17'),
(13, 'The Berry Good Days', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_69_vuunkw.png', 'Converse', 'a playful and vibrant addition to any wardrobe, designed to bring a pop of fun and color to your every step. With a refreshing berry-inspired palette of rich reds, purples, and pinks, these shoes radiate cheerfulness and posi', 25, 'Kids', 1790.00, 0, 0, '2026-01-17', '2024-09-11'),
(14, 'Party Polka\'s', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_66_bey4as.png', 'Converse', ', playful polka dot patterns in vibrant colors, these shoes exude a lively and cheerful vibe that\'s perfect for parties, gatherings, or casual outings with friends. The cushioned insoles provide comfort for hours of dancing o', 10, 'Kids', 1323.00, 1, 0, '2024-10-31', '2024-10-17'),
(15, 'Mr Croaky', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_65_xtab5s.png', 'Infinity', 'shoes are a quirky and fun footwear choice, perfect for those who love to stand out with playful style. Inspired by the charm of a friendly frog, these shoes feature vibrant green tones and subtle amphibian details, making th', 8, 'Kids', 1670.00, 0, 1, '2024-11-05', '2024-10-17'),
(16, 'Nike Walter Shoes X Frisky Orange', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1729165252/Group_67_awcwjh.png', 'Nike', 'The Nike Walter Shoes X Frisky Orange are a bold fusion of dynamic performance and striking style. With a vibrant burst of energetic orange tones, these shoes stand out both on and off the track. Designed for the modern athle', 25, 'Kids', 670.00, 1, 0, '2024-10-31', '2024-10-17'),
(17, 'Autumn Pumpkin', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048823/Group_74_zxg1cf.png', 'Infinity', 'The Autumn Pumpkin is a cozy, seasonal shoe that captures the essence of fall. Imagine a warm-toned, pumpkin-inspired colorway—think rich orange, earthy brown, or even subtle beige accents. This shoe might feature soft, suede', 20, 'Women', 1100.00, 1, 0, '2024-11-30', '2024-10-28'),
(18, 'Brown Space', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048825/Group_81_inh7th.png', 'Infinity', 'The Brown Space is a sleek, earthy shoe that combines futuristic design with a grounded, natural feel. This shoe likely has a rich, dark brown or espresso-toned upper, with metallic or reflective accents inspired by space aes', 12, 'Women', 890.00, 1, 0, '2025-01-31', '2024-10-28'),
(19, 'Run Star Motions', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048824/Group_79_znfdqw.png', 'Converse', 'The Run Star Motions is a bold, chunky sneaker designed for those who love to make a statement with their footwear. It features an exaggerated, wavy platform sole that provides both height and a unique aesthetic, perfect for ', 55, 'Women', 1600.00, 0, 0, '2024-12-25', '2024-10-28'),
(20, 'NIKE Cherry on Top', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048825/Group_80_wwk5pt.png', 'Nike', 'The NIKE Cherry on Top is a vibrant, eye-catching shoe that brings a playful twist to classic athletic style. With a primary color palette inspired by cherry red tones, this design likely features striking red accents against', 20, 'Women', 1200.00, 0, 1, '2024-11-30', '2024-10-28'),
(21, 'Sunny Pair\'s', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048825/Group_78_rqoiox.png', 'Converse', 'The Sunny Pair Highcut is a bright, uplifting high-top sneaker designed to bring a cheerful vibe to any outfit. Featuring a warm, sunny color palette—think shades of yellow, gold, or orange—this shoe likely has a canvas or li', 10, 'Women', 1900.00, 0, 0, '2025-03-31', '2024-10-28'),
(22, 'Golden Nebula Shoe', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048824/Group_77_zmb3sh.png', 'Infinity', 'The Golden Space Shoe is a luxurious, futuristic sneaker that combines metallic aesthetics with celestial vibes. It likely features a shimmering gold or bronze upper, with reflective or metallic details that capture light and', 15, 'Women', 1558.00, 0, 1, '2024-11-30', '2024-10-28'),
(23, 'Chuck 20s', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048823/Group_75_be5hzq.png', 'Converse', 'The Chuck 90S is a retro-inspired sneaker that pays homage to classic 90s style, blending vintage charm with modern comfort. This shoe typically features a high-top or low-top silhouette, with iconic design elements like a th', 12, 'Women', 870.00, 0, 0, '2025-01-24', '2024-10-28'),
(24, 'Run Star Trainer', 'https://res.cloudinary.com/dhisbk3b2/image/upload/v1730048823/Group_76_uen6vh.png', 'Converse', 'The Run Star Trainer is a sporty, contemporary sneaker crafted for both performance and style. Featuring a lightweight yet durable design, this shoe often includes breathable mesh or flexible synthetic materials that provide ', 21, 'Women', 790.00, 0, 0, '2024-11-15', '2024-10-28');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_body` varchar(255) NOT NULL,
  `review_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `profile_pic` varchar(75) DEFAULT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`inbox_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `inbox_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
