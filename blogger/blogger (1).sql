-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2017 at 04:44 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogger`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(10000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'first comment', '2017-07-26 09:07:52', '2017-07-26 09:07:52'),
(2, 2, 4, 'Adding another long comment', '2017-07-26 09:23:56', '2017-07-26 09:23:56'),
(3, 1, 3, 'My comment', '2017-07-26 09:57:10', '2017-07-26 09:57:10'),
(4, 2, 3, 'comment by temp user', '2017-07-26 09:58:14', '2017-07-26 09:58:14'),
(5, 1, 5, 'comment by me', '2017-07-26 10:23:05', '2017-07-26 10:23:05'),
(6, 1, 6, 'Adding a comment', '2017-07-26 13:00:03', '2017-07-26 13:00:03'),
(7, 1, 16, 'Nice post dude', '2017-07-27 05:47:32', '2017-07-27 05:47:32'),
(8, 1, 17, 'New comment', '2017-07-27 07:49:50', '2017-07-27 07:49:50'),
(9, 3, 18, 'Adding comment to check image updation', '2017-07-27 10:21:18', '2017-07-27 10:21:18'),
(10, 3, 17, 'hello again', '2017-07-27 11:37:41', '2017-07-27 11:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(1000) NOT NULL,
  `imagemodel_id` int(10) UNSIGNED NOT NULL,
  `imagemodel_type` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_path`, `imagemodel_id`, `imagemodel_type`, `created_at`, `updated_at`) VALUES
