<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191012042854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_creation DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences_missions (mission_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_7BE5043DBE6CAE90 (mission_id), INDEX IDX_7BE5043D15761DAB (competence_id), PRIMARY KEY(mission_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences_users (user_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_DF457F81A76ED395 (user_id), INDEX IDX_DF457F8115761DAB (competence_id), PRIMARY KEY(user_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_creation DATETIME DEFAULT NULL, date DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, INDEX IDX_9067F23CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_competence (mission_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_D6D445E4BE6CAE90 (mission_id), INDEX IDX_D6D445E415761DAB (competence_id), PRIMARY KEY(mission_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competences_missions ADD CONSTRAINT FK_7BE5043DBE6CAE90 FOREIGN KEY (mission_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competences_missions ADD CONSTRAINT FK_7BE5043D15761DAB FOREIGN KEY (competence_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE competences_users ADD CONSTRAINT FK_DF457F81A76ED395 FOREIGN KEY (user_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competences_users ADD CONSTRAINT FK_DF457F8115761DAB FOREIGN KEY (competence_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mission_competence ADD CONSTRAINT FK_D6D445E4BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_competence ADD CONSTRAINT FK_D6D445E415761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD date_confirmation DATETIME DEFAULT NULL, ADD date_creation DATETIME DEFAULT NULL, ADD est_actif TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competences_missions DROP FOREIGN KEY FK_7BE5043DBE6CAE90');
        $this->addSql('ALTER TABLE competences_users DROP FOREIGN KEY FK_DF457F81A76ED395');
        $this->addSql('ALTER TABLE mission_competence DROP FOREIGN KEY FK_D6D445E415761DAB');
        $this->addSql('ALTER TABLE competences_missions DROP FOREIGN KEY FK_7BE5043D15761DAB');
        $this->addSql('ALTER TABLE mission_competence DROP FOREIGN KEY FK_D6D445E4BE6CAE90');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competences_missions');
        $this->addSql('DROP TABLE competences_users');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_competence');
        $this->addSql('ALTER TABLE user DROP date_confirmation, DROP date_creation, DROP est_actif');
    }
}
