<?php
    include ('model/Tasks.php');
    session_start();
    $task = new Tasks();
    $sql = $task->connectSelectDb();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="view/css/bootstrap.min.css">
    <link href="view/css/style.css" rel="stylesheet">
    <link href="view/css/style-table.css" rel="stylesheet">

    <script src="view/js/jquery.js"></script>
    <script src="view/js/bootstrap.js"></script>
    <script src="view/js/table-sorter.js"></script>

    <script type="text/javascript">
        //Авторизация админа
        var secret;
        <?php if (!isset($_SESSION['admin'])) { ?>
            while (secret !== "123") {
                secret = prompt("What is the secret password?");
            }
        <?php
            $_SESSION['admin'] = "Yes";
        }
        ?>

        /* Сохраняет имя и статус задачи */
        function my_save(field, id, value) {
            var formData = new FormData();
            formData.append('field', field);
            formData.append('id', id);
            formData.append('value', value);

            $.ajax({
                //метод передачи запроса - POST
                type: "POST",
                //URL-адрес запроса
                url: "/controller/AdminController.php",
                //передаваемые данные - formData
                data: formData,
                // не устанавливать тип контента, т.к. используется FormData
                contentType: false,
                // не обрабатывать данные formData
                processData: false,
                // отключить кэширование результатов в браузере
                cache: false,
                success: function (data) {
                    var $data =  JSON.parse(data);
                }
            });
        }

        //Сортировка главной таблицы
        $(document).ready(function() {
            $("table")
                .tablesorter({widthFixed: true, widgets: ['zebra']})
                // .tablesorterPager({container: $("#pager")});
        });
    </script>
</head>
    <body>

      <div class="text-center">
        <!-- Кнопка, для открытия модального окна -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackForm">
          Добавить задачу
        </button>
      </div>

      <!-- Форма создания новой задачи -->
      <?php include("view/blocks/form_new_task.php"); ?>

      <!-- Главная таблица -->
      <div class="container container_block">
          <form>
              <table cellspacing="1" class="tablesorter">
                  <thead>
                  <tr>
                      <th>Выполнено</th>
                      <th>Изображение</th>
                      <th>Задача</th>
                      <th>Имя</th>
                      <th>Email</th>
                  </tr>
                  </thead>

                  <tbody>
                      <?php
                        while($row = mysql_fetch_array($sql)) {
                          ?>
                          <tr>
                              <td><input type = "checkbox" name = "execute" <?php if($row['execute']== 1) echo ("checked"); ?> onchange="my_save('execute', <?php echo $row['id'] ?>, this.checked)"> </td>
                              <td><?php if($row['photo'] != null){ ?><img width = "40" src = "<?php echo 'view/img/tasks/'.$row['photo']; ?>"><?php }?> </td>
                              <td><input class = "input_field" name = "message" type = "text" value = "<?php echo $row['text'] ?>" onchange="my_save('message', <?php echo $row['id'] ?>, this.value)"></td>
                              <td><?php echo $row['user_name'] ?></td>
                              <td><?php echo $row['user_email'] ?></td>
                          </tr>
                      <? } ?>
                  </tbody>
              </table>
          </form>
      </div>

      <script src="view/js/script.js"></script>

    </body>
</html>