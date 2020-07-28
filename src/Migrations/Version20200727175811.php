<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727175811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE person_person');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE person_person (person_source INT NOT NULL, person_target INT NOT NULL, INDEX IDX_A879E1C0DACA1F4A (person_target), INDEX IDX_A879E1C0C32F4FC5 (person_source), PRIMARY KEY(person_source, person_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE person_person ADD CONSTRAINT FK_A879E1C0C32F4FC5 FOREIGN KEY (person_source) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_person ADD CONSTRAINT FK_A879E1C0DACA1F4A FOREIGN KEY (person_target) REFERENCES person (id) ON DELETE CASCADE');
    }
}
