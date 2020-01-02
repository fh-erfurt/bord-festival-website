var countDownDate = new Date("Jul 31, 2020 18:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  var preseconds = "";
  var preminutes = "";
  var prehours = "";

  if(seconds >= 0 && seconds <= 9) {
    preseconds = "0";
  } else {
    preseconds = "";
  }

  if(minutes >= 0 && minutes <= 9) {
    preminutes = "0";
  } else {
    preminutes = "";
  }

  if(hours >= 0 && hours <= 9) {
    prehours = "0";
  } else {
    prehours = "";
  }
  console.log(prehours);

  // Display the result in the element with id="countdown"
  document.getElementById("countdown-days").innerHTML = days + " Tage";
  document.getElementById("countdown-time").innerHTML = prehours + hours + ":" + preminutes + minutes + ":" + preseconds + seconds;

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "EXPIRED";
  }
}, 1000);