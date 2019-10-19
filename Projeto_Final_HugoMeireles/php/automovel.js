$(".secundario img").on({
    "mouseover" : function() {
        newsrc="../"+this.src.substring(this.src.indexOf('/fotos')+1)
        $("#bigimage").attr("src",newsrc);
     }
   });
