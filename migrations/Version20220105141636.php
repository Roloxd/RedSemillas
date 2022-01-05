<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105141636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE variedad_envase (variedad_id INT NOT NULL, envase_id INT NOT NULL, INDEX IDX_FEEF764891391A54 (variedad_id), INDEX IDX_FEEF76485206DA2E (envase_id), PRIMARY KEY(variedad_id, envase_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variedad_envase ADD CONSTRAINT FK_FEEF764891391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variedad_envase ADD CONSTRAINT FK_FEEF76485206DA2E FOREIGN KEY (envase_id) REFERENCES envase (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE variedad_envase');
        $this->addSql('ALTER TABLE ciclo_ysiembra DROP FOREIGN KEY FK_9571F45691391A54');
        $this->addSql('ALTER TABLE ciclo_ysiembra ADD CONSTRAINT FK_9571F45691391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
