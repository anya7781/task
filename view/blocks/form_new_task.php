      <!-- Форма обратной связи в модальном окне -->
      <div class="modal fade" id="feedbackForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Создание новой задачи</h4>
            </div>

            <div class="modal-body">
                <!-- Сообщение, отображаемое в случае успешной отправки данных -->
                <div class="alert alert-success hidden" role="alert" id="msgSubmit">
                  <strong>Внимание!</strong> Ваша задача добавлена.
                </div>
                <!-- Форма новой задачи связи -->
                <form id="messageForm" enctype="multipart/form-data">
                  <div class="row">
                    <div id="error" class="col-sm-12"></div>
                    <!-- Имя и email пользователя -->
                    <div class="col-sm-6">
                      <!-- Имя пользователя -->
                      <div class="form-group has-feedback">
                        <label for="name" class="control-label">Введите ваше имя:</label>
                        <input type="text" id="name" name="name" class="form-control" required="required" value="" placeholder="Например, Иван Иванович" minlength="2" maxlength="30">
                        <span class="glyphicon form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- Email пользователя -->
                      <div class="form-group has-feedback">
                        <label for="email" class="control-label">Введите email:</label>
                        <input type="email" id="email" name="email" class="form-control" required="required"  value="" placeholder="Например, ivan@mail.ru" maxlength="30">
                        <span class="glyphicon form-control-feedback"></span>
                      </div>
                    </div>
                  </div>
                  <!-- Текст задачи -->
                  <div class="form-group has-feedback">
                    <label for="message" class="control-label">Введите задачу:</label>
                    <textarea id="message" class="form-control" rows="3" required="required"></textarea>
                  </div>
                  <!-- Фото задачи-->
                  <div class="form-group">
                    <label for="images" class="control-label">Прикрепить к задаче изображение: </label>
                    <input type="file" name="images" id = "images">
                  </div>

                  <!-- Кнопка, отправляющая форму по технологии AJAX -->
                  <button name="send-message" type="submit" class="btn btn-primary pull-right">Добавить задачу</button>
                </form><!-- Конец формы -->
                <div class="clearfix"></div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
          </div>
        </div>
      </div>