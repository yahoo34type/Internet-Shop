function isInteger(num) {
  return (num ^ 0) === num;
  }
  function isNumeric(n) {
  return (parseInt(n) == n && n>0 && n<2000);
}
   function pnc(n) {
    var str = document.getElementById("pagenum").value;
    var n1 = location.toString();
    var n2 = 0;
    var v = "page=" + n.toString();
    if (isNumeric(str)) 
    {
      if (n1.indexOf(v) != -1)
        n1 = n1.replace(v,"page=" + str);
      else
        n1 = n1 + "?page=" + str;
      location = n1;
    } 
    else 
    {
    alert( "Введите число" );
    }
   }
   function pnc2(n) {
    var i=1;
    var str = document.getElementById("cb" + i);
    var n2=location.toString();
    while (str != null)
    {
        if (str.checked==true)
        {
            if (n2.indexOf(str.name) != -1)
            {
              n2=n2.replace((str.name + "=0"),(str.name + "=1"))
            }
            else
            {
              if(n2.indexOf("?") != -1)
                n2 = n2 + "&" + str.name + "=1";
              else
                n2 = n2 + "?" + str.name + "=1";
            }
        }
        else
        {
            if (n2.indexOf(str.name) != -1)
            {
              n2=n2.replace((str.name + "=1"),(str.name + "=0"))
            }
            else
            {
              if (n2.indexOf("?") != -1)
                n2 = n2 + "&" + str.name + "=0";
              else
                n2 = n2 + "?" + str.name + "=0";
            }
        }
        i++;
        str = document.getElementById("cb" + i);
    }
    if (n2.indexOf("page=" + n) != -1)
            {
              n2=n2.replace(("page=" + n),("page=1"))
            }
            else
            {
              if(n2.indexOf("?") != -1)
                n2 = n2 + "&" + "page" + "=1";
              else
                n2 = n2 + "?" + "page" + "=1";
            }
    location = n2;
}