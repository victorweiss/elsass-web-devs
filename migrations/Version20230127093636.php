<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127093636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, is_booking_available TINYINT(1) NOT NULL, total_seats VARCHAR(50) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, admin_note LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_booking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, event_id INT DEFAULT NULL, is_presenting TINYINT(1) DEFAULT NULL, message LONGTEXT DEFAULT NULL, INDEX IDX_655B4471A76ED395 (user_id), INDEX IDX_655B447171F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_booking ADD CONSTRAINT FK_655B4471A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event_booking ADD CONSTRAINT FK_655B447171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_booking DROP FOREIGN KEY FK_655B4471A76ED395');
        $this->addSql('ALTER TABLE event_booking DROP FOREIGN KEY FK_655B447171F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_booking');
        $this->addSql('ALTER TABLE user DROP created_at');
    }
}
