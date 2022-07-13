-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jul 13, 2022 at 04:25 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `user_id`, `amount`, `price`) VALUES
(2, 'ColaPesi', 17, 100, 8450),
(3, 'Big-cola', 17, 70, 9000),
(4, 'Shirt-one', 17, 15, 7800),
(5, 'Shorty-sport', 17, 50, 7800),
(6, 'Piggy burgur', 17, 30, 40000),
(8, 'Chese Burgur', 17, 7, 1400),
(9, 'Green water', 17, 50, 5000),
(12, 'Hot dog', 17, 13, 5000),
(13, 'tiger', 17, 50, 545430),
(14, 'Lion', 17, 34, 780500),
(15, 'Headset', 17, 1, 5730),
(17, 'Nissan', 18, 5, 57000000),
(18, 'Umbralla', 18, 56, 70000),
(19, 'Lion', 18, 33, 8000),
(20, 'Shoes', 18, 45, 800000),
(21, 'House_hunting', 18, 1, 7000000),
(22, 'T-shirt-black', 18, 5, 30000),
(23, 'bottle of water', 18, 45, 6000),
(24, 'Lamda', 18, 20, 5000),
(25, 'papaya salade', 18, 2, 470),
(26, 'noodle', 18, 1, 250),
(27, 'Ballon', 18, 4, 850),
(28, 'Umbralla', 18, 12, 3550);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token` varchar(65) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token`, `last_updated`, `user_id`) VALUES
('NGnpDz2tP4Hsb2LYoEcsV3uE11IA3JOT2ubbaqZHrLRl8QeYH2hs9amr1kjyn7Kb', '2022-07-12 16:37:18', 17),
('Gzo6zX9nYhyAEcCBvXZGx5giGtcS8EFFowTnW8YOnjMedrSMojnjRWgxIQGrQ32O', '2022-07-12 16:57:18', 17),
('BU8FReLgNawWOXVNUnNGoWx43SnjOul135Ecu2uTJLI1eCPmDOTM0KM2L3b2IK8S', '2022-07-13 01:34:39', 17),
('r9Lu1t5QFUfsuW9HKep6hVkPhf4tNrihGHbgxUlKj5xLI7ICDlGLPIcaA23HjFka', '2022-07-13 02:00:41', 17),
('iaPLoemsr7AqVw0qttijgySEU2s1cysvEUE93glnf8cXv0m9uD1grHI7Z9FBmFZc', '2022-07-13 03:35:11', 17),
('qUkkrs22rpCNtbkhX28exYXhaaryxQHhTJs5pfttTIKeytJC7K6uHzwDbboMjJXu', '2022-07-13 04:00:06', 17),
('2hI5IYnnTJqUKwTCW1Ru9zCuNHfSaYVIsWnfGuswhNZdGDfgHz7BNLnM6aUY1PKj', '2022-07-13 04:35:52', 17),
('N15hMkePH9ZTXdYV8mXCucQC5DC8ZuqkQ8obpvxu85jYnDxWJQSL4bWk1gT45ytp', '2022-07-13 04:50:35', 17),
('YDBermAqyHSEoUTYglT9tm44aZ4utUlEwT3JRhMdlpZzTk8TPm8H2Y71MlkVnWWz', '2022-07-13 05:45:45', 17),
('ELbpSvzMFz5GXOEczndDLRbDDi03WApLK6dukEJ95qeOXUOXB6y1Eeap3JJWWgFZ', '2022-07-13 06:04:13', 17),
('DZnQW1NtrB5D19h4EbQwq7eh2TzKdR2DWbMQL1ztsfU1rshZdL5Byx69Apwbyrrb', '2022-07-13 08:43:08', 17),
('DseAwCguSjQJw33DACacfqLojBXhakAafJt7XMNxFYIKJK86U4lQcx37hUZCskRQ', '2022-07-13 09:15:51', 17),
('kkHt9CrLujz0IpOxQ8aMsaSdi8066CCmIe77aTKPXCx1oYGhMlx2RiksEIX82GfG', '2022-07-13 14:11:32', 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `class` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `hash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `class`, `email`, `salt`, `hash`) VALUES
(1, 'passtor', 'Male', 'EEC2', 'passtor.grey@gmail.com', 'fA3urAkKmdtCh6PLbRL7KwYqShY8x54Q', 'fd07c3a09a5027e0a435d046632866b104d46574fbee1d1181109d1bd7e47827'),
(3, 'sylvestor', 'Male', 'Super1', 'sylvestor.anthony@gmail.com', 'ZScRA5yYAcGAipFHu06HRxT7MTkum8CY', '380632da3f9c91b64d1c8f3f29ac67e4d96956228e6a99236938b5ff67aaf6d2'),
(4, 'Kurokaze', 'Other', 'sfdfdsfds', 'kurokaze@gmail.com', 'qmwt1wiTdJcmrIHlxhlnr2HzeR9FRBHP', 'f7694d2ab69089d12e790e02733e423eb5168edddbf0726195800ddbbaa8945d'),
(5, 'Kuroyuki_Kaze', 'Other', 'dfdsfdsf', 'kurokaze@gmail.com', '7YSlDs8YBuo0m1ZxGpI2d5ewNL4lc0C8', '40f43cd2a0037d37dd776ae726bcf68ba1b8fab0e8744af87760e35ef038b398'),
(7, 'tangpi', 'Male', 'GCCLLVM', 'tangpi@yahoo.cn', 'wu89d3thBhvQyOmDzmck9sx9ixvcV4ss', 'f001e58c5be39f77adbe68f8c45ff59f45cfa5e208f603279ffa184edf6111b7'),
(9, 'sakuya', 'Female', 'EoSD', 'sakuya.izayoi@gmail.com', 'F6EliSiWEZvu2iIdlwLnUUUDGoXNx9xE', 'f2315758dc4b8947171dd2a323aaecaa3d77bfe27f967ddd3c0148392cae5bd9'),
(10, 'thyrak', 'Male', 'LLVM', 'thyrak@gmail.com', 'mLLRzPRQ5YtKMDhWqEhlzpxblblBKS5g', '8b509211ccacdf231be349718b1f013777412a5f09c4ead11d57ca537fffcef3'),
(11, 'sfdsfsdfds', 'Male', 'dfsdfs', 'jlfsjdk@gmail.com', 'ZXGXIrWzv5eWzh9iwsDFB3PWFSvnYkR0', '90e3fdcdfbebed40007c422bb452def1e85ab85b4d19f67f07e2e6d9ae06c35c'),
(12, 'grass', 'Other', 'grasser', 'grass@class.sass', 'qiWJDfMwqU4Celn7g3D7lvFSNfNyEC7w', 'a67b0ee230a80bd04203d4eef693e880dc085dc57fec8520bd4850c47fa33619'),
(13, 'virgil', 'Male', 'virgilent', 'virgil@gmail.com', 'fpAm5uBqXSOHaRW9Bw3Eb5tH4DwRFagl', '645236f431978fefce5e7c5d6a62ca35ab8ffe764564f86ec1e9ac47ebf9e477'),
(14, 'hudain', 'Male', 'sfdfsd', 'hudain@sad.com', '8FW0CKXGFJl0Ognp4Z7GlJGPggnaHipM', '3b324e631d88db9279f9f41486d7656affd0a6d854f2d738c32de594aed88e9d'),
(15, 'testname', 'Male', 'CSG7', 'testname@gmail.com', 'p4LaK5pSv8bJjXkmDu3CJZ2kew1YYaxD', 'ad649662bbc9aa46dfdd8e21576c05924300fbcfd1d978a630fe8d391251d370'),
(16, 'username', 'Other', '\'<script>alert(1)</script><!--', 'email@example.com', 'Q50pxGYewUVOgoushxP9CbXNjmq01f46', 'aa7f6c5d7a361de805286389fa2053024f6f56abe12ef1c9a329ce18cee4fd49'),
(17, 'panha_GKP', 'Male', 'computer sicence', 'panha.vuthy@student.niptict.edu.kh', '5vFEIR1ihJFtLLXSJ6AkSeHjdNYq8980', '7d4b7186c1b3661dca6c27abb5699e205b1f7ed2cb21d29bacf38af4b2b76824'),
(18, 'usertest', 'Male', 'Computer Science', 'usertest@gmail.com', 'sUYDoWzohczXU1mf1CAiGxb9YjqyCvMK', '6ee06a6889952ecbea3592b94f602d6a36e8188cef4ef7f4728c6e6a0f093e6b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
