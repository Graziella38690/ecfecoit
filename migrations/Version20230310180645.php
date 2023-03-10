<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310180645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, contained_in_id INT NOT NULL, creatby_id INT NOT NULL, title VARCHAR(255) NOT NULL, textlesson LONGTEXT NOT NULL, ressources LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_F87474F36978B296 (contained_in_id), INDEX IDX_F87474F34EB34D16 (creatby_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, creatby_id INT NOT NULL, contained_in_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_2D737AEF4EB34D16 (creatby_id), INDEX IDX_2D737AEF6978B296 (contained_in_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, creatby_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, datecreate DATE DEFAULT NULL, is_published TINYINT(1) NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_D5128A8F4EB34D16 (creatby_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, specialities LONGTEXT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(50) DEFAULT NULL, is_validated TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F36978B296 FOREIGN KEY (contained_in_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F34EB34D16 FOREIGN KEY (creatby_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF4EB34D16 FOREIGN KEY (creatby_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF6978B296 FOREIGN KEY (contained_in_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F4EB34D16 FOREIGN KEY (creatby_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F36978B296');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F34EB34D16');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF4EB34D16');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF6978B296');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F4EB34D16');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE `user`');
    }
}
