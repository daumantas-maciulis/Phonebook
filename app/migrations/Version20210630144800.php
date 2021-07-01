<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210630144800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE phonebook_user (phonebook_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7289CB2D1200F70D (phonebook_id), INDEX IDX_7289CB2DA76ED395 (user_id), PRIMARY KEY(phonebook_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phonebook_user ADD CONSTRAINT FK_7289CB2D1200F70D FOREIGN KEY (phonebook_id) REFERENCES phonebook (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phonebook_user ADD CONSTRAINT FK_7289CB2DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE shared_contacts');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shared_contacts (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, owner_id INT NOT NULL, shared_with_id INT NOT NULL, UNIQUE INDEX UNIQ_6664E4507E3C61F9 (owner_id), UNIQUE INDEX UNIQ_6664E450D14FE63F (shared_with_id), UNIQUE INDEX UNIQ_6664E450E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE shared_contacts ADD CONSTRAINT FK_6664E4507E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE shared_contacts ADD CONSTRAINT FK_6664E450E7A1254A FOREIGN KEY (contact_id) REFERENCES phonebook (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE shared_contacts ADD CONSTRAINT FK_6664E450D14FE63F FOREIGN KEY (shared_with_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE phonebook_user');
    }
}
