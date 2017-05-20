<?php

/**
 * This is the model class for table "blog_post".
 *
 * The followings are the available columns in table 'blog_post':
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property integer $time
 * @property string $date
 * @property integer $modified_time
 * @property string $title
 * @property string $abstract
 * @property string $content
 * @property string $category_id
 * @property string $category_name
 * @property integer $post_state
 * @property integer $comment_state
 * @property integer $comment_count
 */
class BlogPost extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, username, time, date, title, abstract, content, category_id, category_name', 'required'),
            array('user_id, time, modified_time, post_state, comment_state, comment_count', 'numerical', 'integerOnly' => true),
            array('username, category_id, category_name', 'length', 'max' => 20),
            array('date', 'length', 'max' => 6),
            array('title', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, username, time, date, modified_time, title, abstract, content, category_id, category_name, post_state, comment_state, comment_count', 'safe', 'on' => 'search'),
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
            'user_id' => 'User',
            'username' => 'Username',
            'time' => 'Time',
            'date' => 'Date',
            'modified_time' => 'Modified Time',
            'title' => 'Title',
            'abstract' => 'Abstract',
            'content' => 'Content',
            'category_id' => 'Category',
            'category_name' => 'Category Name',
            'post_state' => 'Post State',
            'comment_state' => 'Comment State',
            'comment_count' => 'Comment Count',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('time', $this->time);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('abstract', $this->abstract, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('category_name', $this->category_name, true);
        $criteria->compare('post_state', $this->post_state);
        $criteria->compare('comment_state', $this->comment_state);
        $criteria->compare('comment_count', $this->comment_count);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
