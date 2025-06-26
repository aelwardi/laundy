<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250626121959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service DROP CONSTRAINT fk_9e45c626e4818eb7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service DROP CONSTRAINT fk_7cee3c3e4818eb7
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ameublement (id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE co_sevice (id SERIAL NOT NULL, service_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F98FA788ED5CA9E6 ON co_sevice (service_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pressing (id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ameublement ADD CONSTRAINT FK_350B9302BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE co_sevice ADD CONSTRAINT FK_F98FA788ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pressing ADD CONSTRAINT FK_42EAC602BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pressing_couette DROP CONSTRAINT fk_ca65cad2bf396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pressing_couette
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_7cee3c3e4818eb7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service ADD icon VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service RENAME COLUMN pressing_couette_id TO service_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service ADD CONSTRAINT FK_7CEE3C3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7CEE3C3ED5CA9E6 ON details_service (service_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service RENAME COLUMN title TO icon
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_9e45c626e4818eb7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service ADD description TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service RENAME COLUMN pressing_couette_id TO coservice_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service RENAME COLUMN price_article TO price
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service ADD CONSTRAINT FK_9E45C626E9E3DBF9 FOREIGN KEY (coservice_id) REFERENCES co_sevice (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9E45C626E9E3DBF9 ON sub_service (coservice_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wash DROP price_kg
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wash DROP descrip_service
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service DROP CONSTRAINT FK_9E45C626E9E3DBF9
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pressing_couette (id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pressing_couette ADD CONSTRAINT fk_ca65cad2bf396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ameublement DROP CONSTRAINT FK_350B9302BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE co_sevice DROP CONSTRAINT FK_F98FA788ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pressing DROP CONSTRAINT FK_42EAC602BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ameublement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE co_sevice
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pressing
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_9E45C626E9E3DBF9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service DROP description
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service RENAME COLUMN coservice_id TO pressing_couette_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service RENAME COLUMN price TO price_article
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service ADD CONSTRAINT fk_9e45c626e4818eb7 FOREIGN KEY (pressing_couette_id) REFERENCES pressing_couette (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_9e45c626e4818eb7 ON sub_service (pressing_couette_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service DROP CONSTRAINT FK_7CEE3C3ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7CEE3C3ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service DROP icon
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service RENAME COLUMN service_id TO pressing_couette_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service ADD CONSTRAINT fk_7cee3c3e4818eb7 FOREIGN KEY (pressing_couette_id) REFERENCES pressing_couette (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_7cee3c3e4818eb7 ON details_service (pressing_couette_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wash ADD price_kg DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wash ADD descrip_service TEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service RENAME COLUMN icon TO title
        SQL);
    }
}
