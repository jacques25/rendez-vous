<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200503091411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bijou ADD promo_is_active TINYINT(1) DEFAULT NULL, ADD promo VARCHAR(255) DEFAULT NULL, ADD date_start DATETIME DEFAULT NULL, ADD date_end DATETIME DEFAULT NULL, ADD port DOUBLE PRECISION DEFAULT NULL, ADD multiplicate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE option_bijou DROP promo_is_active, DROP promo, DROP date_start, DROP date_end, DROP port, DROP multiplicate');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bijou DROP promo_is_active, DROP promo, DROP date_start, DROP date_end, DROP port, DROP multiplicate');
        $this->addSql('ALTER TABLE option_bijou ADD promo_is_active TINYINT(1) DEFAULT NULL, ADD promo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD date_start DATETIME DEFAULT NULL, ADD date_end DATETIME DEFAULT NULL, ADD port DOUBLE PRECISION DEFAULT NULL, ADD multiplicate DOUBLE PRECISION DEFAULT NULL');
    }
}
