<?php 

$active_page = "currency";
$title = "Курс валют";
$body_class = "page-currency";

include "includes/header.php";
include "php/currency.php";
?>

<main class="wrap d-flex">
	<?php include('includes/sidebar.php'); ?>
	<br><br><br>
	<div class="container">
		<div class="catalog__inner">
			<div class="charts userinfo">
				<div class="charts__item">
	          		<h2 class="charts__title"><?php echo $title; ?></h2>
	          		<table class="account-table account-table--currency-main">
	          			<tr class="account-table__header">
	          				<td>Валюта</td>
	          				<td>Нац.</td>
	          				<td>Покупка</td>
	          				<td>Продажа</td>
	          			</tr>
	          			<tbody class="account-table__body">
	          				<?php
	          					$i=0;
	          					foreach ($currency_data as $item) {
	          						echo "<tr class='ripple-effect account-table__row'>";

	          						echo "<td>"."<img class='currency_flag' src='".$currency_flags[$i]."'>" . $item['ccy']."</td>";
	          						echo "<td>".$item['base_ccy']."</td>";
	          						echo "<td>".round($item['buy'], 2)."</td>";
	          						echo "<td>".round($item['sale'], 2)."</td>";
	          						
	          						echo "</tr>";

	          						$i++;
	          					}
	          				?>
	          			</tbody>
	          		</table>

	          		<table class="account-table account-table--currency-more">
	          			<thead class="account-table account-table__header">
	          				<tr>
		          				<td>Валюта</td>
		          				<td>Национальная валюта</td>
		          				<td>Покупка</td>
		          				<td>Продажа</td>
		          				<td>Соотношение</td>
		          			</tr>
	          			</thead>
	          			<tbody class="account-table__body">
	          				
	          			</tbody>
	          		</table>
	          		<form action="#" method="POST" id="getCurrencyForm">
			            <button type="button" id="loadCurrency" class="form__btn ripple-effect">Загрузить больше</button>
			        </form>
	          	</div>
			</div>
		</div>
	</div>
</main>

<?php
include "includes/footer.php";