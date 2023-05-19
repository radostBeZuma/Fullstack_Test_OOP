const formInstDelete = document.querySelectorAll('.js-delete-form');

if (formInstDelete) {
    function limitNumCharacters(title) {
        return title = title.slice(0, 30)+'...';
    }

    formInstDelete.forEach(function(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const newsTitle = form.querySelector('.js-news-title');

            let title = limitNumCharacters(newsTitle.value);
            let text = 'Вы действительно хотите удалить новость: \"' + title + '\"?';

            if (confirm(text)) {
                form.submit();
            }
        });
    });
}
