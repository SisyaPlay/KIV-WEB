async function loadNews() {
    const response = await fetch('/main/get_articles'); // Новый URL для MVC
    const data = await response.json();

    const articleContainer = document.getElementById('article-list');
    articleContainer.innerHTML = ''; // Очищаем контейнер перед добавлением новых данных

    // Создаем ссылки на статьи
    data.forEach(article => {
        const articleItem = document.createElement('div');
        articleItem.className = 'article-item';
        articleItem.innerHTML = `<a href="articles_detail.php?id=${article.id}">${article.title}</a>`;
        articleContainer.appendChild(articleItem);
    });
}

// Загрузка новостей при загрузке страницы
document.addEventListener('DOMContentLoaded', loadNews);
