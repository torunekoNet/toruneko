<?php

/**
 * This is the model class for table "blog_archive".
 *
 * The followings are the available columns in table 'blog_archive':
 * @property string $id
 * @property string $name
 * @property integer $post_count
 */
class BlogArchive extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'archive';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, name, post_count', 'required'),
            array('post_count', 'numerical', 'integerOnly' => true),
            array('id', 'length', 'max' => 6),
            array('name', 'length', 'max' => 8),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, post_count', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'post_count' => 'Post Count',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('post_count', $this->post_count);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogArchive the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function renderArchive()
    {
        $cache = Yii::app()->cache;
        $key = 'app.models.BlogArchive.renderArchive';
        if (($archive = $cache->get($key)) == false) {
            $archive = $this->findAll(array(
                'condition' => 'post_count>0',
                'order' => 'id desc',
                'limit' => 10
            ));
            $cache->set($key, $archive);
        }
        return $archive;
    }
}
