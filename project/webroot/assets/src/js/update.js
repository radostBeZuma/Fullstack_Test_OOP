const updateModal = document.getElementById('updateModal');
const updateForm = document.getElementById('updateForm');

// передача id в форму через событие bootstrap`a

if (updateModal) {
    updateModal.addEventListener('show.bs.modal', event => {

        const button = event.relatedTarget;

        const getId = button.getAttribute('data-bs-id');

        const idField = document.getElementById('InputIdUpdate');

        idField.value = getId;
    })
}

if (updateForm) {
    const updateFields = {
        title: {
            inst: document.getElementById('InputTitleUpdate'),
            type: 'input',
        },
        anounce: {
            inst: document.getElementById('TextareaAnounceUpdate'),
            type: 'input',
        },
        fileAnounce: {
            inst: document.getElementById('FileAnounceImgUpdate'),
            type: 'file',
        },
        detail: {
            inst: document.getElementById('TextareaDetailUpdate'),
            type: 'input',
        },
        fileDetail: {
            inst: document.getElementById('FileDetailImgUpdate'),
            type: 'file',
        },
    };

    let errCount = 0;

    let errorField = document.querySelector('.news-update-modal__all-error');

    const validFields = (fields) => {
        let data = new FormData();

        for (const [key, valueObj] of Object.entries(fields)) {
            let type = valueObj.type;
            let inst = valueObj.inst;

            if (type === 'input') {
                if(inst.value.length !== 0) {
                    data.append(key, inst.value);
                }
            }
            else if (type === 'file') {
                if(inst.files.length !== 0) {
                    data.append(key, inst.files[0]);
                }
            }
        }

        return data;
    }

    const sendNReceiveJson = (url, method, data, errField, errCounter, id) => {
        fetch(url, {method: method, body: data })
            .then(function(res) {return res.json();})
            .then(function(data)
            {
                if(!data.ok) {
                    getError(errField, data.fields, errCounter);
                }
                else {
                    okMethod(id);
                }
            })
    }

    const getError = (errField, fields, errCounter) => {
        errCounter++;

        if (errCounter > 0) {
            errField.innerHTML = '';
            errCounter = 0;
        }

        for (let key of Object.keys(fields)) {
            if (fields[key] !== 'all') {
                errField.innerHTML += '<p>' + fields[key] +  '</p>';
            } else {
                errField.innerHTML += '<p>' + fields[key] + ' ' + key + '</p>';
            }
        }
    }

    const okMethod = (id) => {
        let $newPage = '/' + id + '/';
        window.location.replace($newPage);
    }

    const handlerSubmitFunction = (e, fields) => {
        e.preventDefault();

        const id = document.getElementById('InputIdUpdate').value;
        const data = validFields(fields);

        if(!data.entries().next().done) {
            let url = '/update/' + id + '/';

            sendNReceiveJson(url, 'POST', data, errorField, errCount, id);
        } else {
            let fields = {
                all: 'Все поля формы являются пустыми, заполните ее',
            };

            getError(errorField, fields, errCount);
        }
    }

    updateForm.addEventListener('submit', (e) => {
        handlerSubmitFunction(e, updateFields);
    });

}

