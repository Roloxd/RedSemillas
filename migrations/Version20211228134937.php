<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228134937 extends AbstractMigration
{


    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE variedad ADD manejo_cultivo LONGTEXT DEFAULT NULL, ADD manejo_siembra_plantacion LONGTEXT DEFAULT NULL, ADD manejo_suelo_desherbado LONGTEXT DEFAULT NULL, ADD manejo_asociacion_rotacion_cultivos LONGTEXT DEFAULT NULL, ADD manejo_poda_entutorado LONGTEXT DEFAULT NULL, ADD manejo_abonado_riego LONGTEXT DEFAULT NULL, ADD manejo_plagas_enfermedades LONGTEXT DEFAULT NULL, ADD manejo_cosecha_conservacion LONGTEXT DEFAULT NULL, CHANGE codigo codigo INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        
      $this->addSql('ALTER TABLE variedad DROP manejo_cultivo, DROP manejo_siembra_plantacion, DROP manejo_suelo_desherbado, DROP manejo_asociacion_rotacion_cultivos, DROP manejo_poda_entutorado, DROP manejo_abonado_riego, DROP manejo_plagas_enfermedades, DROP manejo_cosecha_conservacion, CHANGE codigo codigo INT NOT NULL');
    }
}
