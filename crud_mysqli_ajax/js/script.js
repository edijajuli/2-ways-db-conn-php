const keyword = document.getElementById("keyword");
const tombolCari = document.getElementById("tombol-cari");
const container = document.getElementById("container");

keyword.addEventListener("keyup", function () {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      container.innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "ajax/mahasiswa.php? keyword=" + keyword.value, true);
  xhr.send();
});
