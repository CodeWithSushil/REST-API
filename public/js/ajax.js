function ajax(method, url, data=null){
  const ajax = new XMLHttpRequest();

  ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.getElementById('msg').innerHTML = this.responseText;
    }
  };

  ajax.open(method, url, true);

  if(method === "POST"){
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    const postData = JSON.stringify(data);
    ajax.send(postData);
  } else {
    ajax.send();
  }
}

function getData(url){
  const ajax = new XMLHttpRequest();

  ajax.open("GET", url, true);
  ajax.send();

  ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status ==200){
      return this.responseText;
    }
  };
}

function postData(url, data){
  if(url != ""){
    const ajax = new XMLHttpRequest();

    ajax.open("POST", url, true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    const postData = JSON.stringify(data);
    ajax.send(postData);

    ajax.onreadystatechange = function(){
      if(this.readyState == 4 && this.status ==200){
        return this.responseText;
      }
    };
  }
}
