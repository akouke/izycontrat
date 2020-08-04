<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200728184850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP INDEX UNIQ_4FBF094FB40A33C7, ADD INDEX IDX_4FBF094FB40A33C7 (president_id)');
        $this->addSql('ALTER TABLE company DROP INDEX UNIQ_4FBF094FEE42F96, ADD INDEX IDX_4FBF094FEE42F96 (general_director_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP INDEX IDX_4FBF094FB40A33C7, ADD UNIQUE INDEX UNIQ_4FBF094FB40A33C7 (president_id)');
        $this->addSql('ALTER TABLE company DROP INDEX IDX_4FBF094FEE42F96, ADD UNIQUE INDEX UNIQ_4FBF094FEE42F96 (general_director_id)');
    }
}
