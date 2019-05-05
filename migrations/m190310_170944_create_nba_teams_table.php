<?php

use yii\db\Migration;

/**
 * Handles the creation of table `nba_teams`.
 */
class m190310_170944_create_nba_teams_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('nba_team', [
            'id' => $this->primaryKey(),
            'team_name' => $this->string()->notNull(),
            'abbreviation' => $this->string(3)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('nba_team');
    }
}
