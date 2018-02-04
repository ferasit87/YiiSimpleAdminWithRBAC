<?php

use yii\db\Migration;

/**
 * Class m180204_001051_init_rbac
 */
class m180204_001051_init_rbac extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // add "createOrder" permission
        $createOrder = $auth->createPermission('createOrder');
        $createOrder->description = 'Create a order';
        $auth->add($createOrder);

        // add "updateOrder" permission
        $updateOrder = $auth->createPermission('updateOrder');
        $updateOrder->description = 'Update order';
        $auth->add($updateOrder);

        // add "user" role and give this role the "createOrder" permission
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createOrder);

        // add "admin" role and give this role the "updateOrder" permission
        // as well as the permissions of the "user" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updateOrder);
        $auth->addChild($admin, $user);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);


        // add the "updateOwnOrder" permission and associate the rule with it.
        $updateOwnOrder = $auth->createPermission('updateOwnOrder');
        $updateOwnOrder->description = 'Update own order';
        // add the rule
        $rule = new \app\rbac\AuthorRule;
        $auth->add($rule);

        // add the "updateOwnOrder" permission and associate the rule with it.
        $updateOwnOrder = $auth->createPermission('updateOwnOrder');
        $updateOwnOrder->description = 'Update own order';
        $updateOwnOrder->ruleName = $rule->name;
        $auth->add($updateOwnOrder);

        // "updateOwnOrder" will be used from "updateOrder"
        $auth->addChild($updateOwnOrder, $updateOrder);

        // allow "author" to update their own orders
        $auth->addChild($user, $updateOwnOrder);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180204_001051_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
