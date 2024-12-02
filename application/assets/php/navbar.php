<div class="background"></div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: relative; z-index: 1;">
    <div class="container">
        <a class="navbar-brand" href="#">Project-M</a>

        <!-- Кнопка гамбургера для мобильных устройств -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Вкладки по центру -->
            <div class="mx-auto">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/main">
                            <i class="fas fa-home"></i> <?php echo htmlspecialchars($data['translations']['home'])?> <!-- Иконка домика -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/album">
                            <i class="fas fa-images"></i> <?php echo htmlspecialchars($data['translations']['album'])?> <!-- Иконка альбома -->
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Кнопки справа -->
            <div class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="/profile" id="userProfileLink" aria-expanded="false">
                        <img src="<?php echo $_SESSION['picture'] ?>" alt="User Avatar" class="user-avatar" id="userAvatar" />
                    </a>
                    <a href="/logout" class="btn btn-danger mt-2"><?php echo htmlspecialchars($data['translations']['logout'])?></a>
                <?php else: ?>
                    <a class="nav-link" href="#" id="signInBtn"><?php echo htmlspecialchars($data['translations']['signin'])?></a>
                    <div class="dropdown-login" id="loginDropdown" style="display: none;">
                        <div class="dropdown-login-content">
                            <form id="loginForm" action="/login" method="post">
                                <input type="hidden" name="redirect_to" value="dropdown">
                                <label for="username"><?php echo htmlspecialchars($data['translations']['username'])?>:</label>
                                <div class="input-wrapper">
                                    <input type="text" name="username" id="username" placeholder="<?php echo htmlspecialchars($data['translations']['typename'])?>">
                                    <span class="error-message" id="username-error"></span>
                                </div>
                                <label for="password"><?php echo htmlspecialchars($data['translations']['password'])?>:</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password" id="password" placeholder="<?php echo htmlspecialchars($data['translations']['typepass'])?>">
                                    <span class="error-message" id="password-error"></span>
                                </div>

                                <div class="checkbox-container">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox" class="checkbox-container"><?php echo htmlspecialchars($data['translations']['rememberme'])?></label>
                                </div>

                                <button type="submit"><?php echo htmlspecialchars($data['translations']['sumbit'])?></button>
                            </form>
                        </div>
                    </div>
                    <a class="nav-link" href="/register"><?php echo htmlspecialchars($data['translations']['signup'])?></a>
                <?php endif; ?>
                <!-- Выпадающий список выбора языка в основном меню -->
                <select class="form-select form-select-sm" id="languageSelect" aria-label="Language select" onchange="changeLanguage(this.value)">
                    <option value="en" <?php echo (isset($_SESSION['language']) && $_SESSION['language'] === 'en') ? 'selected' : ''; ?>>English</option>
                    <option value="ru" <?php echo (isset($_SESSION['language']) && $_SESSION['language'] === 'ru') ? 'selected' : ''; ?>>Русский</option>
                </select>
            </div>
        </div>
    </div>
</nav>

<!-- Выезжающее меню для мобильных устройств -->
<div class="offcanvas offcanvas-end offcanvas-fullscreen" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel" style="background-color: white;">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between text-center">
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="mb-3 d-flex flex-column align-items-center">
                    <a href="/profile">
                        <img src="<?php echo $_SESSION['picture'] ?>" alt="User Avatar" class="user-avatar" id="userAvatar" style="width: 80px; height: 80px; border-radius: 50%;">
                    </a>
                    <a href="/logout" class="btn btn-danger mt-3"><?php echo htmlspecialchars($data['translations']['logout'])?></a>
                </div>
            <?php else: ?>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a class="nav-link" href="/login"><?php echo htmlspecialchars($data['translations']['signin'])?></a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link" href="/register"><?php echo htmlspecialchars($data['translations']['signup'])?></a>
                    </li>
                </ul>
            <?php endif; ?>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a class="nav-link" href="/main">
                            <i class="fas fa-home"></i> <?php echo htmlspecialchars($data['translations']['home'])?>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link" href="/album">
                            <i class="fas fa-images"></i> <?php echo htmlspecialchars($data['translations']['album'])?>
                        </a>
                    </li>
                </ul>
        </div>

        <!-- Комбобокс выбора языка внизу -->
        <div class="mt-3">
          <!-- Выпадающий список выбора языка в мобильном меню -->
          <select class="form-select form-select-sm" id="mobileLanguageSelect" aria-label="Language select" onchange="changeLanguage(this.value)">
              <option value="en" <?php echo (isset($_SESSION['language']) && $_SESSION['language'] === 'en') ? 'selected' : ''; ?>>English</option>
              <option value="ru" <?php echo (isset($_SESSION['language']) && $_SESSION['language'] === 'ru') ? 'selected' : ''; ?>>Русский</option>
          </select>
        </div>
    </div>
</div>

<!-- Подключите Bootstrap JS и CSS внизу вашей страницы -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('languageSelect').addEventListener('change', function () {
        const selectedLanguage = this.value;
        fetch('/language/set', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ language: selectedLanguage })
        }).then(() => {
          location.reload();
        });
    });
</script>
