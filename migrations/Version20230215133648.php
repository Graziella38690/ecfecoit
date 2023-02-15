<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215133648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFBEFD98D1');
        $this->addSql('DROP INDEX IDX_2D737AEFBEFD98D1 ON section');
        $this->addSql('ALTER TABLE section CHANGE training_id contained_in_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF6978B296 FOREIGN KEY (contained_in_id) REFERENCES training (id)');
        $this->addSql('CREATE INDEX IDX_2D737AEF6978B296 ON section (contained_in_id)');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FD823E37A');
        $this->addSql('DROP INDEX IDX_D5128A8FD823E37A ON training');
        $this->addSql('ALTER TABLE training DROP section_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF6978B296');
        $this->addSql('DROP INDEX IDX_2D737AEF6978B296 ON section');
        $this->addSql('ALTER TABLE section CHANGE contained_in_id training_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('CREATE INDEX IDX_2D737AEFBEFD98D1 ON section (training_id)');
        $this->addSql('ALTER TABLE training ADD section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('CREATE INDEX IDX_D5128A8FD823E37A ON training (section_id)');
    }
}
