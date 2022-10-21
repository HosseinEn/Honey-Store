(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_assets_javaScript_common_js"],{

/***/ "./resources/js/assets/javaScript/common.js":
/*!**************************************************!*\
  !*** ./resources/js/assets/javaScript/common.js ***!
  \**************************************************/
/***/ (() => {

var nextBtn = document.getElementById("nextBtn");
var prevBtn = document.getElementById("prevBtn");
var movingElement = document.getElementsByClassName("changingElements");
var numberOfMovingElements = movingElement.length;
var topPositionElements = 20;
// top positioning ---> 20
// setting position
var positionDistance = 0;
for (var i = 0; i < movingElement.length; i++) {
  movingElement[i].style.top = positionDistance + "px";
  positionDistance = positionDistance + topPositionElements;
}
function nextElement() {
  nextBtn.disabled = true;
  setTimeout(function () {
    nextBtn.disabled = false;
    console.log("Button Activated");
  }, 1000);
  if (movingElement[numberOfMovingElements - 1].offsetTop == 0) {
    var positionDistance = 0;
    for (var i = 0; i < movingElement.length; i++) {
      movingElement[i].style.top = positionDistance + "px";
      positionDistance = positionDistance + topPositionElements;
    }
  } else {
    for (var i = 0; i < movingElement.length; i++) {
      movingElement[i].style.top = Math.ceil((movingElement[i].offsetTop + -topPositionElements) / 20) * 20 + "px";
    }
  }
}
function prevElement() {
  prevBtn.disabled = true;
  setTimeout(function () {
    prevBtn.disabled = false;
    console.log("Button Activated");
  }, 1000);
  if (movingElement[0].offsetTop == 0) {
    var positionDistance = topPositionElements * 2;
    for (var j = 0; j < movingElement.length; j++) {
      movingElement[j].style.top = -positionDistance + "px";
      positionDistance = positionDistance - topPositionElements;
    }
  } else {
    for (var i = 0; i < movingElement.length; i++) {
      movingElement[i].style.top = Math.ceil((movingElement[i].offsetTop + topPositionElements) / 20) * 20 + "px";
    }
  }
}

/***/ })

}]);