<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int $is_company 0 no, 1 yes
 * @property string|null $company_name
 * @property string|null $company_cui
 * @property string|null $company_reg
 * @property string|null $phone
 * @property string|null $phone2
 * @property string|null $description
 * @property string|null $addresses json with multiple addresses
 * @property string|null $preffered_invoice_address address key
 * @property string|null $preffered_delivery_address address key
 * @property string|null $admin_settings
 * @property string|null $site_settings
 * @property string|null $photo
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $old_values
 * @property int $status
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'is_company', 'status'], 'integer'],
            [['description', 'addresses', 'admin_settings', 'site_settings', 'old_values'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'company_name', 'company_cui', 'company_reg', 'phone', 'phone2', 'photo'], 'string', 'max' => 255],
            [['preffered_invoice_address', 'preffered_delivery_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'is_company' => 'Is Company',
            'company_name' => 'Company Name',
            'company_cui' => 'Company Cui',
            'company_reg' => 'Company Reg',
            'phone' => 'Phone',
            'phone2' => 'Phone2',
            'description' => 'Description',
            'addresses' => 'Addresses',
            'preffered_invoice_address' => 'Preffered Invoice Address',
            'preffered_delivery_address' => 'Preffered Delivery Address',
            'admin_settings' => 'Admin Settings',
            'site_settings' => 'Site Settings',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'old_values' => 'Old Values',
            'status' => 'Status',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

}
