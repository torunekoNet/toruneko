<?php

/**
 * This is the model class for table "blog_comment".
 *
 * The followings are the available columns in table 'blog_comment':
 * @property integer $id
 * @property integer $fid
 * @property integer $post_id
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property integer $time
 * @property string $ip
 * @property string $content
 * @property integer $approved
 */
class BlogComment extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fid, post_id, user_id, username, email, time, ip, content', 'required'),
            array('fid, post_id, user_id, time, approved', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 20),
            array('email', 'length', 'max' => 50),
            array('ip', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, fid, post_id, user_id, username, email, time, ip, content, approved', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'reply' => array(RedActiveRecord::HAS_MANY, 'BlogComment', 'fid')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'fid' => 'Fid',
            'post_id' => 'Post',
            'user_id' => 'User',
            'username' => 'Username',
            'email' => 'Email',
            'time' => 'Time',
            'ip' => 'Ip',
            'content' => 'Content',
            'approved' => 'Approved',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('fid', $this->fid);
        $criteria->compare('post_id', $this->post_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('time', $this->time);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('approved', $this->approved);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogComment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
