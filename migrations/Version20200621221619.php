<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200621221619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622F8697D13');
        $this->addSql('DROP INDEX IDX_D8892622F8697D13 ON rating');
        $this->addSql('ALTER TABLE rating ADD seance_id INT DEFAULT NULL, CHANGE comment_id formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926225200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('CREATE INDEX IDX_D88926225200282E ON rating (formation_id)');
        $this->addSql('CREATE INDEX IDX_D8892622E3797A94 ON rating (seance_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926225200282E');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622E3797A94');
        $this->addSql('DROP INDEX IDX_D88926225200282E ON rating');
        $this->addSql('DROP INDEX IDX_D8892622E3797A94 ON rating');
        $this->addSql('ALTER TABLE rating ADD comment_id INT DEFAULT NULL, DROP formation_id, DROP seance_id');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_D8892622F8697D13 ON rating (comment_id)');
    }
}
