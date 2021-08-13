function name_function() {
    tempoRestante = fetch('https://api.ipify.org/?format=json').then(function(response) {
        return response.text();
        }).then(function(html) {
            return html;
        })
        return tempoRestante;
}

console.log(name_function());