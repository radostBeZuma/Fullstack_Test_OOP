const formInstDelete = document.querySelectorAll('.js-delete-form');

if (formInstDelete) {
    const truncateString = (s, w) => s.length > w ? s.slice(0, w).trim() + "..." : s;

    formInstDelete.forEach(function(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const newsTitle = form.querySelector('.js-news-title');

            let title = truncateString(newsTitle.value, 30);
            let text = 'Вы действительно хотите удалить новость: \"' + title + '\"?';

            if (confirm(text)) {
                form.submit();
            }
        });
    });
}
