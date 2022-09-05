<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905123717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143E6ADA943');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP INDEX IDX_C0155143E6ADA943 ON blog');
        $this->addSql('ALTER TABLE blog ADD date DATE DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE cat_id categorie_id INT DEFAULT NULL, CHANGE description descri VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_C0155143BCF5E72D ON blog (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143BCF5E72D');
        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP INDEX IDX_C0155143BCF5E72D ON blog');
        $this->addSql('ALTER TABLE blog DROP date, CHANGE image image VARCHAR(255) NOT NULL, CHANGE categorie_id cat_id INT DEFAULT NULL, CHANGE descri description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143E6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id)');
        $this->addSql('CREATE INDEX IDX_C0155143E6ADA943 ON blog (cat_id)');
    }
}
