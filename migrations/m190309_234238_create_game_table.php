<?php

use yii\db\Migration;

/**
 * Handles the creation of table `game`.
 */
class m190309_234238_create_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('game', [
            'id' => $this->primaryKey(),
            'h_abrv' => $this->string()->notNull(),
            'v_abrv' => $this->string()->notNull(),
            'dt' => $this->string()->notNull(),
            'r_reg' => $this->string(),
            'is_lp' => $this->boolean(),
            'sg' => $this->boolean(),
            'h_team_score' => $this->integer(),
            'v_team_score' => $this->integer(),
            'winner' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('game');
    }
}
