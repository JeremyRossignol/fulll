CREATE TABLE `Fleet` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `user_id` int(11) NOT NULL,
   `updated_at` TIMESTAMP NOT NULL,
   `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`user_id`) REFERENCES `User` (`id`)
)