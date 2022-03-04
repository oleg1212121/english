;

let body = document.querySelector('tbody');
body.addEventListener('click', function (e) {
    let target = e.target;
    let wordId = target.closest('.word-row').dataset.index;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let headers = {
        "Content-type": "application/json; charset=UTF-8",
        'X-CSRF-TOKEN': token
    }

    if (target.classList.contains("known")) {
        changeWordStatus(wordId, 10);
    }
    if (target.classList.contains("improve")) {
        changeWordStatus(wordId, 1);
    }
    if (target.classList.contains("decrease")) {
        changeWordStatus(wordId, -1);
    }
    if (target.classList.contains("removing")) {
        deleteWord(wordId);
    }
    if (target.classList.contains("translation-add")) {
        alert('hiho');
    }

    if (target.classList.contains("translation-cross")) {
        let translation = target.closest('.word-wrapper');
        let trId = translation.dataset.index;
        let url = '/api/translation-excluding/' + wordId + '/' + trId;
        fetch(url, {
            method: 'DELETE',
            headers: headers
        }).then((response) => {
            translation.remove()
        })
    }


    function changeWordStatus(index, status) {
        let url = '/api/learning/' + index;
        fetch(url, {
            method: 'PATCH',
            body: JSON.stringify({
                status: status
            }),
            headers: headers
        }).then((response) => {
            rowRemove(target);
        })
    }

    function deleteWord(index) {
        let url = '/api/removing/' + index;
        fetch(url, {
            method: 'DELETE',
            headers: headers
        }).then((response) => {
            rowRemove(target);
        })
    }

    function rowRemove(target) {
        target.closest('tr').remove()
    }

});
