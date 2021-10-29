<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029094141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taxon (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) DEFAULT NULL, nombre VARCHAR(60) DEFAULT NULL, padre INT DEFAULT NULL, autoridad VARCHAR(60) DEFAULT NULL, subtaxon VARCHAR(60) DEFAULT NULL, autoridad_subtaxon VARCHAR(60) DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variedad ADD subtaxon_id INT DEFAULT NULL, DROP subtaxon');
        $this->addSql('ALTER TABLE variedad ADD CONSTRAINT FK_850B22B3D58349F9 FOREIGN KEY (subtaxon_id) REFERENCES taxon (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_850B22B3D58349F9 ON variedad (subtaxon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE variedad DROP FOREIGN KEY FK_850B22B3D58349F9');
        $this->addSql('DROP TABLE taxon');
        $this->addSql('DROP INDEX UNIQ_850B22B3D58349F9 ON variedad');
        $this->addSql('ALTER TABLE variedad ADD subtaxon VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP subtaxon_id');
    }
}
