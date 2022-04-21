<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421164859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson ADD creatby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F34EB34D16 FOREIGN KEY (creatby_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_F87474F34EB34D16 ON lesson (creatby_id)');
        $this->addSql('ALTER TABLE training CHANGE description description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F34EB34D16');
        $this->addSql('DROP INDEX IDX_F87474F34EB34D16 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP creatby_id');
        $this->addSql('ALTER TABLE training CHANGE description description VARCHAR(255) NOT NULL');
    }
}
