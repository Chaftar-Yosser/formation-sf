<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215151245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_option (property_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_24F16FCC549213EC (property_id), INDEX IDX_24F16FCCA7C41D6F (option_id), PRIMARY KEY(property_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_option ADD CONSTRAINT FK_24F16FCC549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_option ADD CONSTRAINT FK_24F16FCCA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE option_property');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_property (option_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_AB856D7AA7C41D6F (option_id), INDEX IDX_AB856D7A549213EC (property_id), PRIMARY KEY(option_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE option_property ADD CONSTRAINT FK_AB856D7AA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_property ADD CONSTRAINT FK_AB856D7A549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE property_option');
        $this->addSql('ALTER TABLE `option` CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE property CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE postal_code postal_code VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
