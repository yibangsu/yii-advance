<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'password'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // password has to be string
            ['password', 'string', 'max' => 32],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        $temp = 'suyibang@123.com...';

        return Yii::$app->mailer->compose()
            ->setTo($email)
            //->setFrom([$this->email => $this->name])
            ->setCc($this->email)
            ->setSubject("signup requirement")
            ->setTextBody("name: " . $this->name . "\r\n" .
                          "password: " . $this->password . "\r\n")
            ->send();
    }
}
