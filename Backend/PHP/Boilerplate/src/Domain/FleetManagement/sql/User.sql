CREATE TABLE `User` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `updated_at` TIMESTAMP NOT NULL,
   `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
)