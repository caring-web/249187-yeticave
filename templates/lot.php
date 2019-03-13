<section class="lot-item container">
    <h2><?=htmlspecialchars($lot_id['name']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?='img/' . $lot_id['img_lot']; ?>" width="730" height="548" alt="Изображение лота">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot_id['category_name']; ?></span></p>
            <p class="lot-item__description"><?=htmlspecialchars($lot_id['description']); ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?=get_lot_time($lot_id['date_end']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=formatPrice($lot_id['start_price']); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=formatPrice($lot_id['start_price'] + $lot_id['bet_step']); ?> </span>
                    </div>
                </div>
                <?php if ($show_add_bet): ?>
                <form class="lot-item__form" action="lot.php?id=<?=$lot_id['id']; ?>" method="post">
                    <p class="lot-item__form-item form__item<?=!isset($errors['cost']) ? '' : ' form__item--invalid'; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=$lot_id['start_price'] + $lot_id['bet_step']; ?>" required<?=empty($data['cost']) ? '' : ' value="' . $data['cost'] . '"'; ?>>
                        <span class="form__error"><?=!isset($errors['cost']) ? '' : $errors['cost']; ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
                <?php endif; ?>
            </div>
            <div class="history">
                <h3>История ставок (<span><?=count($bets); ?></span>)</h3>
                <?php if (!empty($bets)): ?>
                <table class="history__list">
                    <?php foreach ($bets as $bet): ?>
                    <tr class="history__item">
                        <td class="history__name"><?=htmlspecialchars($bet['user']); ?></td>
                        <td class="history__price"><?=formatPrice($bet['bet_amount']); ?></td>
                        <td class="history__time"><?=get_bet_time($bet['date_bet']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
