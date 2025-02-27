function ajax(method='GET', url, data=null){
  const ajax = new XMLHttpRequest();

  onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      document.getElementById('msg').innerText = this.responseText;
    }
  }

  ajax.(method, url, true);

  if(method === "POST"){
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  }
  ajax.send(data);
  //console.log(ajax);
}

