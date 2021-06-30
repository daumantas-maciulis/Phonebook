<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210630084747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonebook ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phonebook ADD CONSTRAINT FK_E1D7BA437E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E1D7BA437E3C61F9 ON phonebook (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonebook DROP FOREIGN KEY FK_E1D7BA437E3C61F9');
        $this->addSql('DROP INDEX IDX_E1D7BA437E3C61F9 ON phonebook');
        $this->addSql('ALTER TABLE phonebook DROP owner_id');
    }
}
