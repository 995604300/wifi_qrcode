<?php

namespace mdm\admin\components;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\Query;
use yii\rbac\Rule;

/**
 * DbManager代表将授权信息存储在数据库中的授权管理器。
 *
 * 数据库连接由 [[$db]]. 数据库模式可以通过应用迁移来初始化
 *
 * ```
 * yii migrate --migrationPath=@yii/rbac/migrations/
 * ```
 *
 * If you don't want to use migration and need SQL instead, files for all databases are in migrations directory.
 *
 * You may change the names of the three tables used to store the authorization data by setting [[\yii\rbac\DbManager::$itemTable]],
 * [[\yii\rbac\DbManager::$itemChildTable]] and [[\yii\rbac\DbManager::$assignmentTable]].
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since  1.0
 */
class DbManager extends \yii\rbac\DbManager
{
    /**
     * Memory cache of assignments
     *
     * @var array
     */
    private $_assignments = [];
    private $_childrenList;

    /**
     * @inheritdoc
     */
    public function getAssignments($userId)
    {
        if (!isset($this->_assignments[$userId])) {
            $this->_assignments[$userId] = parent::getAssignments($userId);
        }
        return $this->_assignments[$userId];
    }

    /**
     * @inheritdoc
     */
    protected function getChildrenList()
    {
        if ($this->_childrenList === null) {
            $this->_childrenList = parent::getChildrenList();
        }
        return $this->_childrenList;
    }

    /**
     * Populates an auth item with the data fetched from database.
     *
     * @param array $row the data from the auth item table
     * @return Item the populated auth item instance (either Role or Permission)
     */
    protected function populateItem($row)
    {
        $class = $row['type'] == Item::TYPE_PERMISSION ? Permission::className() : Role::className();

        if (!isset($row['data']) || ($data = @unserialize(is_resource($row['data']) ? stream_get_contents($row['data']) : $row['data'])) === false) {
            $data = null;
        }

        return new $class([
                              'id' => $row['id'],
                              'name' => $row['name'],
                              'parentid' => $row['parentid'],
                              'order' => $row['order'],
                              'description' => $row['description'],
                              'ruleName' => $row['rule_name'],
                              'data' => $data,
                              'createdAt' => $row['created_at'],
                              'updatedAt' => $row['updated_at'],
                          ]);
    }

    /**
     * @inheritdoc
     */
    public function createRole($name)
    {
        $role = new Role();
        $role->name = $name;
        return $role;
    }

    /**
     * @inheritdoc
     */
    public function createPermission($name)
    {
        $permission = new Permission();
        $permission->name = $name;
        return $permission;
    }

    /**
     * @inheritdoc
     */
    public function add($object)
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = \Yii::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->addRule($rule);
            }

            return $this->addItem($object);
        } elseif ($object instanceof Rule) {
            return $this->addRule($object);
        }

        throw new InvalidParamException('Adding unsupported object type.');
    }

    /**
     * @inheritdoc
     */
    public function remove($object)
    {
        if ($object instanceof Item) {
            return $this->removeItem($object);
        } elseif ($object instanceof Rule) {
            return $this->removeRule($object);
        }

        throw new InvalidParamException('Removing unsupported object type.');
    }

    /**
     * @inheritdoc
     */
    public function update($name, $object)
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = \Yii::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->addRule($rule);
            }

            return $this->updateItem($name, $object);
        } elseif ($object instanceof Rule) {
            return $this->updateRule($name, $object);
        }

        throw new InvalidParamException('Updating unsupported object type.');
    }

    /**
     * @inheritdoc
     */
    public function getRole($name)
    {
        $item = $this->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_ROLE ? $item : null;
    }

    /**
     * @inheritdoc
     */
    public function getPermission($name)
    {
        $item = $this->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_PERMISSION ? $item : null;
    }

    /**
     * @inheritdoc
     */
    public function getRoles()
    {
        return $this->getItems(Item::TYPE_ROLE);
    }

    /**
     * Returns defaultRoles as array of Role objects.
     *
     * @since 2.0.12
     * @return Role[] default roles. The array is indexed by the role names
     */
    public function getDefaultRoleInstances()
    {
        $result = [];
        foreach ($this->defaultRoles as $roleName) {
            $result[$roleName] = $this->createRole($roleName);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        return $this->getItems(Item::TYPE_PERMISSION);
    }

    /**
     * Executes the rule associated with the specified auth item.
     *
     * If the item does not specify a rule, this method will return true. Otherwise, it will
     * return the value of [[Rule::execute()]].
     *
     * @param string|int $user   the user ID. This should be either an integer or a string representing
     *                           the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item       $item   the auth item that needs to execute its rule
     * @param array      $params parameters passed to [[CheckAccessInterface::checkAccess()]] and will be passed to the rule
     * @return bool the return value of [[Rule::execute()]]. If the auth item does not specify a rule, true will be returned.
     * @throws InvalidConfigException if the auth item has an invalid rule.
     */
    protected function executeRule($user, $item, $params)
    {
        if ($item->ruleName === null) {
            return true;
        }
        $rule = $this->getRule($item->ruleName);
        if ($rule instanceof Rule) {
            return $rule->execute($user, $item, $params);
        }

        throw new InvalidConfigException("Rule not found: {$item->ruleName}");
    }

    /**
     * Checks whether array of $assignments is empty and [[defaultRoles]] property is empty as well.
     *
     * @param Assignment[] $assignments array of user's assignments
     * @return bool whether array of $assignments is empty and [[defaultRoles]] property is empty as well
     * @since 2.0.11
     */
    protected function hasNoAssignments(array $assignments)
    {
        return empty($assignments) && empty($this->defaultRoles);
    }


    /**
     * @inheritdoc
     */
    protected function addItem($item)
    {
        $time = time();
        if ($item->createdAt === null) {
            $item->createdAt = $time;
        }
        if ($item->updatedAt === null) {
            $item->updatedAt = $time;
        }
        $this->db->createCommand()->insert($this->itemTable, [
                'name' => $item->name,
                'type' => $item->type,
                'parentid' => $item->parentid,
                'order' => $item->order,
                'description' => $item->description,
                'rule_name' => $item->ruleName,
                'data' => $item->data === null ? null : serialize($item->data),
                'created_at' => $item->createdAt,
                'updated_at' => $item->updatedAt,
            ])->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function updateItem($name, $item)
    {
        if ($item->name !== $name && !$this->supportsCascadeUpdate()) {
            $this->db->createCommand()->update($this->itemChildTable, ['parent' => $item->name], ['parent' => $name])
                     ->execute();
            $this->db->createCommand()->update($this->itemChildTable, ['child' => $item->name], ['child' => $name])
                     ->execute();
            $this->db->createCommand()
                     ->update($this->assignmentTable, ['item_name' => $item->name], ['item_name' => $name])->execute();
        }

        $item->updatedAt = time();

        $this->db->createCommand()->update($this->itemTable, [
                'name' => $item->name,
                'description' => $item->description,
                'parentid' => $item->parentid,
                'order' => $item->order,
                'rule_name' => $item->ruleName,
                'data' => $item->data === null ? null : serialize($item->data),
                'updated_at' => $item->updatedAt,
            ], [
                                               'name' => $name,
                                           ])->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function getItems($type)
    {
        $query = (new Query())->from($this->itemTable)->where(['type' => $type])->orderBy('order asc,id asc');

        $items = [];
        foreach ($query->all($this->db) as $row) {
            $items[$row['name']] = $this->populateItem($row);
        }

        return $items;
    }
}
