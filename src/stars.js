// init
var devicePixelRatio = window.devicePixelRatio || 1;
var maxx = document.body.clientWidth;
var maxy = document.querySelector("#stars").clientHeight;
var halfx = maxx / 2;
var halfy = maxy / 2;
var canvas = document.getElementById("stars");
canvas.width = maxx * devicePixelRatio;
canvas.height = maxy * devicePixelRatio;
var context = canvas.getContext("2d");
var dotCount = 300;
var dots = [];
// create dots
for (var i = 0; i < dotCount; i++) {
  dots.push(new dot());
}

// dots animation
function render() {
  // Set background gradient
  var gradient = context.createLinearGradient(0, 0, maxx, maxy);
  gradient.addColorStop(0.112, "rgb(0, 0, 0)");
  gradient.addColorStop(0.512, "rgb(49, 16, 74)");
  gradient.addColorStop(0.986, "rgb(88, 28, 135)");

  context.fillStyle = gradient;
  context.fillRect(0, 0, maxx, maxy);
  for (var i = 0; i < dotCount; i++) {
    dots[i].draw();
    dots[i].move();
  }
  requestAnimationFrame(render);
}

// dots class
// @constructor
function dot() {
  this.rad_x = 2 * Math.random() * halfx + 1;
  this.rad_y = 1.2 * Math.random() * halfy + 1;
  this.alpha = Math.random() * 360 + 1;
  this.speed = Math.random() * 100 < 50 ? 1 : -1;
  this.speed *= 0.05;
  this.size = Math.random() * 2 + 1;
  this.color = Math.floor(Math.random() * 256);
}

// drawing dot
dot.prototype.draw = function () {
  var dx = halfx + this.rad_x * Math.cos((this.alpha / 180) * Math.PI);
  var dy = halfy + this.rad_y * Math.sin((this.alpha / 180) * Math.PI);
  context.fillStyle = "rgb(255,255,255)";
  context.beginPath();
  context.arc(dx, dy, this.size, 0, 2 * Math.PI);
  context.fill();
};

// calc new position in polar coord
dot.prototype.move = function () {
  this.alpha += this.speed;
  // change color
  if (Math.random() * 100 < 50) {
    this.color += 1;
  } else {
    this.color -= 1;
  }
};

// start animation
render();
