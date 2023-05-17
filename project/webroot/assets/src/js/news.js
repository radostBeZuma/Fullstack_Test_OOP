(function () {
   document.querySelectorAll('.text-150 p').forEach(el => {
      el.innerHTML = el.textContent.slice(0, 150)+'...';
   });
}());
