<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:migrations/Version20211214091824.php
final class Version20211214091824 extends AbstractMigration
=======
final class Version20211115134139 extends AbstractMigration
>>>>>>> 670bb5d253aa9cbc1d4b3f4a509611216d9c9b52:migrations/Version20211115134139.php
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20211214091824.php
        $this->addSql('ALTER TABLE variedad ADD breve_descr_planta_cultivo VARCHAR(100) DEFAULT NULL, CHANGE codigo codigo INT DEFAULT NULL');
=======
        $this->addSql('ALTER TABLE imagen ADD principal TINYINT(1) NOT NULL');
>>>>>>> 670bb5d253aa9cbc1d4b3f4a509611216d9c9b52:migrations/Version20211115134139.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20211214091824.php
        $this->addSql('ALTER TABLE variedad DROP breve_descr_planta_cultivo, CHANGE codigo codigo VARCHAR(9) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
=======
        $this->addSql('ALTER TABLE imagen DROP principal');
>>>>>>> 670bb5d253aa9cbc1d4b3f4a509611216d9c9b52:migrations/Version20211115134139.php
    }
}
