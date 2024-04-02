<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402080341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fleet_vehicle (fleet_id INT NOT NULL, vehicle_id INT NOT NULL, INDEX IDX_3DD2DF8D4B061DF9 (fleet_id), INDEX IDX_3DD2DF8D545317D1 (vehicle_id), PRIMARY KEY(fleet_id, vehicle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fleet_vehicle ADD CONSTRAINT FK_3DD2DF8D4B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fleet_vehicle ADD CONSTRAINT FK_3DD2DF8D545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fleet DROP name, CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE fleet ADD CONSTRAINT FK_A05E1E479D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A05E1E479D86650F ON fleet (user_id_id)');
        $this->addSql('ALTER TABLE vehicle ADD location_id_id INT DEFAULT NULL, DROP name, DROP location_id');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E486918DB72 ON vehicle (location_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fleet_vehicle DROP FOREIGN KEY FK_3DD2DF8D4B061DF9');
        $this->addSql('ALTER TABLE fleet_vehicle DROP FOREIGN KEY FK_3DD2DF8D545317D1');
        $this->addSql('DROP TABLE fleet_vehicle');
        $this->addSql('ALTER TABLE fleet DROP FOREIGN KEY FK_A05E1E479D86650F');
        $this->addSql('DROP INDEX IDX_A05E1E479D86650F ON fleet');
        $this->addSql('ALTER TABLE fleet ADD name VARCHAR(255) NOT NULL, CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486918DB72');
        $this->addSql('DROP INDEX UNIQ_1B80E486918DB72 ON vehicle');
        $this->addSql('ALTER TABLE vehicle ADD name VARCHAR(255) NOT NULL, ADD location_id INT NOT NULL, DROP location_id_id');
    }
}
