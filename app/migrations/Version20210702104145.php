<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702104145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonebook DROP FOREIGN KEY FK_E1D7BA438BAC62AF');
        $this->addSql('DROP INDEX IDX_E1D7BA438BAC62AF ON phonebook');
        $this->addSql('ALTER TABLE phonebook ADD city VARCHAR(255) DEFAULT NULL, DROP city_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phonebook ADD city_id INT DEFAULT NULL, DROP city');
        $this->addSql('ALTER TABLE phonebook ADD CONSTRAINT FK_E1D7BA438BAC62AF FOREIGN KEY (city_id) REFERENCES city_weather (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E1D7BA438BAC62AF ON phonebook (city_id)');
    }
}
