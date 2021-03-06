INSERT INTO categories (category, class_category) VALUES
  ('Доски и лыжи', 'promo__item--boards'),
  ('Крепления', 'promo__item--attachment'),
  ('Ботинки', 'promo__item--boots'),
  ('Одежда', 'promo__item--clothing'),
  ('Инструменты', 'promo__item--tools'),
  ('Разное', 'promo__item--other');

INSERT INTO users (name_user,
                  password_user,
                  email_user,
                  registration_date,
                  avatar_user,
                  contacts_user)
VALUES
  ('Vladimir',
    '$2y$10$mCqJr1Hit7Kna9GwuXEyOODCq4/CL2BzAIoR/LAKzrsKyF6rpgm5e',
    'sar.obl@bk.ru',
    '2018-12-28 15:05:33',
    NULL,
    '+79001234567'),
  ('Den',
    '$2y$10$G6/s7tweKPnhGQdl3BjXKOGmYAN6JA/DfuMJXIie0Rv1y/n5aonae',
    'jp20000@mail.ru',
    '2019-01-02 10:42:17',
    NULL,
    '+79009876543'),
  ('Tony',
    '$2y$10$Q/mpAeX6uoqRkTRYnxNHg.jhgwFUkv39ME35vp2Wt3O/hhkvuphUe',
    'AntonPirogkov@gmail.com',
    '2019-01-15 23:18:02',
    'user-3-avatar.jpg',
    '+79025432198');

INSERT INTO lots (name,
                description,
                img_lot,
                start_price,
                date_start,
                date_end,
                bet_step,
                category_id,
                user_id)
  VALUES
  ('2014 Rossignol District Snowboard',
    'Сноуборд DISTRICT AMPTEK от известного французского производителя ROSSIGNOL, разработанный специально для начинающих фрирайдеров. Эта доска отлично подойдёт как для обычного склона, так и для парка, а также для обучения. В доступном по цене сноуборде DISTRICT AMPTEK применены современные технологии, которые удачно сочетаются, обеспечивая при этом отличные рабочие характеристики и комфорт. Он оптимален для тех, кто хочет быстро повысить свой уровень техники и мастерства. Классическая твин-тип форма позволяет кататься в разных стойках. За устойчивость и стабильность отвечает стандартный прогиб, он гарантирует жесткую хватку кантов. Высокие рокеры Amptek Auto-Turn обеспечивают легкость управления доской и четкое вхождение в повороты.',
    'lot-1.jpg',
    10999,
    '2019-02-03 19:50:28',
    '2019-02-21',
    500,
    1,
    1),
  ('DC Ply Mens 2016/2017 Snowboard',
    'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    'lot-2.jpg',
    159999,
    '2019-02-04 14:17:01',
    '2019-02-22',
    1000,
    1,
    3),
  ('Крепления Union Contact Pro 2015 года размер L/XL',
    'Невероятно легкие универсальные крепления весом всего 720 грамм готовы порадовать прогрессирующих райдеров, практикующих как трассовое катание, так и взрывные спуски в паудере. Легкая нейлоновая база в сочетании с очень прочным хилкапом, выполненным из экструдированного алюминия, выдержит серьезные нагрузки, а бакли, выполненные из магния не только заметно снижают вес, но и имеют плавный механизм. Система стрепов 3D Connect обеспечивает равномерное давление на верхнюю часть ноги, что несомненно добавляет комфорта как во время выполнения трюков, так и во время катания в глубоком снегу.',
    'lot-3.jpg',
    8000,
    '2019-02-05 22:44:55',
    '2019-02-23',
    750,
    2,
    1),
  ('Ботинки для сноуборда DC Mutiny Charcoal',
    'Эти ботинки созданы для фристайла и для того, чтобы на любом споте Вы чувствовали себя как дома в уютных тапочках, в которых Вы будете также прекрасно чувствовать свою доску, как ворсинки на любимом коврике около дивана. Каучуковая стелька Impact S погасит нежелательные вибрации и смягчит приземления, внутренник White Liner с запоминающим форму ноги наполением и фиксирующим верхним стрепом добавит эргономики в посадке, а традиционная шнуровка с блокирующими верхними крючками поможет идеально подогнать ботинок по ноге, тонко фиксируя натяжение шнурков.',
    'lot-4.jpg',
    10999,
    '2019-02-06 17:08:43',
    '2019-02-24',
    777,
    3,
    2),
  ('Куртка для сноуборда DC Mutiny Charcoal',
    'Яркая и стильная в своей форме, она наделена отличными технологическими характеристиками, которые помогут Вам оставаться в тепле и сухости даже в самый лютый снежный день. Мембранный материал 10К дополнен водостойкой пропиткой DWR, что поможет создать надежный барьер против влаги. Критические швы проклеены, присутствует утеплитель с показателями 60 г (тело) и 40 г (капюшон и рукава), предусмотрены эластичные манжеты с отверстием для большого пальца и вентиляционные отверстия.',
    'lot-5.jpg',
    7500,
    '2019-02-07 09:34:27',
    '2019-02-25',
    500,
    4,
    3),
  ('Маска Oakley Canopy',
    'Маска с очень большой линзой, которая обеспечивает лучший обзор среди всех масок в линейке. Картинка будет четкой, контрастной и глубокой благодаря технологии XYZ OPTICS, которая позволяет соблюдать оптическую корректность по вертикали, горизонтали и в глубину. Двойная конструкция линзы и покрытие анти-фог препятствуют запотеванию. Фирменная система крепления стрепа обеспечивает равномерное распределение давления маски на лицо - маска удобно сидит на лице и не создает избыточного давления на носовую область.',
    'lot-6.jpg',
    5400,
    '2019-02-08 13:21:15',
    '2019-02-26',
    200,
    6,
    1);

INSERT INTO bets (date_bet, bet_amount, user_id, lot_id)
VALUES
  ('2019-02-08 10:12:32', 8750, 3, 3),
  ('2019-02-09 22:41:15', 11499, 2, 1),
  ('2019-02-09 23:01:44', 9500, 2, 3);


-- Получает все категории
SELECT *
  FROM categories;

-- Получает самые новые, открытые лоты. Каждый лот включает название, стартовую цену, ссылку на изображение, цену, название категории
SELECT id, name, start_price, img_lot, COUNT(b.bet_id) AS bets_count, COALESCE(MAX(b.bet_amount),start_price) AS price, c.category AS category_name
  FROM lots l
  JOIN categories c ON l.category_id = c.id
  LEFT JOIN bets b ON l.id = b.lot_id
  WHERE l.date_end > NOW()
  GROUP BY l.id
  ORDER BY l.date_start DESC;

-- Показывает лот по его id. Получает также название категории, к которой принадлежит лот, и текущую цену
SELECT l.*, categories.category AS category_name, COALESCE((SELECT MAX(bet_amount) FROM bets WHERE lot_id = 3), start_price) AS price
  FROM lots l
  JOIN categories ON l.category_id = c.id
  WHERE l.id = 3;

-- Обновляет название лота по его идентификатору
UPDATE lots
  SET name = '2019 Rossignol District Snowboard'
  WHERE lots.id = 1;

-- Получает список самых свежих ставок для лота по его идентификатору
SELECT b.date_bet, b.bet_amount, b.user_id, u.name_user AS user
  FROM bets b
  JOIN users u ON u.id = b.user_id
  WHERE b.lot_id = 3
  ORDER BY b.date_bet DESC;
