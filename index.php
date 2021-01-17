<?php

$active_page = "/web.monobank/";
$title = "Консоль";
$body_class = "";

include "includes/header.php";
include "php/currency.php";
include "php/statement.php";

?>
<main class="wrap d-flex">
  <?php include('includes/sidebar.php'); ?>
  <br><br><br>
  <div class="container">
  <div class="catalog__inner">
    <div class="charts userinfo">
        <?php if(!isset($response['errorDescription'])): ?>
        <div class="charts__item">
          <h2 class="charts__title">Карточка пользователя</h2>
          <ul class="userinfo-l">
            <li class="userinfo-l-i">
              <span class="userinfo__key">Имя:</span> 
              <span class="userinfo__val"><?php echo $response['name']; ?></span>
            </li>
            <!-- Tabs -->
            <li class="userinfo-l-i tabs">

              <!-- tabs titles -->
              <ul class='tabs__captions d-iflex'>
                <?php
                  $j = 1; // counter
                  $class = ""; // active

                  foreach ($response as $key){
                    if(is_array($key)){
                      $i = 1;
                      foreach($key as $key2){
                        $j == 1 ? $class = "active" : $class = " "; $j++;
                        echo '<li class="'.$class.'"><a href="#tab'.$i.'"> Карта '.$i.'</a></li>';
                        $i++;
                      }
                    };
                  };
                ?>
              </ul>


              <!-- tabs content -->
              <?php
                $i = 1; // counter
                $class = ""; // active

                foreach ($response as $key):
                  if(is_array($key)):
                    foreach($key as $key2):
                      $i == 1 ? $class = "active" : $class = ""; $i++;
                      ?>
                      <ul class="userinfo-l userinfo-l--second tabs__content <?php echo $class ?>">
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">ID Аккаунта:</span>
                          <span class="userinfo__val"><?php echo $key2['id']; ?></span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">Номер карты:</span>
                          <span class="userinfo__val">
                            <?php 
                              if( is_array($key2) ){
                                foreach($key2 as $key3){
                                  if( is_array($key3) ){
                                    foreach($key3 as $key4=>$value){
                                      echo $value;
                                    }
                                  }
                                }
                              }
                            ?>
                          </span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">Валюта: </span>
                          <span class="userinfo__val"><?php echo get_currency_symbol($key2['currencyCode']); ?></span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">Баланс: </span>
                          <span class="userinfo__val"><?php echo ($key2['balance'] / 100); ?></span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">Кредитный лимит:</span>
                          <span class="userinfo__val"><?php echo ($key2['creditLimit'] / 100); ?></span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">Тип карты: </span>
                          <span class="userinfo__val"><?php echo $key2['type'] ?></span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">Тип кэшбека: </span>
                          <span class="userinfo__val"><?php echo $key2['cashbackType']; ?></span>
                        </li>
                        <li class="userinfo-l-i userinfo-l-i--second ripple-effect">
                          <span class="userinfo__key">IBAN: </span>
                          <span class="userinfo__val"><?php echo $key2['iban']; ?></span>
                        </li>
                      </ul>  
                    <?php
                    endforeach;
                  endif;
                endforeach;
              ?>
            </li>
          </ul>
          <ul class="spec-info">
            <li>
              <div class="input-group readonly">
                <input type="text" readonly id="clientID" placeholder=" " value="<?php echo $response['clientId']; ?>" class="active input-group__input">            
                <label for="clientID" class="input-group__label">ID Клиента</label>
                <span class="input-line"></span>
              </div>

            </li>
            <li>
              <div class="input-group readonly">
                <input type="text" readonly id="token" placeholder=" " value="<?php echo API_KEY; ?>" class="active input-group__input">            
                <label for="token" class="input-group__label">Токен</label>
                <span class="input-line"></span>
              </div>
            </li>
          </ul>
        </div>
        <div class="charts__item">
          <h2 class="charts__title">Движение средств за последний месяц<br>
            <?php
              // Номер карты какой пришел из формы
              if( isset($_POST['sendStatement']) ){
                foreach($response as $key){
                  if( is_array($key) ){
                    foreach($key as $key2){
                      if($key2['id'] == $_POST['accountID']){
                        foreach($key2 as $key3){
                          if( is_array($key3) ){
                            foreach($key3 as $key4=>$value){
                              echo $value;
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
              // Номер первой карты
              else{
                $i = 0;
                foreach($response as $key){
                  if( is_array($key) ){
                    foreach($key as $key2){
                      if( is_array($key2) ){
                        if($i == 0){
                          foreach($key2 as $key3){
                            if( is_array($key3) ){
                              foreach($key3 as $key4=>$value){
                                echo $value;
                              }
                            }
                          }
                        } $i++;
                      }
                    } 
                  }
                }
              }
            ?>
          </h2>
          <div id="chart"></div>
        </div>
        <div class="charts__item" style="grid-column: 1/3;">
          <?php
          $errors = [];
          if( isset($_POST['sendStatement']) ){

            if( $_POST['accountID'] == "" )
              $errors[] = "Введите Account ID";

            if(empty($errors))
              statement($_POST['accountID']);
          }
          else
            statement($account_id);
          ?>

          <form action="/web.monobank/index.php" method="POST" id="getStatementForm">
            <h3>Получить выписку для другого аккаунта: </h3> 
            
            <div class="input-group">
              <input type="text" placeholder=" " id="get_accountID" class="input-group__input" name="accountID" value="<?php echo @$_POST['accountID']; ?>">            
              <label for="get_accountID" class="input-group__label">Введите ID Аккаунта</label>
              <span class="input-line"></span>
              <p class="input-group__help help" style="color: #F44336"><?php if(!empty($errors)){ echo array_shift($errors); } ?></p>
            </div>
            <button type="submit" id="sendStatement" class="form__btn ripple-effect"  name="sendStatement">Отправить</button>
          </form>
        </div>
        <div class="charts__item">
          <h2 class="charts__title">Instagram Аналитика</h2>
          <div id="double_schedule"></div>
        </div>
        <?php else: echo "<br><br>".$response['errorDescription']; endif; ?>
    </div>
  </div>
</div>
<?php include "includes/footer.php";
