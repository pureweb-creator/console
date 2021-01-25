var btn = document.getElementById("theme-swither");
var link = document.getElementById("theme-link");

btn.addEventListener("click", function () { ChangeTheme(); });

function ChangeTheme() {
    let lightTheme = "";
    let darkTheme = "css/dark_theme.min.css";

    var currTheme = link.getAttribute("href");
    var theme = "";

    if(currTheme != darkTheme){
   	  currTheme = darkTheme;
   	  theme = "dark_theme";
    } else {    
   	  currTheme = "";
   	  theme = "default";
    }

    link.setAttribute("href", currTheme);

    save(theme);
}

function save(theme){
  var request = new XMLHttpRequest();
  request.open("GET",  "php/themes.php?theme=" + theme, true);
  request.send();

}