<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215145752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section ADD contained_in_id INT NOT NULL, DROP contained_in');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF6978B296 FOREIGN KEY (contained_in_id) REFERENCES training (id)');
        $this->addSql('CREATE INDEX IDX_2D737AEF6978B296 ON section (contained_in_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF6978B296');
        $this->addSql('DROP INDEX IDX_2D737AEF6978B296 ON section');
        $this->addSql('ALTER TABLE section ADD contained_in VARCHAR(255) NOT NULL, DROP contained_in_id');
    }
}
