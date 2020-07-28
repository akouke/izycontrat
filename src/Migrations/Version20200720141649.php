<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720141649 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, president_id_id INT DEFAULT NULL, general_director_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, is_created TINYINT(1) NOT NULL, has_protection TINYINT(1) NOT NULL, has_associate TINYINT(1) NOT NULL, has_director TINYINT(1) NOT NULL, head_office INT DEFAULT NULL, capital_social INT DEFAULT NULL, bank_name VARCHAR(255) DEFAULT NULL, associates INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094FE61FC96F (president_id_id), UNIQUE INDEX UNIQ_4FBF094FEE42F96 (general_director_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FE61FC96F FOREIGN KEY (president_id_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FEE42F96 FOREIGN KEY (general_director_id) REFERENCES person (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE company');
    }
}
