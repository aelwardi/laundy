<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250624094206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE address (id SERIAL NOT NULL, address VARCHAR(255) NOT NULL, details TEXT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE comment (id SERIAL NOT NULL, ordere_id INT DEFAULT NULL, content TEXT NOT NULL, rating INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9474526CBA8C9295 ON comment (ordere_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE details_service (id SERIAL NOT NULL, pressing_couette_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7CEE3C3E4818EB7 ON details_service (pressing_couette_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE how_works (id SERIAL NOT NULL, laundry_id INT DEFAULT NULL, indice VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, rang INT NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_ECA924DCC330BCF4 ON how_works (laundry_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE item (id SERIAL NOT NULL, ordere_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description TEXT NOT NULL, price DOUBLE PRECISION NOT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1F1B251EBA8C9295 ON item (ordere_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE laundry (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE livraison (id SERIAL NOT NULL, ordere_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, full_address VARCHAR(255) NOT NULL, collected_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, livred_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, instructions TEXT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A60C9F1FBA8C9295 ON livraison (ordere_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message (id SERIAL NOT NULL, support_ticket_id INT DEFAULT NULL, usere_id INT DEFAULT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B6BD307FC6D2DC64 ON message (support_ticket_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B6BD307F12C1BC7E ON message (usere_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "order" (id SERIAL NOT NULL, usere_id INT DEFAULT NULL, price_total DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F529939812C1BC7E ON "order" (usere_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pressing_couette (id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE section (id SERIAL NOT NULL, laundry_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2D737AEFC330BCF4 ON section (laundry_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id SERIAL NOT NULL, laundry_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, title VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E19D9AD2C330BCF4 ON service (laundry_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE social_media (id SERIAL NOT NULL, laundry_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_20BC159EC330BCF4 ON social_media (laundry_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE step (id SERIAL NOT NULL, how_work_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, rang INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_43B9FE3C9FE05ABF ON step (how_work_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sub_service (id SERIAL NOT NULL, pressing_couette_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price_article DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9E45C626E4818EB7 ON sub_service (pressing_couette_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE support_ticket (id SERIAL NOT NULL, usere_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1F5A4D5312C1BC7E ON support_ticket (usere_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id SERIAL NOT NULL, laundry_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649C330BCF4 ON "user" (laundry_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_address (user_id INT NOT NULL, address_id INT NOT NULL, PRIMARY KEY(user_id, address_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5543718BA76ED395 ON user_address (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5543718BF5B7AF75 ON user_address (address_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE wash (id INT NOT NULL, price_kg DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD CONSTRAINT FK_9474526CBA8C9295 FOREIGN KEY (ordere_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service ADD CONSTRAINT FK_7CEE3C3E4818EB7 FOREIGN KEY (pressing_couette_id) REFERENCES pressing_couette (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE how_works ADD CONSTRAINT FK_ECA924DCC330BCF4 FOREIGN KEY (laundry_id) REFERENCES laundry (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE item ADD CONSTRAINT FK_1F1B251EBA8C9295 FOREIGN KEY (ordere_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FBA8C9295 FOREIGN KEY (ordere_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC6D2DC64 FOREIGN KEY (support_ticket_id) REFERENCES support_ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307F12C1BC7E FOREIGN KEY (usere_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "order" ADD CONSTRAINT FK_F529939812C1BC7E FOREIGN KEY (usere_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pressing_couette ADD CONSTRAINT FK_CA65CAD2BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE section ADD CONSTRAINT FK_2D737AEFC330BCF4 FOREIGN KEY (laundry_id) REFERENCES laundry (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2C330BCF4 FOREIGN KEY (laundry_id) REFERENCES laundry (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE social_media ADD CONSTRAINT FK_20BC159EC330BCF4 FOREIGN KEY (laundry_id) REFERENCES laundry (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C9FE05ABF FOREIGN KEY (how_work_id) REFERENCES how_works (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service ADD CONSTRAINT FK_9E45C626E4818EB7 FOREIGN KEY (pressing_couette_id) REFERENCES pressing_couette (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE support_ticket ADD CONSTRAINT FK_1F5A4D5312C1BC7E FOREIGN KEY (usere_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649C330BCF4 FOREIGN KEY (laundry_id) REFERENCES laundry (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_address ADD CONSTRAINT FK_5543718BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_address ADD CONSTRAINT FK_5543718BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wash ADD CONSTRAINT FK_D9C22571BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP CONSTRAINT FK_9474526CBA8C9295
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE details_service DROP CONSTRAINT FK_7CEE3C3E4818EB7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE how_works DROP CONSTRAINT FK_ECA924DCC330BCF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE item DROP CONSTRAINT FK_1F1B251EBA8C9295
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livraison DROP CONSTRAINT FK_A60C9F1FBA8C9295
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP CONSTRAINT FK_B6BD307FC6D2DC64
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP CONSTRAINT FK_B6BD307F12C1BC7E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "order" DROP CONSTRAINT FK_F529939812C1BC7E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pressing_couette DROP CONSTRAINT FK_CA65CAD2BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE section DROP CONSTRAINT FK_2D737AEFC330BCF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2C330BCF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE social_media DROP CONSTRAINT FK_20BC159EC330BCF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE step DROP CONSTRAINT FK_43B9FE3C9FE05ABF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_service DROP CONSTRAINT FK_9E45C626E4818EB7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE support_ticket DROP CONSTRAINT FK_1F5A4D5312C1BC7E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649C330BCF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_address DROP CONSTRAINT FK_5543718BA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_address DROP CONSTRAINT FK_5543718BF5B7AF75
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wash DROP CONSTRAINT FK_D9C22571BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE address
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE details_service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE how_works
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE laundry
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE livraison
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "order"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pressing_couette
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE section
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE social_media
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE step
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sub_service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE support_ticket
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_address
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE wash
        SQL);
    }
}
