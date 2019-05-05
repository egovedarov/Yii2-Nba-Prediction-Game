<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bets`.
 */
class m190312_220954_create_bets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bet', [
            'id' => $this->primaryKey(),
            'prediction' => $this->integer(),
            'game_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->string(),
            'is_correct' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('bet');
    }
}
