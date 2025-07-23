document.getElementById("uploadForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("php/upload.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(data => {
      document.getElementById("result").innerHTML = data;
    })
    .catch(err => {
      document.getElementById("result").innerText = "Upload failed.";
    });
});
