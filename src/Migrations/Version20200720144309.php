<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720144309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity_sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_other VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE associate_company_info (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, company_type_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_37D90DEC217BBB47 (person_id), UNIQUE INDEX UNIQ_37D90DECE51E9644 (company_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE priority (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE associate_company_info ADD CONSTRAINT FK_37D90DEC217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE associate_company_info ADD CONSTRAINT FK_37D90DECE51E9644 FOREIGN KEY (company_type_id) REFERENCES company_type (id)');
        $this->addSql('ALTER TABLE company ADD company_type_id INT DEFAULT NULL, ADD activity_sector_id INT DEFAULT NULL, ADD priority_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FE51E9644 FOREIGN KEY (company_type_id) REFERENCES company_type (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F398DEFD0 FOREIGN KEY (activity_sector_id) REFERENCES activity_sector (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FE51E9644 ON company (company_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F398DEFD0 ON company (activity_sector_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F497B19F9 ON company (priority_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F398DEFD0');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FE51E9644');
        $this->addSql('ALTER TABLE associate_company_info DROP FOREIGN KEY FK_37D90DECE51E9644');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F497B19F9');
        $this->addSql('DROP TABLE activity_sector');
        $this->addSql('DROP TABLE company_type');
        $this->addSql('DROP TABLE associate_company_info');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP INDEX UNIQ_4FBF094FE51E9644 ON company');
        $this->addSql('DROP INDEX UNIQ_4FBF094F398DEFD0 ON company');
        $this->addSql('DROP INDEX UNIQ_4FBF094F497B19F9 ON company');
        $this->addSql('ALTER TABLE company DROP company_type_id, DROP activity_sector_id, DROP priority_id');
    }
}
