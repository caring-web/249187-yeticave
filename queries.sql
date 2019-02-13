-- Добавляет существующий список категорий
INSERT INTO categories(category)
VALUES
  ('Доски и лыжи'),
  ('Крепления'),
  ('Ботинки'),
  ('Одежда'),
  ('Инструменты'),
  ('Разное');

INSERT INTO users(email_user,
                  name_user,
                  password_user,
                  avatar_user,
                  contacts_user)
VALUES
  ('sar.obl@bk.ru',
    'Vladimir',
    'dumpl2011',
    NULL,
    'г.Пенза, ул.Свободы, д.18'),
  ('jp20000@mail.ru',
    'Den',
    'qwerty48',
    NULL,
    'г.Новосибирск, ул.Садовая, д.188, кв. 25'),
  ('AntonPirogkov@gmail.com',
    'Tony',
    'ghjdl4411',
     NULL,
     'г.Москва, ул.Мысникова, д.1, кв. 10'),
  ('PobedaVi@yandex.ru',
    'Viktoriy',
    'Heyikl1',
    NULL,
    'г.Омск, ул.Ленина, д.104, кв.119'),
  ('elena_kapusta@mail.ru',
    'Elena',
    'neilh11d',
    NULL,
    'г.Тверь, ул.Яблоневая, д.1, кв.3');

INSERT INTO lots(name,
                  category_id,
                  date_start,
                  description,
                  img_lot,
                  start_price,
                  bet_step,
                  user_id,
                  winner_id)
VALUES
  ('2014 Rossignol District Snowboard',
    1,
    '2019-02-01 13:15:45',
    'Сноуборд',
    'img/lot-1.jpg',
    10999,
    1000,
    1,
    1),
  ('DC Ply Mens 2016/2017 Snowboard',
    1,
    '2019-01-15 08:25:10',
    'Доска',
    'img/lot-2.jpg',
    159999,
    1500,
    2,
    2),
  ('Крепления Union Contact Pro 2015 года размер L/XL',
    2,
    '2019-01-13 15:40:01',
    'Крепления',
    'img/lot-3.jpg',
    8000,
    400,
    3,
    3),
  ('Ботинки для сноуборда DC Mutiny Charocal',
    3,
    '2019-01-29 07:35:18',
    'Ботинки',
    'img/lot-4.jpg',
    10999,
    500,
    3,
    5),
  ('Куртка для сноуборда DC Mutiny Charocal',
    4,
    '2019-01-10 20:20:05',
    'Куртка',
    'img/lot-5.jpg',
    7500,
    500,
    1,
    2),
  ('Маска Oakley Canopy',
    6,
    '2019-01-19 16:55:12',
    'Маска',
    'img/lot-6.jpg',
    5400,
    200,
    5,
    6);

INSERT INTO bets(bet_amount, user_id, lot_id)
VALUES
  (10499, 5, 4),
  (7000, 2, 5),
  (5200, 6, 6);

--Получает все категории
SELECT *
FROM categories;

--Получает самые новые, открытые лоты. Каждый лот включает название,
--стартовую цену, ссылку на изображение, цену, название категории
SELECT lots.*, categories.category
FROM lots
JOIN categories
ON lots.category_id = categories.id
WHERE date_end < CURDATE()
ORDER BY date_end DESC;

--Показывает лот по его id. Получает также название категории,
--к которой принадлежит лот
SELECT lots.*, categories.category
FROM lots
JOIN categories
ON lots.category_id = categories.id
WHERE lots.id = 1;

--Обновляет название лота по его идентификатору
UPDATE lots
SET name = '2019 Rossignol District Snowboard'
WHERE lots.id = 1;

--Получает список самых свежих ставок для лота по его идентификатору
SELECT *
FROM bets
WHERE lot_id = 3;
ORDER BY date_bet DESC;
