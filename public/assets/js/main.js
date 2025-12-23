

    const slides = document.querySelectorAll('.slide');
    let currentIndex = 0;

    function changeSlide(direction) {
      currentIndex += direction;
      if (currentIndex < 0) {
        currentIndex = slides.length - 1;
      } else if (currentIndex >= slides.length) {
        currentIndex = 0;
      }
      document.getElementById('slides').style.transform = `translateX(-${currentIndex * 100}%)`;
    }