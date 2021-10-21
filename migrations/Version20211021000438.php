<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021000438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE colour_id colour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D569C9B4C FOREIGN KEY (colour_id) REFERENCES colour (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D569C9B4C ON car (colour_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D569C9B4C');
        $this->addSql('DROP INDEX IDX_773DE69D569C9B4C ON car');
        $this->addSql('ALTER TABLE car CHANGE colour_id colour_id INT NOT NULL');
    }
}
