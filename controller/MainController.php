<?php
    include ('../model/Tasks.php');
    session_start();

    $task = new Tasks();
    $db = $task->connectToDb();

    // переменная в которую будем сохранять результат работы
    $data['result']='error';
    $data['mes'] = '';

    // разрешённые типы файлов
    $allowedExtension = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

    // директория для хранения файлов ()
    $pathToFile = $_SERVER['DOCUMENT_ROOT'].'/view/img/tasks/';

    // максимальный размер файла
    $maxSizeFile = 524288;

    // функция для проверки длины строки
    function validStringLength($string,$min,$max) {
        $length = mb_strlen($string,'UTF-8');
        if (($length < $min) || ($length > $max)) {
            return false;
        }
        else {
            return true;
        }
    }

    // если данные были отправлены методом POST, то...
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $data['result']='success';

        //получить имя, которое ввёл пользователь
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if (!validStringLength($name,2,30)) {
                $data['result']='error';
            }
        } else {
            $data['result']='error';
        }
        //получить email, которое ввёл пользователь
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $data['result']='error';
                $data['mes'] = $data['mes'].'Неверный формат поля email.';
            }
        } else {
            $data['result']='error';
        }
        //получить сообщение, которое ввёл пользователь
        if (isset($_POST['message'])) {
            $message = $_POST['message'];
            if (!validStringLength($message,5,500)) {
                $data['mes']=$data['mes'].'Поле задачи содержит недопустимое количество символов.';
                $data['result']='error';
            }
        } else {
            $data['result']='error';
        }

        // если не существует ни одной ошибки, то прододжаем...
        if ($data['result']=='success') {
                //обработаем изображение, загруженное пользователем
                // если ассоциатианый массив $_FILES["images"] существует, то
                if(isset($_FILES["images"])) {
                        // если ошибок не возникло, т.е. файл был успешно загружен на сервер, то...
                            $nameFile = $_FILES['images']['name'];
                            // расширение загруженного пользователем файла в нижнем регистре
                            $extFile = mb_strtolower(pathinfo($nameFile, PATHINFO_EXTENSION));
                            // размер файла
                            $sizefile = $_FILES['images']['size'];
                            //myme-тип файла
                            $filetype = $_FILES['images']['type'];
                            // проверить расширение файла, размер файла и mime-тип
                            if (!array_key_exists($extFile, $allowedExtension)) {
                                $data['files']='Ошибка при загрузке файлов (неверное расширение).';
                                $data['result']='error';
                            } elseif ($sizefile > $maxSizeFile) {
                                $data['files']='Ошибка при загрузке файлов (размер превышает 512Кбайт).';
                                $data['result']='error';
                            } elseif (!in_array($filetype, $allowedExtension)){
                                $data['files']='Ошибка при загрузке файлов (неверный тип файла).';
                                $data['result']='error';
                            } else {
                                //ошибок не возникло, продолжаем...
                                // временное имя, с которым принятый файл был сохранён на сервере
                                $tmpFile = $_FILES['images']['tmp_name'];
                                // уникальное имя файла
                                $newFileName = uniqid('img_', true).'.'.$extFile;
                                // полное имя файла
                                $newFullFileName = $pathToFile.$newFileName;
                                // перемещаем файл в директорию
                                if (!move_uploaded_file($tmpFile, $newFullFileName)) {
                                    // ошибка при перемещении файла
                                    $data['files']='Ошибка при загрузке файлов.';
                                    $data['result']='error';
                                } else {
                                    $files = $newFullFileName;
                                }
                            }
                }
        }
    } else {
        //ошибка не существует ассоциативный массив $_POST["send-message"]
        $data['result']='error';
        $data['mes'] = $data['mes'].'Отсутствует post запрос';
    }


    $name = mysql_real_escape_string($name);
    $email = mysql_real_escape_string($email);
    $message = mysql_real_escape_string($message);

    //Если ошибок нет, то добавляем в базу
    if($data['result'] == 'success'){ //с картинкой
        if (isset($_FILES['images'])) {
            $photo = mysql_real_escape_string($newFileName);
            mysql_query("INSERT INTO Tasks (execute, photo, text, user_email, user_name)
       VALUES (0, '$photo', '$message', '$email', '$name')", $db);
        }
        else{ //без картинки
            mysql_query("INSERT INTO Tasks (execute, text, user_email, user_name)
       VALUES (0, '$message', '$email', '$name')", $db);
        }
    }

    echo json_encode($data);