(1, 'LaravelLogo.png', 18, 'App\\Post', '2017-07-27 09:17:53', '2017-07-27 11:08:56'),
(2, 'LaravelLogo.png', 17, 'App\\Post', '2017-07-27 09:35:33', '2017-07-27 09:35:33'),
(3, 'profile.png', 1, 'App\\User', '2017-07-27 10:05:17', '2017-07-27 10:05:17'),
(4, 'user.png', 2, 'App\\User', '2017-07-27 10:10:20', '2017-07-27 10:10:20'),
(5, 'user.png', 3, 'App\\User', '2017-07-27 10:20:56', '2017-07-27 10:20:56'),
(6, 'sound-wave-colorful.jpg', 16, 'App\\Post', '2017-07-27 10:22:31', '2017-07-27 10:22:31'),
(7, 'LaravelLogo.png', 15, 'App\\Post', '2017-07-27 10:22:58', '2017-07-27 10:22:58'),
(8, 'LaravelLogo.png', 18, 'App\\Post', '2017-07-27 10:56:11', '2017-07-27 10:56:11'),
(9, 'sound-wave-colorful.jpg', 9, 'App\\Post', '2017-07-27 11:26:59', '2017-07-27 11:26:59'),
(10, 'sound-wave-colorful.jpg', 8, 'App\\Post', '2017-07-27 11:28:06', '2017-07-27 11:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 2, 4, '2017-07-26 09:52:01', '2017-07-26 09:52:01'),
(2, 1, 3, '2017-07-26 09:53:58', '2017-07-26 09:53:58'),
(3, 1, 3, '2017-07-26 09:55:19', '2017-07-26 09:55:19'),
(4, 1, 3, '2017-07-26 09:55:23', '2017-07-26 09:55:23'),
(5, 2, 3, '2017-07-26 09:58:16', '2017-07-26 09:58:16'),
(6, 1, 5, '2017-07-26 10:22:50', '2017-07-26 10:22:50'),
(7, 3, 9, '2017-07-26 10:46:20', '2017-07-26 10:46:20'),
(8, 1, 9, '2017-07-26 12:44:20', '2017-07-26 12:44:20'),
(9, 1, 11, '2017-07-26 12:49:16', '2017-07-26 12:49:16'),
(10, 1, 8, '2017-07-26 12:49:44', '2017-07-26 12:49:44'),
(11, 1, 6, '2017-07-26 13:06:57', '2017-07-26 13:06:57'),
(12, 1, 16, '2017-07-27 05:47:17', '2017-07-27 05:47:17'),
(13, 1, 17, '2017-07-27 07:29:07', '2017-07-27 07:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(5000) NOT NULL,
  `slug` varchar(5000) NOT NULL,
  `post` varchar(10000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `slug`, `post`, `created_at`, `updated_at`) VALUES
(3, 1, 'Title', 'title', 'Blog', '2017-07-26 05:35:27', '2017-07-26 05:35:27'),
(4, 2, 'Blog 2', 'blog-2', 'Blog from Temp', '2017-07-26 07:14:40', '2017-07-26 07:14:40'),
(5, 1, 'A new Blog', 'a-new-blog', 'This is a new blog just to check everything is working fine', '2017-07-26 10:22:37', '2017-07-26 12:56:02'),
(6, 3, 'Temp 2 Blog 1', 'temp-2-blog-1', 'This is my first blog here as a temp user hope you dont like it', '2017-07-26 10:42:28', '2017-07-26 10:42:28'),
(7, 3, 'Temp 2 Blog 2', 'temp-2-blog-2', 'This is my second my blog as temp user hope you dont like it either', '2017-07-26 10:44:31', '2017-07-26 10:44:31'),
(8, 3, 'Blog 3 Temp 2', 'blog-3-temp-2', 'This is my third and last blog it is to check whether pagination works or not', '2017-07-26 10:45:08', '2017-07-26 10:45:08'),
(9, 3, 'One last time', 'one-last-time', 'I hope that pagination is working ..... Yaaayyy !', '2017-07-26 10:45:39', '2017-07-26 12:57:25'),
(11, 1, 'My Blog with new image', 'my-blog-with-new-image', 'dfsdfsd dfsadf dsfsdfsd gsdfs', '2017-07-26 10:59:03', '2017-07-26 13:16:40'),
(15, 1, 'My Blog', 'my-blog', 'Thsi blog contains a new image type of image file to check the funcitonality. This blog txt has been modified to reviiew the changes done form the last day. If its working fine then awesome otherwise.', '2017-07-26 12:58:24', '2017-07-27 07:11:55'),
(16, 1, 'Blog with Long text', 'blog-with-long-text', 'Accessible icons\r\nModern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. To avoid unintended and confusing output in screen readers (particularly when icons are used purely for decoration), we hide them with the aria-hidden=\"true\" attribute.\r\n\r\nIf you\'re using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.\r\n\r\nIf you\'re creating controls with no other text (such as a <button> that only contains an icon), you should always provide alternative content to identify the purpose of the control, so that it will make sense to users of assistive technologies. In this case, you could add an aria-label attribute on the control itself.', '2017-07-27 05:39:20', '2017-07-27 05:39:20'),
(17, 1, 'aksjdhfakslj', 'aksjdhfakslj', 'lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfhlskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh lskajfhsdkjfh skjadfhsalkdj kjsdhfalskdj iuwetyisutwpiwrehklasdhf kdjfhasdk lfhsakdjfiuwer hfsdkjhflaskdjewrpwei sjfhaskldjfh', '2017-07-27 07:17:09', '2017-07-27 07:17:09'),
(18, 1, 'Testing Poly 1', 'testing-poly-1', 'This blog tests the model polymorphism', '2017-07-27 09:17:53', '2017-07-27 09:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Juniad Rasheed', 'junaidrasheed1@gmail.com', '$2y$10$.WiLnfivHkf9NKC1tR6r0eihVY1oaLufnaRH1uwba8X75di9lmIeu', 'OCKjRwBBxO6UHRop62aV2IqPMyYnl48nWeI1wZYJNVHrblYH6nDwwYQ3KyR9', '2017-07-25 04:44:19', '2017-07-25 04:44:19'),
(2, 'Temp User', 'temp@temp.com', '$2y$10$24CBRXocyj.F48czHLPjF.0qffi2D1ls4blZG3ZNhoGXp1pt2o1vi', '3BA7e0FFtltVs5cpRNwqQy5r3CNNiTSlIo8lPjJQfA8K9Q6y6S85xCP5Xf18', '2017-07-25 07:17:27', '2017-07-25 07:17:27'),
(3, 'Temp 2', 'temp2@temp.com', '$2y$10$Y.I7gGOkSqNU7YRSDqDPteaMrnWJ.FK/VSM13QbnnoOJ.y94bMHKq', 'CrhSBjh8FBe9iYe27SThbTXEnCG1QKAgcTwcGaZNEu7Wbww1yGPsmk7eVZke', '2017-07-26 05:41:17', '2017-07-26 05:41:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`imagemodel_id`),
  ADD KEY `FollowerID` (`imagemodel_type`(767));

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
