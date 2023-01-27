function sendData(url, data, res) {
    $.ajax({
        url: url,
        data: data,
        dataType: 'json',
        type: 'POST',
        success: (result) => {
            res(result)
        }
    })
}

