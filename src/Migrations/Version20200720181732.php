<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720181732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE companies_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD company_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FE51E9644 FOREIGN KEY (company_type_id) REFERENCES companies_types (id)');
        $this->addSql('CREATE INDEX IDX_4FBF094FE51E9644 ON company (company_type_id)');
        $this->addSql('ALTER TABLE associate_company_info ADD company_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE associate_company_info ADD CONSTRAINT FK_37D90DECE51E9644 FOREIGN KEY (company_type_id) REFERENCES companies_types (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37D90DECE51E9644 ON associate_company_info (company_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FE51E9644');
        $this->addSql('ALTER TABLE associate_company_info DROP FOREIGN KEY FK_37D90DECE51E9644');
        $this->addSql('DROP TABLE companies_types');
        $this->addSql('DROP INDEX UNIQ_37D90DECE51E9644 ON associate_company_info');
        $this->addSql('ALTER TABLE associate_company_info DROP company_type_id');
        $this->addSql('DROP INDEX IDX_4FBF094FE51E9644 ON company');
        $this->addSql('ALTER TABLE company DROP company_type_id');
    }
}
