/* ---------- LOADING SCREEN ----------*/
var loadStart = Date.now();
window.addEventListener("load", function () {
  var l = document.getElementById("loader");
  if (!l) return;
  var min = parseInt(document.body.dataset.minLoad) || 0;
  var wait = Math.max(0, min - (Date.now() - loadStart));
  setTimeout(function () {
    l.classList.add("hide");
    setTimeout(function () {
      l.remove();
    }, 450);
  }, wait);
});

/* ---------- MENU ---------- */

function changeQty(btn, delta) {
  var input = btn.parentElement.querySelector("input");
  input.value = Math.max(0, (parseInt(input.value) || 0) + delta);
  updateTotal();
}

function updateTotal() {
  var total = 0,
    count = 0;
  document.querySelectorAll(".stepper input").forEach(function (i) {
    var q = parseInt(i.value) || 0;
    total += q * parseFloat(i.dataset.price);
    count += q;
  });
  var t = document.getElementById("total"),
    c = document.getElementById("count");
  if (t) t.textContent = "₱" + total.toFixed(2);
  if (c) c.textContent = count;
}

function filterMenu() {
  var q = document.getElementById("search").value.toLowerCase();
  document.querySelectorAll(".menu-item").forEach(function (card) {
    card.style.display = card.dataset.name.indexOf(q) !== -1 ? "" : "none";
  });
}

/* ---------- ADMIN: REVIEW AS IMAGE ---------- */
function exportReview(name, rating, comment, date) {
  var c = document.createElement("canvas");
  c.width = 800;
  c.height = 400;
  var x = c.getContext("2d");

  x.fillStyle = "#FBF3EA";
  x.fillRect(0, 0, 800, 400);
  x.fillStyle = "#B4543A";
  x.fillRect(0, 0, 800, 70);
  x.fillStyle = "#fff";
  x.font = "bold 28px Georgia";
  x.fillText("Merrylane Café Review", 30, 45);

  x.fillStyle = "#2E1F19";
  x.font = "22px Georgia";
  x.fillText(name, 30, 120);
  x.fillStyle = "#C98A1B";
  x.font = "34px sans-serif";
  x.fillText("★".repeat(rating) + "☆".repeat(5 - rating), 30, 170);

  x.fillStyle = "#2E1F19";
  x.font = "20px sans-serif";
  var words = comment.split(" "),
    line = "",
    y = 220;
  words.forEach(function (w) {
    if (x.measureText(line + w).width > 730) {
      x.fillText(line, 30, y);
      line = "";
      y += 30;
    }
    line += w + " ";
  });
  x.fillText(line, 30, y);

  x.fillStyle = "#7A6559";
  x.font = "16px sans-serif";
  x.fillText(date, 30, 375);

  var a = document.createElement("a");
  a.download = "review.png";
  a.href = c.toDataURL("image/png");
  a.click();
}
