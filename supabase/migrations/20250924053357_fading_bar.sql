-- SQL файл для создания базы данных CMS
-- Версия MySQL: 5.7+
-- Кодировка: UTF-8

CREATE DATABASE IF NOT EXISTS `cms_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `cms_database`;

-- Создание таблицы страниц
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` varchar(50) NOT NULL UNIQUE,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(50) NOT NULL,
  `file_os` varchar(100) NOT NULL DEFAULT 'Windows',
  `file_memory` varchar(50) NOT NULL DEFAULT '2 GB',
  `download_speed` varchar(50) NOT NULL DEFAULT '1 Мегабайт',
  `download_link` text NOT NULL,
  `file_source` varchar(255) NOT NULL DEFAULT 'Файловый сервер',
  `file_control` varchar(255) NOT NULL DEFAULT 'ClamAV',
  `file_password` varchar(255) NOT NULL DEFAULT 'Установлен',
  `file_extract` varchar(255) NOT NULL DEFAULT 'WinRAR / 7zip',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Вставка примеров данных
INSERT INTO `pages` (`page_id`, `title`, `description`, `file_name`, `file_size`, `file_os`, `file_memory`, `download_speed`, `download_link`, `file_source`, `file_control`, `file_password`, `file_extract`) VALUES
('p1', 'Внимание: вы покидаете наш сайт', 'Пожалуйста, прочитайте важные рекомендации ниже', 'AIMP 5.40.2694', '15.2 MB', 'Windows', '2 GB', '1 Мегабайт', 'https://example.com/download1', 'Файловый сервер', 'ClamAV', 'Установлен', 'WinRAR / 7zip'),
('p2', 'Скачивание программы', 'Внимание при скачивании файлов', 'VLC Media Player', '42.1 MB', 'Windows', '1 GB', '2 Мегабайта', 'https://example.com/download2', 'Файловый сервер', 'ClamAV', 'Не установлен', 'WinRAR / 7zip'),
('p3', 'Загрузка утилиты', 'Проверьте совместимость перед установкой', 'CCleaner Professional', '28.5 MB', 'Windows', '512 MB', '1.5 Мегабайта', 'https://example.com/download3', 'Файловый сервер', 'ClamAV', 'Установлен', 'WinRAR / 7zip');

-- Создание индексов для оптимизации
CREATE INDEX idx_page_id ON pages(page_id);
CREATE INDEX idx_created_at ON pages(created_at);

-- Комментарии к таблице
ALTER TABLE `pages` COMMENT = 'Таблица для хранения информации о страницах CMS';