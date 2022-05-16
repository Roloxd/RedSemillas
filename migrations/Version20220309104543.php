<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309104543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada CHANGE codigo_entrada codigo_entrada VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE fitosanitario ADD entrada_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fitosanitario ADD CONSTRAINT FK_EA1C9B7BA688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
        $this->addSql('CREATE INDEX IDX_EA1C9B7BA688222A ON fitosanitario (entrada_id)');
        $this->addSql('ALTER TABLE germinacion ADD entrada_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE germinacion ADD CONSTRAINT FK_1E6509CEA688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
        $this->addSql('CREATE INDEX IDX_1E6509CEA688222A ON germinacion (entrada_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada CHANGE codigo_entrada codigo_entrada VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE fitosanitario DROP FOREIGN KEY FK_EA1C9B7BA688222A');
        $this->addSql('DROP INDEX IDX_EA1C9B7BA688222A ON fitosanitario');
        $this->addSql('ALTER TABLE fitosanitario DROP entrada_id');
        $this->addSql('ALTER TABLE germinacion DROP FOREIGN KEY FK_1E6509CEA688222A');
        $this->addSql('DROP INDEX IDX_1E6509CEA688222A ON germinacion');
        $this->addSql('ALTER TABLE germinacion DROP entrada_id');
    }
}
