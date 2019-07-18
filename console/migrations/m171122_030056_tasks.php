<?php

use yii\db\Migration;

/**
 * Class m171122_030056_tasks
 */
class m171122_030056_tasks extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171122_030056_tasks cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'验证规则\'';
        }
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'product_name' => $this->string(50)->comment('项目'),
            'realname' => $this->string(50)->comment('姓名'),
            'cert_no' => $this->string(20)->notNull()->comment('身份证'),
            'phone' => $this->string(13)->notNull()->comment('手机号'),
            'ip' => $this->string(13)->notNull()->comment('来源ip'),
            'risk_level' => $this->smallInteger()->notNull()->defaultValue(0)->comment("风险级别"),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment("状态"),
            'created_at' => $this->integer()->notNull()->comment('录入时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions);
    }

    public function down()
    {
       // echo "m171122_030056_tasks cannot be reverted.\n";

        return false;
    }

}
