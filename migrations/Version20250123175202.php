<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123175202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks CHANGE main_img main_img VARCHAR(250) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1D902C118011F69 ON tricks (title_trick)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1D902C1989D9B62 ON tricks (slug)');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(64) DEFAULT NULL, ADD reset_token_expires_at DATETIME DEFAULT NULL, DROP token_new_pass_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E1D902C118011F69 ON tricks');
        $this->addSql('DROP INDEX UNIQ_E1D902C1989D9B62 ON tricks');
        $this->addSql('ALTER TABLE tricks CHANGE main_img main_img VARCHAR(250) NOT NULL');
        $this->addSql('ALTER TABLE user ADD token_new_pass_user VARCHAR(250) DEFAULT NULL, DROP reset_token, DROP reset_token_expires_at');
    }
}
