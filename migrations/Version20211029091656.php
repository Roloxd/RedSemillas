<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029091656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE uso (id INT AUTO_INCREMENT NOT NULL, uso_variedad_id INT DEFAULT NULL, uso VARCHAR(100) DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, INDEX IDX_74642555E9D490F0 (uso_variedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uso_variedad (id INT AUTO_INCREMENT NOT NULL, descripcion LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE uso ADD CONSTRAINT FK_74642555E9D490F0 FOREIGN KEY (uso_variedad_id) REFERENCES uso_variedad (id)');
        $this->addSql('ALTER TABLE imagen_seleccionada ADD variedad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE imagen_seleccionada ADD CONSTRAINT FK_854A3B0091391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_854A3B0091391A54 ON imagen_seleccionada (variedad_id)');
        $this->addSql('ALTER TABLE variedad DROP FOREIGN KEY FK_850B22B3763C8AA7');
        $this->addSql('DROP INDEX UNIQ_850B22B3763C8AA7 ON variedad');
        $this->addSql('ALTER TABLE variedad CHANGE imagen_id uso_variedad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE variedad ADD CONSTRAINT FK_850B22B3E9D490F0 FOREIGN KEY (uso_variedad_id) REFERENCES uso_variedad (id)');
        $this->addSql('CREATE INDEX IDX_850B22B3E9D490F0 ON variedad (uso_variedad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE uso DROP FOREIGN KEY FK_74642555E9D490F0');
        $this->addSql('ALTER TABLE variedad DROP FOREIGN KEY FK_850B22B3E9D490F0');
        $this->addSql('DROP TABLE uso');
        $this->addSql('DROP TABLE uso_variedad');
        $this->addSql('ALTER TABLE imagen_seleccionada DROP FOREIGN KEY FK_854A3B0091391A54');
        $this->addSql('DROP INDEX UNIQ_854A3B0091391A54 ON imagen_seleccionada');
        $this->addSql('ALTER TABLE imagen_seleccionada DROP variedad_id');
        $this->addSql('DROP INDEX IDX_850B22B3E9D490F0 ON variedad');
        $this->addSql('ALTER TABLE variedad CHANGE uso_variedad_id imagen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE variedad ADD CONSTRAINT FK_850B22B3763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen_seleccionada (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_850B22B3763C8AA7 ON variedad (imagen_id)');
    }
}
