<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use common\models\base\BaseModel;

/**
 * This is the model class for table "log".
 *
 * @property string $username
 * @property string $ip
 * @property string $data
 * @property string $created_at
 */
class UploadForm extends BaseModel
{
    public $fileUpload;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileUpload'], 'file','skipOnEmpty' => true]
        ];
    }


}
