document.querySelectorAll('.text p').forEach(el => {
   el.innerHTML = el.textContent.slice(0, 150)+'...';
});
