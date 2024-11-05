async function loadNews() {
    const response = await fetch('vendor/get_articles.php');
    const articleList = await response.json();

    const articleContainer = document.getElementById('article-list');
    articleContainer.innerHTML = '';  // Очищаем контейнер перед добавлением новых данных

    // Проходим по каждому элементу и создаем ссылку
    articleList.forEach(articles => {
        const articleItem = document.createElement('div');
        articleItem.className = 'article-item';
        articleItem.innerHTML = `<a href="articles_detail.php?id=${articles.id}">${articles.title}</a>`;
        articleContainer.appendChild(articleItem);
    });
}

// Загрузка новостей при загрузке страницы
document.addEventListener('DOMContentLoaded', loadNews);
