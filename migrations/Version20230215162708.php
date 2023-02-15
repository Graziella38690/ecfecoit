<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215162708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3D823E37A');
        $this->addSql('DROP INDEX IDX_F87474F3D823E37A ON lesson');
        $this->addSql('ALTER TABLE lesson ADD contained_in_id INT NOT NULL, DROP section_id, CHANGE creatby_id creatby_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F36978B296 FOREIGN KEY (contained_in_id) REFERENCES section (id)');
        $this->addSql('CREATE INDEX IDX_F87474F36978B296 ON lesson (contained_in_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F36978B296');
        $this->addSql('DROP INDEX IDX_F87474F36978B296 ON lesson');
        $this->addSql('ALTER TABLE lesson ADD section_id INT DEFAULT NULL, DROP contained_in_id, CHANGE creatby_id creatby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3D823E37A ON lesson (section_id)');
    }
}
