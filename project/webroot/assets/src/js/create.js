const formInst = document.getElementById('addForm');

if (formInst) {
    const formField = {
        title: document.getElementById('InputTitle'),
        anounce: document.getElementById('TextareaAnounce'),
        fileAnounce: document.getElementById('FileAnounceImg'),
        detail: document.getElementById('TextareaDetail'),
        fileDetail: document.getElementById('FileDetailImg'),
    }

    let errorCount;

    formInst.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append( 'title', formField.title.value);
        data.append('anounce', formField.anounce.value);
        data.append('fileAnounce', formField.fileAnounce.files[0]);
        data.append('detail', formField.detail.value);
        data.append('fileDetail', formField.fileDetail.files[0]);

        sendNReceiveJson('/create/', 'POST', data);
    });

    function sendNReceiveJson(url, method, data) {
        fetch(url,
            {
                method: method,
                body: data
            })
            .then(function(res)
            {return res.json();})
            .then(function(data)
            {
                if(!data.ok) {
                    getError(document.querySelector('.all-error'), data.fields, errorCount);
                }
                else {
                    okMethod(data.id);
                }
            })
    }

    function getError(errTool, fields, err) {
        const allError = errTool;

        if (err > 0) {
            allError.innerHTML = '';
            err = 0;
        }

        for (let key of Object.keys(fields)) {
            allError.innerHTML += '<p>' + fields[key] + ' ' + key + '</p>';
        }

        err++;
    }

    function okMethod(id) {
        $newPage = '/' + id + '/';
        window.location.replace($newPage);
    }
}
