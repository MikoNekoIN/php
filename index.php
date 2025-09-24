<?php
require_once 'config.php';

// Получаем ID страницы из параметра URL
$page_id = isset($_GET['id']) ? $_GET['id'] : null;

// Если ID не указан, показываем страницу ошибки
if (!$page_id) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f5f5f5;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }
            .error-container {
                background: white;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 500px;
            }
            h1 {
                color: #e74c3c;
                margin-bottom: 20px;
            }
            p {
                color: #666;
                line-height: 1.6;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <h1>Page Not Found</h1>
            <p>The requested page or file was not found. Please check the URL and try again.</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Получаем данные страницы из базы данных
try {
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE page_id = ?");
    $stmt->execute([$page_id]);
    $page = $stmt->fetch();
    
    if (!$page) {
        // Если страница не найдена в базе данных, показываем ошибку
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f5f5f5;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    margin: 0;
                }
                .error-container {
                    background: white;
                    padding: 40px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    text-align: center;
                    max-width: 500px;
                }
                h1 {
                    color: #e74c3c;
                    margin-bottom: 20px;
                }
                p {
                    color: #666;
                    line-height: 1.6;
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>Page Not Found</h1>
                <p>The requested page or file was not found. Please check the URL and try again.</p>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($page['title']); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex,nofollow" />
  <style>
    :root {
      --main-bg: #eaf6fb;
      --main-bg2: #e3f3f7;
      --white: #fff;
      --yellow: #ffc107;
      --yellow-dark: #f9a825;
      --yellow-light: #fff3cd;
      --blue: #1976d2;
      --blue-light: #e3eafc;
      --gray: #666;
      --gray-light: #f7fafc;
      --border: #e0e0e0;
      --radius: 16px;
      --shadow: 0 2px 16px rgba(0,0,0,0.06);
      --shadow-card: 0 2px 12px rgba(0,0,0,0.05);
    }
    html, body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, var(--main-bg) 0%, var(--main-bg2) 100%);
      font-family: 'Segoe UI', Arial, sans-serif;
      color: #222;
      min-height: 100vh;
    }
    body {
      min-width: 320px;
    }
	
    .header {
      max-width: 900px;
      margin: 0 auto;
      padding: 36px 12px 0 12px;
      text-align: center;
    }
    .header-top {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 18px;
      margin-bottom: 8px;
    }
    .header-icon {
      width: 54px;
      height: 54px;
      background: linear-gradient(135deg, #2196f3 60%, #4fc3f7 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(33,150,243,0.08);
    }
    .header-title {
      font-size: 2.1rem;
      font-weight: 600;
      margin-bottom: 0;
      margin-top: 0;
      text-align: left;
    }
    .header-sub {
      color: var(--gray);
      font-size: 1.13rem;
      margin-bottom: 10px;
      margin-top: 0;
      text-align: left;
    }
    .badges {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 0;
      flex-wrap: wrap;
    }
    .badge {
      font-size: 1rem;
      padding: 3px 14px 3px 10px;
      border-radius: 8px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
      border: 1px solid #ffeeba;
      background: var(--yellow-light);
      color: #856404;
      user-select: none;
    }
    .badge.blue {
      background: var(--blue-light);
      color: var(--blue);
      border: 1px solid #b3c6f7;
    }
    .container {
      max-width: 1100px;
      margin: 28px auto 0 auto;
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
      justify-content: center;
      padding: 0 12px;
    }
    .main {
      flex: 2 1 600px;
      background: var(--white);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 32px 32px 24px 32px;
      min-width: 340px;
      margin-bottom: 24px;
      display: flex;
      flex-direction: column;
      gap: 18px;
    }
    .side {
      flex: 1 1 260px;
      display: flex;
      flex-direction: column;
      gap: 18px;
      min-width: 260px;
    }
    .card {
      background: var(--white);
      border-radius: 14px;
      box-shadow: var(--shadow-card);
      padding: 22px 24px 18px 24px;
      margin-bottom: 0;
      border: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .card-title {
      font-size: 1.08rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 8px;
      color: #222;
    }
    .main .card-title {
      color: #222;
      font-size: 1.13rem;
      margin-bottom: 10px;
    }
    .main .desc {
      color: #444;
      font-size: 1.08rem;
      margin-bottom: 0;
      text-align: left;
      line-height: 1.6;
    }
    .main .desc b {
      color: #222;
      font-weight: 600;
    }
    .download-btn {
      display: flex;
      justify-content: center;
      margin: 10px 0 0 0;
    }
    .download-btn button {
      background: linear-gradient(90deg, var(--yellow) 60%, var(--yellow-dark) 100%);
      color: #fff;
      font-size: 1.18rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 15px 44px;
      cursor: pointer;
      box-shadow: 0 4px 16px rgba(251,192,45,0.10);
      transition: background 0.2s, box-shadow 0.2s;
      display: flex;
      align-items: center;
      gap: 10px;
      outline: none;
    }
    .download-btn button:hover {
      background: linear-gradient(90deg, var(--yellow-dark) 60%, var(--yellow) 100%);
      box-shadow: 0 6px 24px rgba(251,192,45,0.18);
    }
    .styled-link-btn {
      background: linear-gradient(90deg, var(--yellow) 60%, var(--yellow-dark) 100%);
      color: #fff;
      font-size: 1.18rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 15px 44px;
      cursor: pointer;
      box-shadow: 0 4px 16px rgba(251,192,45,0.10);
      transition: background 0.2s, box-shadow 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      outline: none;
      text-decoration: none;
      justify-content: center;
    }
    .styled-link-btn:hover {
      background: linear-gradient(90deg, var(--yellow-dark) 60%, var(--yellow) 100%);
      box-shadow: 0 6px 24px rgba(251,192,45,0.18);
      color: #fff;
      text-decoration: none;
    }
    .stats {
      display: flex;
      gap: 16px;
      justify-content: space-between;
      margin-bottom: 0;
      flex-wrap: wrap;
    }
    .stat {
      flex: 1 1 120px;
      background: var(--gray-light);
      border-radius: 10px;
      padding: 18px 0 12px 0;
      text-align: center;
      min-width: 110px;
      border: 1px solid #f0f0f0;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
    }
    .stat .stat-icon {
      margin-bottom: 4px;
      color: var(--yellow-dark);
      display: block;
    }
    .stat .stat-label {
      color: var(--gray);
      font-size: 0.98rem;
      margin-bottom: 2px;
    }
    .stat .stat-value {
      font-size: 1.15rem;
      font-weight: 600;
      margin-top: 2px;
      color: #222;
    }
    .features {
      margin-top: 0;
    }
    .features-title {
      font-weight: 600;
      font-size: 1.08rem;
      margin-bottom: 8px;
      margin-top: 10px;
    }
    .features-list {
      display: flex;
      flex-wrap: wrap;
      gap: 10px 32px;
      margin-top: 6px;
    }
    .feature-item {
      display: flex;
      align-items: center;
      gap: 7px;
      font-size: 1.01rem;
      color: #222;
      min-width: 220px;
      white-space: nowrap;
    }
    .feature-item svg {
      color: var(--yellow-dark);
      min-width: 18px;
    }
    /* Side cards */
    .side .card {
      font-size: 1.01rem;
      margin-bottom: 0;
      min-width: 0;
      border-radius: 14px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-card);
      background: var(--white);
      padding: 18px 18px 14px 18px;
      gap: 8px;
    }
    .side .card-title {
      font-weight: 600;
      font-size: 1.05rem;
      display: flex;
      align-items: center;
      gap: 7px;
      margin-bottom: 8px;
      color: #222;
    }
    .side .info-list {
      margin: 0;
      padding: 0;
      list-style: none;
      font-size: 0.99rem;
      display: flex;
      flex-direction: column;
      gap: 2px;
    }
    .side .info-list li {
      margin-bottom: 0;
      display: flex;
      justify-content: space-between;
      gap: 10px;
      align-items: flex-start;
      line-height: 1.5;
    }
    .side .info-list li span:first-child {
      color: var(--gray);
      min-width: 90px;
      font-weight: 400;
    }
    .side .info-list li span:last-child {
      font-weight: 500;
      color: #222;
      text-align: right;
      flex: 1;
    }
    .side .resources-list {
      margin: 0;
      padding: 0;
      list-style: none;
      font-size: 0.99rem;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .side .resources-list li {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--blue);
      font-weight: 500;
      cursor: pointer;
      transition: color 0.15s;
      padding-left: 0;
      line-height: 1.5;
    }
    .side .resources-list li:hover {
      color: #2196f3;
      text-decoration: underline;
    }
    .side .resources-list li svg {
      color: var(--yellow-dark);
      min-width: 16px;
    }
    /* Footer */
    .footer {
      text-align: center;
      color: #666;
      font-size: 0.98rem;
      margin: 38px 0 18px 0;
    }
    .footer small {
      display: block;
      margin-top: 6px;
      color: #888;
      font-size: 0.95rem;
    }
    @media (max-width: 1100px) {
      .container {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
      }
      .main, .side {
        width: 100%;
        min-width: unset;
      }
      .side {
        flex-direction: row;
        gap: 18px;
        margin-bottom: 24px;
      }
      .side .card {
        min-width: 220px;
        flex: 1 1 220px;
      }
    }
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
      }
      .main, .side {
        width: 100%;
        min-width: unset;
      }
      .side {
        flex-direction: column;
        gap: 18px;
      }
      .side .card {
        min-width: unset;
        width: 100%;
      }
    }
    @media (max-width: 700px) {
      .header {
        padding-top: 18px;
      }
      .header-title {
        font-size: 1.3rem;
      }
      .main {
        padding: 18px 8px 14px 8px;
      }
      .side .card {
        padding: 14px 8px 10px 8px;
      }
      .stats {
        flex-direction: column;
        gap: 10px;
      }
      .features-list {
        flex-direction: column;
        gap: 8px;
      }
      .container {
        padding: 0 2px;
      }
    }
    @media (max-width: 480px) {
      .header-title {
        font-size: 1.05rem;
      }
      .main, .side .card {
        padding: 10px 2px 8px 2px;
      }
      .footer {
        font-size: 0.92rem;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="header-top">
      <div class="header-icon">
        <svg width="36" height="36" fill="none" viewBox="0 0 36 36">
          <rect width="36" height="36" rx="12" fill="#fff" opacity="0.2"/>
          <path d="M18 6l10 4v6c0 7-4.5 13-10 14-5.5-1-10-7-10-14V10l10-4z" fill="#fff" stroke="#2196f3" stroke-width="2"/>
          <circle cx="18" cy="22" r="1.5" fill="#ffc107"/>
          <rect x="17" y="13" width="2" height="6" rx="1" fill="#ffc107"/>
        </svg>
      </div>
      <div style="text-align:left;">
        <h1 class="header-title"><?php echo htmlspecialchars($page['title']); ?></h1>
        <div class="header-sub"><?php echo htmlspecialchars($page['description']); ?></div>
      </div>
    </div>
    <div class="badges">
      <span class="badge">
        <svg width="18" height="18" fill="none" viewBox="0 0 18 18"><circle cx="9" cy="9" r="8" stroke="#ffc107" stroke-width="1.5"/><path d="M6.5 9.5l2 2 3-3" stroke="#ffc107" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Будьте осторожны
      </span>
      <span class="badge blue">
        <svg width="18" height="18" fill="none" viewBox="0 0 18 18"><circle cx="9" cy="9" r="8" stroke="#1976d2" stroke-width="1.5"/><path d="M9 6v4" stroke="#1976d2" stroke-width="1.5" stroke-linecap="round"/><circle cx="9" cy="12" r="1" fill="#1976d2"/></svg>
        Ваша безопасность
      </span>
    </div>
  </div>
  <div class="container">
    <div class="main">
      <div class="card-title">
        <svg width="22" height="22" fill="none" viewBox="0 0 22 22"><rect x="3" y="5" width="16" height="12" rx="2" fill="#ffc107" opacity="0.15"/><rect x="3" y="5" width="16" height="12" rx="2" stroke="#ffc107" stroke-width="1.5"/></svg>
        Важная информация перед переходом
      </div>
      <div class="desc">
        Вы переходите по внешней ссылке. Мы не контролируем содержимое сторонних сайтов и не несем ответственности за размещённые там файлы.<br><br>
        <b>Проверьте скачиваемые файлы антивирусом</b> перед открытием или запуском. Не вводите личные данные на подозрительных ресурсах.<br><br>
        Ваша осведомлённость — ключ к безопасности в интернете!
      </div>
      <div class="download-btn">
        <a class="styled-link-btn" href="<?php echo htmlspecialchars($page['download_link']); ?>" target="_blank" rel="noopener">
          <svg width="22" height="22" fill="none" viewBox="0 0 22 22"><rect x="2" y="2" width="18" height="18" rx="4" fill="#fff" opacity="0.2"/><path d="M11 5v8m0 0l-3-3m3 3l3-3" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="6" y="15" width="10" height="2" rx="1" fill="#fff" opacity="0.7"/></svg>
          Перейти по ссылке
        </a>
      </div>
      <div class="stats">
        <div class="stat">
          <span class="stat-icon">
            <svg width="28" height="28" fill="none" viewBox="0 0 28 28"><circle cx="14" cy="14" r="12" stroke="#ffc107" stroke-width="2"/><path d="M10 16l4 4 4-4" stroke="#ffc107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <div class="stat-label">Пользователей предупреждено</div>
          <div class="stat-value">100 000+</div>
        </div>
        <div class="stat">
          <span class="stat-icon">
            <svg width="28" height="28" fill="none" viewBox="0 0 28 28"><circle cx="14" cy="14" r="12" stroke="#ffc107" stroke-width="2"/><path d="M14 8v6l4 2" stroke="#ffc107" stroke-width="2" stroke-linecap="round"/></svg>
          </span>
          <div class="stat-label">Рейтинг доверия</div>
          <div class="stat-value">4.9/5</div>
        </div>
        <div class="stat">
          <span class="stat-icon">
            <svg width="28" height="28" fill="none" viewBox="0 0 28 28"><circle cx="14" cy="14" r="12" stroke="#ffc107" stroke-width="2"/><path d="M10 14h8" stroke="#ffc107" stroke-width="2" stroke-linecap="round"/></svg>
          </span>
          <div class="stat-label">Советов по безопасности</div>
          <div class="stat-value">Более 500</div>
        </div>
        <div class="stat">
          <span class="stat-icon">
            <svg width="28" height="28" fill="none" viewBox="0 0 28 28"><circle cx="14" cy="14" r="12" stroke="#ffc107" stroke-width="2"/><rect x="11" y="8" width="6" height="2" rx="1" fill="#ffc107" opacity="0.2"/><rect x="11" y="18" width="6" height="2" rx="1" fill="#ffc107" opacity="0.2"/></svg>
          </span>
          <div class="stat-label">Обновлено</div>
          <div class="stat-value">Сегодня</div>
        </div>
      </div>
      <div class="features">
        <div class="features-title">Рекомендации</div>
        <div class="features-list">
          <div class="feature-item">
            <svg width="18" height="18" fill="none" viewBox="0 0 18 18"><circle cx="9" cy="9" r="8" stroke="#ffc107" stroke-width="1.5"/><path d="M6.5 9.5l2 2 3-3" stroke="#ffc107" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Проверяйте файлы антивирусом
          </div>
          <div class="feature-item">
            <svg width="18" height="18" fill="none" viewBox="0 0 18 18"><circle cx="9" cy="9" r="8" stroke="#ffc107" stroke-width="1.5"/><path d="M6.5 9.5l2 2 3-3" stroke="#ffc107" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            О всех проблемах сообщайте нам
          </div>
        </div>
      </div>
    </div>
    <div class="side">
      <div class="card">
        <div class="card-title">
          <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8" stroke="#ffc107" stroke-width="1.5"/><rect x="7" y="8" width="6" height="2" rx="1" fill="#ffc107" opacity="0.2"/></svg>
          Прочитать
        </div>
        <ul class="info-list">
          <li><span>Проверьте:</span> <span>Совместимость</span></li>
          <li><span>ОС:</span> <span><?php echo htmlspecialchars($page['file_os']); ?></span></li>
          <li><span>Память:</span> <span><?php echo htmlspecialchars($page['file_memory']); ?></span></li>
          <li><span>Скорость загрузки:</span> <span><?php echo htmlspecialchars($page['download_speed']); ?></span></li>
        </ul>
      </div>
      <div class="card">
        <div class="card-title">
          <svg width="20" height="20" fill="none" viewBox="0 0 20 20"><rect x="3" y="4" width="14" height="12" rx="2" stroke="#ffc107" stroke-width="1.2"/><rect x="6" y="7" width="8" height="2" rx="1" fill="#ffc107" opacity="0.2"/></svg>
          О файле
        </div>
        <ul class="info-list">
          <li><span>Источник:</span> <span><?php echo htmlspecialchars($page['file_source']); ?></span></li>
          <li><span>Контроль:</span> <span><?php echo htmlspecialchars($page['file_control']); ?></span></li>
          <li><span>Пароль:</span> <span><?php echo htmlspecialchars($page['file_password']); ?></span></li>
          <li><span>Распаковка:</span> <span><?php echo htmlspecialchars($page['file_extract']); ?></span></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer">
    © 2025. Всегда проверяйте файлы перед запуском.<br>
    <small>Мы не поддерживаем пиратство и не размещаем нелегальный контент на сайте, все файлы добавляют пользователи ресурса на сторонние сервера. Если вы хотите быть автором и добавлять свои новости, пишите нам через обратную связь. Поддерживайте разработчиков!</small>
  </div>
</body>
</html>