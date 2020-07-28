<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720142351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FE61FC96F');
        $this->addSql('DROP INDEX UNIQ_4FBF094FE61FC96F ON company');
        $this->addSql('ALTER TABLE company CHANGE president_id_id president_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FB40A33C7 FOREIGN KEY (president_id) REFERENCES person (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FB40A33C7 ON company (president_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FB40A33C7');
        $this->addSql('DROP INDEX UNIQ_4FBF094FB40A33C7 ON company');
        $this->addSql('ALTER TABLE company CHANGE president_id president_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FE61FC96F FOREIGN KEY (president_id_id) REFERENCES person (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FE61FC96F ON company (president_id_id)');
    }
}
