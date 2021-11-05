<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104102452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE imagen_seleccionada (id INT AUTO_INCREMENT NOT NULL, variedad_id INT DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_854A3B0091391A54 (variedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE imagen_seleccionada ADD CONSTRAINT FK_854A3B0091391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id)');
        $this->addSql('ALTER TABLE imagen ADD imagen_seleccionada_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B3CCFA8203 FOREIGN KEY (imagen_seleccionada_id) REFERENCES imagen_seleccionada (id)');
        $this->addSql('CREATE INDEX IDX_8319D2B3CCFA8203 ON imagen (imagen_seleccionada_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B3CCFA8203');
        $this->addSql('DROP TABLE imagen_seleccionada');
        $this->addSql('DROP INDEX IDX_8319D2B3CCFA8203 ON imagen');
        $this->addSql('ALTER TABLE imagen DROP imagen_seleccionada_id');
    }
}
