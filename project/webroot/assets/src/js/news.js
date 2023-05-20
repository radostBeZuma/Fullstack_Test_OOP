(function () {
   const textCrop = document.querySelectorAll('.text-150 p');

   if(textCrop) {
      function trStr(text, width) {
         if (text.length > width) { return text.slice(0, width).trim() + "..."; }
         else { return text; }
      }

      textCrop.forEach(el => {
         el.innerHTML = trStr(el.textContent, 150);
      });
   }
}());
