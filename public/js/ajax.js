function ajax(method='GET', url, data=null)
{
  const ajax = new XMLHttpRequest();

  ajax.onreadystatechange = function()
  {
    if(
      this.readyState == 4 &&
      this.status == 200
    )
    {
      document.getElementById('msg')
        .innerHTML = this.responseText;
    }
  }

  ajax.(method, url, true);

  if(method === "POST")
  {
    ajax.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    const postData = JSON.stringify(data);
    ajax.send(postData);
  }
  else
  {
    ajax.send();
  }
}

