<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dtoxin
 * Date: 9/21/13
 * Time: 9:41 PM
 * To change this template use File | Settings | File Templates.
 */

namespace App\Controllers;

use App\Core\Application;
use App\Core\Auth;
use \App\Models\User as User;

class UsersController extends \App\Core\Controller\GenericController
{
    public function signin()
    {
        if (\Usr::hasCredentials()) {
            Application::redirect('/users/profile');
        }
        $this->_render('users/signin');
    }

    public function signup()
    {
        $data = array();
        if (isset($_POST['User'])) {
            $validateErrorsFields = User::m()->validate($_POST['User']);
            $validateErrorsFiles = $this->_loadAndValidImage(array(
                // Максимум ~ 30 Кб.
                'max_size' => '30000',
                'allow_mime_types' => array(
                    'image/png', 'image/jpg', 'image/gif'
                ),
            ));
            if ($validateErrorsFields === true && $validateErrorsFiles === true){
                // Сохраним изображение
                if (!empty($_FILES['User']['name']['avatar'])) {
                    $unicFile = rand(100, 100000) . uniqid('', true) . User::m()->getImageFileExt($_FILES['User']['type']['avatar']);
                    $fullUploadFilePath = \Config::get('path', 'UPLOAD_PATH', '', true) . DIRECTORY_SEPARATOR . $unicFile;
                    $cpStat = move_uploaded_file($_FILES['User']['tmp_name']['avatar'], $fullUploadFilePath);
                }
                //Сохраняем пользователя в DB
                $modelUser = new User();
                $modelUser->prepareValuesFromPost();

                $saveStatus = User::m()->create(array(
                    ':email' => $_POST['User']['email'],
                    ':hash' => Auth::getInstance()->hashPassword($_POST['User']['password']),
                    ':name' => $_POST['User']['name'],
                    ':last_name' => $_POST['User']['last_name'],
                    ':mid_name' => $_POST['User']['mid_name'],
                    ':img_path' => '/static/upload/' . $unicFile,
                    ':addition' => $_POST['information']['data'],
                    'last_login' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                ));
                \App\Core\Application::redirect('/signin');
            } else {
                // отдаём пользователю ошибки
                // Если с пришло два массива с ошибками то совместим их
                $allErrors = array();
                if (is_array($validateErrorsFields) && is_array($validateErrorsFiles)){
                    $allErrors = array_merge($validateErrorsFields, $validateErrorsFiles);
                } else {
                    // методом взаимного исключения X)
                    if (is_array($validateErrorsFiles)) {
                        $allErrors = $validateErrorsFiles;
                    } else {
                        $allErrors = $validateErrorsFields;
                    }
                }
                //var_dump($validateErrorsFields);
                $data['errors'] = $allErrors;
            }
        } // end if post
        $this->_render('users/signup', $data);
    }

    /**
     * Ajax логин
     */
    public function jxSignin()
    {
        $stat = array();
        if (Auth::getInstance()->authenticate($_POST['email'], $_POST['psw'])) {
            $stat = array(
                'stat' => 1, // прошли
                'message' => '',
                'url' => '/users/profile'
            );
        } else {
            $stat = array(
                'stat' => 0, // прошли
                'message' => \L::t('Wrong password or e-mail'),
            );
        }

        $this->_renderJson($stat);
    }

    public function signout()
    {
        Auth::getInstance()->logout();
        \App\Core\Application::redirect('/');
    }


    public function profile()
    {
        $this->_accessControl();
        // get user info
        $id = $_SESSION['id'];
        $user = User::m()->getOne($id);
        $this->_render('users/profile', array(
            'user' => $user,
        ));
    }

    private function _loadAndValidImage ($validationParams = array())
    {
        if (empty($_FILES['User']['name']['avatar'])) { return true; } // нечего загружать
        $fileErrors = array('Image' => array());
        // Проверим статус загрузки, если отличается от 0 то выясним ошибку
        if ($_FILES['User']['error']['avatar'] != UPLOAD_ERR_OK) {
            // Есть ошибки
            array_push($fileErrors['Image'], $this->_getLoadFileErrors($_FILES['User']['error']['avatar']));
            return $fileErrors;
        }

        // Внутренних ошибок нет - смотрим ошибки согластно логики моего приложения
        // Размер файла не более 30 Kb
        if ($_FILES['User']['size']['avatar'] > $validationParams['max_size']) {
            array_push($fileErrors['Image'], 'The file size should be no larger than 30 Kb');
        }

        // Проверим формат
        if (!in_array($_FILES['User']['type']['avatar'], $validationParams['allow_mime_types'])) {
            array_push($fileErrors['Image'], 'Incorrect file format');
        }
        if (count($fileErrors['Image']) != 0) {
            // Ошибки есть
            return $fileErrors;
        }
        // Все ок
        return true;
    }

    private function _getLoadFileErrors($statCode)
    {
        $consts = array(
            UPLOAD_ERR_INI_SIZE => 'File size is too large',
            UPLOAD_ERR_FORM_SIZE => 'The file size should be no larger than 30 Kb',
            UPLOAD_ERR_PARTIAL => 'Internal error',
            UPLOAD_ERR_NO_FILE => 'File not loaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Internal error', // Об таких ошибка пользователю не нужно знать так как это открывает новый вектор атаки на мой ресурс поэтому пусть видет текст Internal error
            UPLOAD_ERR_CANT_WRITE => 'Internal error',
            UPLOAD_ERR_EXTENSION => 'Internal application error',
        );

        if (isset($consts[$statCode])) {
            return $consts[$statCode];
        }
        return false;
    }

    private function _accessControl()
    {
        if(!Auth::getInstance()->isAuthenticated()) {
            \App\Core\Application::redirect('/signin');
        }
    }
}