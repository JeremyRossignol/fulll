CREATE TABLE `FleetVehicleJoin` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `fleet_id` int(11) NOT NULL,
   `vehicle_id` int(11) NOT NULL,
   `updated_at` TIMESTAMP NOT NULL,
   `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`fleet_id`) REFERENCES `Fleet` (`id`),
   FOREIGN KEY (`vehicle_id`) REFERENCES `Vehicle` (`id`)
)