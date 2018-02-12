<?php
    include ('model/Tasks.php');
    $task = new Tasks();
    $sql = $task->connectSelectDb();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Задачник</title>

    <link rel="stylesheet" href="view/css/bootstrap.min.css">
    <link href="view/css/style.css" rel="stylesheet">
    <link href="view/css/style-table.css" rel="stylesheet">

    <script src="view/js/jquery.js"></script>
    <script src="view/js/bootstrap.js"></script>
    <script src="view/js/table-pagination.js"></script>
    <script src="view/js/table-sorter.js"></script>

    <script type="text/javascript">
        //Сортировка главной таблицы
        $(document).ready(function() {
            $("table")
                .tablesorter({widthFixed: true, widgets: ['zebra']})
                .tablesorterPager({container: $("#pager")});
        });
    </script>
</head>

    <body>
        <div class="text-center">
            <a href="/admin.php"> Вход в админ-панель </a> <br>
            <!-- Кнопка, для открытия модального окна -->
            <button id = "button_add_task" type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackForm">
                Добавить задачу
            </button>
        </div>

        <!-- Форма создания новой задачи -->
        <?php include('view/blocks/form_new_task.php'); ?>

        <!-- Главная таблица -->
          <div class="container container_block">
              <table cellspacing="1" class="tablesorter">
                  <thead>
                      <tr>
                          <th>Изображение</th>
                          <th>Задача</th>
                          <th>Имя</th>
                          <th>Email</th>
                          <th>Выполнено</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($row = mysql_fetch_array($sql)) {
                          ?>
                          <tr>
                              <td><?php if($row['photo'] != null){ ?><img width="40" src = "<?php echo 'view/img/tasks/'.$row['photo']; ?>"><?php }?> </td>
                              <td><?php echo $row['text'] ?></td>
                              <td><?php echo $row['user_name'] ?></td>
                              <td><?php echo $row['user_email'] ?></td>
                              <td><?php if ($row['execute'] == 0) echo "Нет"; else echo "Да"; ?></td>
                          </tr>
                      <? }  ?>
                      </tbody>
              </table>
          </div>

          <script src="view/js/script.js"></script>

    </body>
</html>