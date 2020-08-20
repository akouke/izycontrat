<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812094212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email_newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, post LONGTEXT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_email_newsletter (newsletter_id INT NOT NULL, email_newsletter_id INT NOT NULL, INDEX IDX_7D7B3622DB1917 (newsletter_id), INDEX IDX_7D7B36D0EC0ABF (email_newsletter_id), PRIMARY KEY(newsletter_id, email_newsletter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE newsletter_email_newsletter ADD CONSTRAINT FK_7D7B3622DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_email_newsletter ADD CONSTRAINT FK_7D7B36D0EC0ABF FOREIGN KEY (email_newsletter_id) REFERENCES email_newsletter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter_email_newsletter DROP FOREIGN KEY FK_7D7B36D0EC0ABF');
        $this->addSql('ALTER TABLE newsletter_email_newsletter DROP FOREIGN KEY FK_7D7B3622DB1917');
        $this->addSql('DROP TABLE email_newsletter');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_email_newsletter');
    }
}
