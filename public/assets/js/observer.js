function Observer(url,action){
    let xmlhttp = new XMLHttpRequest()
    let temporizador
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText)
            action(response);
        }
    }
    this.start = (timeout) => {
                temporizador = setInterval(() => {
                xmlhttp.open("GET", url, false)
                xmlhttp.send()
                },timeout)}
      
    this.stop = () => {
        clearInterval(temporizador)
    }
   
}


