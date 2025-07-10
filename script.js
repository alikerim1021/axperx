window.addEventListener("load", () => {
  setTimeout(() => {
    document.getElementById("loader").style.display = "none";
    document.getElementById("main").classList.remove("hidden");
  }, 2500);
});
